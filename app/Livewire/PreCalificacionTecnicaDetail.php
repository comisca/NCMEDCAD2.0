<?php

namespace App\Livewire;

use App\Mail\NotificationRequeriment;
use App\Models\DocumentApplications;
use App\Models\NotificationsApplications;
use App\Models\ReqApplications;
use App\Models\ReqRelationProduts;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Component;
use Session;
use DB;

class PreCalificacionTecnicaDetail extends Component
{

    use WithPagination;
    use WithFileUploads;

    public $Pagination = 10;
    public $searchInput;
    public $apllicationI, $nameDoc, $descriptionDoc, $docFile, $reqApplicationID, $otroid;
    public $docDatas = [], $docGlobalView, $selectStates, $messagesSends, $observacionesGlobals;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount($id)
    {
        $this->otroid = $id;

    }

    public function updated()
    {


    }


    public function render()
    {
        $this->apllicationID = $this->otroid;

        $dataApplication =
            ReqApplications::join('requisitos', 'requisitos.id', '=', 'req_applications.requirement_id')
                ->join('medicamentos', 'medicamentos.id', '=', 'req_applications.product_id')
                ->join('grupos_requisitos', 'grupos_requisitos.id', '=', 'requisitos.grupo_requisito_id')
                ->where('req_applications.application_id', $this->apllicationID)
                ->where('req_applications.status', 1)
                ->select(
                    'grupos_requisitos.grupo as grupo_nombre',
                    'req_applications.id',
                    'requisitos.codigo',
                    'requisitos.descripcion',
                    'req_applications.states_req_applications',
                )
                ->orderBy('grupos_requisitos.grupo')
                ->get()
                ->groupBy('grupo_nombre') // Agrupa por 'grupo_nombre' en lugar de 'grupos_requisitos.grupo'
                ->collect(); // Convierte a colección de soporte
        return view('livewire.companies.pre-calificacion-tecnica-detail', ['dataApplication' => $dataApplication])
            ->extends('layouts.master')
            ->section('content');
    }

    public function showFormChangeState($id)
    {
        $this->reqApplicationID = $id;
        $this->dispatch('showFormChangeState');

    }

    public function chageStateRequeriment()
    {
        $rules = [
            'messagesSends' => 'required',
            'selectStates' => 'required',


        ];
        $messages = [
            'messagesSends.required' => 'El mensaje es requerido',
            'selectStates.required' => 'El estado es requerido',

        ];

        $this->validate($rules, $messages);

        try {
            Db::beginTransaction();

            $newNotification = NotificationsApplications::create([
                'req_application_id' => $this->reqApplicationID,
                'message' => $this->messagesSends,
                'distribuidor_id' => 0,
                'status' => 1
            ]);

            ReqApplications::where('id', $this->reqApplicationID)
                ->update([
                    'states_req_applications' => $this->selectStates
                ]);

            if ($this->selectStates == 3) {
                $dataSends =
                    ReqApplications::join('requisitos', 'requisitos.id', '=', 'req_applications.requirement_id')
                        ->join('medicamentos', 'medicamentos.id', '=', 'req_applications.product_id')
                        ->join('companies', 'companies.id', '=', 'req_applications.distribution_id')
                        ->where('req_applications.id', $this->reqApplicationID)
                        ->where('req_applications.status', 1)
                        ->select(
                            'req_applications.id',
                            'requisitos.codigo',
                            'requisitos.descripcion',
                            'req_applications.states_req_applications',
                            'medicamentos.cod_medicamento',
                            'medicamentos.descripcion as medicamento_descripcion',
                            'companies.email',
                        )->first();
                Mail::to($dataSends->email)->send(new NotificationRequeriment($dataSends->cod_medicamento . '-'
                    . $dataSends->medicamento_descripcion,
                    $dataSends->descripcion,
                    $this->messagesSends,
                    'Observacion'));
            }

            DB::commit();

            $this->reqApplicationID = '';
            $this->selectStates = '';
            $this->messagesSends = '';
            $this->dispatch('chageStateRequerimentSuccess', message: 'Estado cambiado correctamente');

        } catch (\Throwable $e) {
            //este metodo lo que hace es deshacer los cambios en la base de datos
            DB::rollback();

            //este metodo lo que hace es mostrar el error en la consola
            dd($e->getMessage());
        }

    }

    public function showObservacionRequerimont($id)
    {
        $this->reqApplicationID = $id;
        $this->observacionesGlobals = NotificationsApplications::where('req_application_id', $id)->get();

        $this->dispatch('showObservacionRequerimont');

    }

    public function viewDocAdm($id)
    {

        $this->docGlobalView = DocumentApplications::where('id', $id)->first();
        $this->dispatch('viewDocAdmShow');

    }

    public function showDoc($id)
    {
        $this->reqApplicationID = $id;
        $this->docDatas = [];
        $this->docDatas = DocumentApplications::where('req_application_id', $id)->get();
//        dd($this->docDatas);
        $this->dispatch('showDoc');


    }


    public function showUpDoc($id)
    {
        $this->reqApplicationID = $id;
        $this->dispatch('showUpDoc');


    }

    public function createDocUp()
    {

        $rules = [
            'nameDoc' => 'required',
            'descriptionDoc' => 'required',
            'docFile' => 'required',

        ];
        $messages = [
            'nameDoc.required' => 'El nombre del documento es requerido',
            'descriptionDoc.required' => 'La descripcion del documento es requerida',
            'docFile.required' => 'El documento es requerido',
        ];

        $this->validate($rules, $messages);

        try {
            if ($this->docFile) {
                //Guardamos la imagen en la carpeta publica
                $doc_name = 'doc_' . uniqid() . '.' . $this->docFile->extension();
                $avatarurl = $this->docFile->storeAs('public/document/companies', $doc_name);
            } else {
                $doc_name = '';
            }
            Db::beginTransaction();

            $newDoc = DocumentApplications::create([
                'req_application_id' => $this->reqApplicationID,
                'document_name' => $this->nameDoc,
                'descriptions' => $this->descriptionDoc,
                'attachment' => $doc_name,
                'status' => 1
            ]);


            DB::commit();
            $this->reqApplicationID = '';
            $this->nameDoc = '';
            $this->descriptionDoc = '';
            $this->docFile = '';
            $this->dispatch('upDocSuccess', message: 'Documento subido correctamente');

        } catch (\Throwable $e) {
            //este metodo lo que hace es deshacer los cambios en la base de datos
            DB::rollback();

            //este metodo lo que hace es mostrar el error en la consola
            dd($e->getMessage());
        }
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
