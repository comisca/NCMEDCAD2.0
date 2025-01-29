<?php

namespace App\Livewire;

use App\Mail\StateChanges;
use App\Models\Companies;
use App\Models\DocumentsTables;
use App\Models\ReqRelationProfile;
use App\Models\ReqRelationProfileTable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;
use Session;
use DB;

class ListCompanyComponent extends Component
{

    use WithPagination;

    public $pagination = 10;
    public $searchInput;
    public $companyDataDetail, $documentDataDetail, $viewVisorPdf, $messagesSends;
    public $idCompanyChanges, $stateChangeGlobal;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {

    }


    public function render()
    {

        if (strlen($this->searchInput) > 0) {

            $companies = Companies::orderBy('id', 'desc')
                ->where('status', '>=', 0)
                ->where('legal_name', 'like', '%' . $this->searchInput . '%')
                ->paginate($this->pagination);

        } else {
            $companies = Companies::orderBy('id', 'desc')
                ->where('status', '>=', 0)
                ->paginate($this->pagination);
        }


        return view('livewire.list-company-component', ['companies' => $companies])
            ->extends('layouts.master')
            ->section('content');
    }

    #[On('detailCompany')]
    public function detailCompany($id)
    {
        $this->companyDataDetail = Companies::find($id);

        $this->documentDataDetail = DocumentsTables::where('table_id', $id)
            ->where('table_name', 'companies')
            ->get();

//        dd($this->documentDataDetail);


        $this->dispatch('detail_company', ['id' => $id]);

    }

    public function viewPdfVisor($id)
    {

        $this->viewVisorPdf = DocumentsTables::find($id);
        $this->dispatch('view-visor-pdf', ['idDocumentDetail' => $id]);

    }

    public function create()
    {
        try {
            //este metodo lo que hace es inicailizar las transacciones en la base de datos
            DB::beginTransaction();

            //Aqui se escribe el codigo que se desea hacer en la transaccion

            //este metodo lo que hace es guardar los cambios en la base de datos
            DB::commit();

        } catch (\Throwable $e) {
            //este metodo lo que hace es deshacer los cambios en la base de datos
            DB::rollback();

            //este metodo lo que hace es mostrar el error en la consola
            dd($e->getMessage());
        }
    }

    public function changesStates($id, $stateChanges)
    {
        $this->idCompanyChanges = $id;
        $this->stateChangeGlobal = $stateChanges;

        $this->dispatch('changes-states-show', ['idCompanyChanges' => $id, 'stateChangeGlobal' => $stateChanges]);


    }

    function generatePassword($minLength = 6, $maxLength = 8)
    {
        $length = rand($minLength, $maxLength);
        return Str::random($length);
    }

    public function changeStateCompany()
    {

        try {

            DB::beginTransaction();

            if ($this->stateChangeGlobal == 1) {
                $password = $this->generatePassword();
                $company = Companies::find($this->idCompanyChanges);
                $company->password = Hash::make($password);
                $company->status = 1;
                $company->save();

                $reqAdmin = ReqRelationProfile::where('type_profile', $company->type_company)
                    ->where('status', 1)
                    ->get();

                if (!empty($reqAdmin)) {
                    foreach ($reqAdmin as $itemReq) {

                        ReqRelationProfileTable::create([
                            'company_id' => $company->id,
                            'req_id' => $itemReq->req_id,
                            'type_profile' => $company->type_company,
                            'status' => 1
                        ]);

                    }
                }

            } else {

                $password = $this->generatePassword();
                $company = Companies::find($this->idCompanyChanges);
                $company->status = 0;
                $company->save();

            }

            Mail::to($company->email)->send(new StateChanges($company->legal_name,
                $this->stateChangeGlobal,
                $this->messagesSends, $password, $company->user_name));


            DB::commit();

            $this->dispatch('success_messages_changes',
                messages: 'El estado de la empresa ha sido cambiado correctamente');

        } catch (\Throwable $e) {
            //este metodo lo que hace es deshacer los cambios en la base de datos
            DB::rollback();

            //este metodo lo que hace es mostrar el error en la consola
            dd($e->getMessage());
        }

    }


    public function acceptedComapny($id)
    {
        try {
            //este metodo lo que hace es inicailizar las transacciones en la base de datos
            DB::beginTransaction();

            $company = Companies::find($id);
            $company->status = 1;
            $company->save();

            //este metodo lo que hace es guardar los cambios en la base de datos
            DB::commit();
            $this->dispatch('success_messages', messages: 'La empresa ha sido aceptada correctamente');


        } catch (\Throwable $e) {
            //este metodo lo que hace es deshacer los cambios en la base de datos
            DB::rollback();

            //este metodo lo que hace es mostrar el error en la consola
//               dd($e->getMessage());
            $this->dispatch('error_messages', messages: 'Ocurrio un error al aceptar la empresa');
        }

    }

    public function rejectedCompany($id)
    {
        try {
            //este metodo lo que hace es inicailizar las transacciones en la base de datos
            DB::beginTransaction();

            $company = Companies::find($id);
            $company->status = 0;
            $company->save();

            //este metodo lo que hace es guardar los cambios en la base de datos
            DB::commit();
            $this->dispatch('success_messages', messages: 'La empresa ha sido rechazada correctamente');


        } catch (\Throwable $e) {
            //este metodo lo que hace es deshacer los cambios en la base de datos
            DB::rollback();
            $this->dispatch('error_messages', messages: 'Ocurrio un error al aceptar la empresa');

            //este metodo lo que hace es mostrar el error en la consola
        }

    }


    public function update()
    {
        try {
            //este metodo lo que hace es inicailizar las transacciones en la base de datos
            DB::beginTransaction();

            //Aqui se escribe el codigo que se desea hacer en la transaccion

            //este metodo lo que hace es guardar los cambios en la base de datos
            DB::commit();

        } catch (\Throwable $e) {
            //este metodo lo que hace es deshacer los cambios en la base de datos
            DB::rollback();

            //este metodo lo que hace es mostrar el error en la consola
            dd($e->getMessage());
        }
    }


    public function deletexid()
    {
        try {
            //este metodo lo que hace es inicailizar las transacciones en la base de datos
            DB::beginTransaction();

            //Aqui se escribe el codigo que se desea hacer en la transaccion

            //este metodo lo que hace es guardar los cambios en la base de datos
            DB::commit();

        } catch (\Throwable $e) {
            //este metodo lo que hace es deshacer los cambios en la base de datos
            DB::rollback();

            //este metodo lo que hace es mostrar el error en la consola
            dd($e->getMessage());
        }
    }


    public function resetUI()
    {


    }

}
