<?php

namespace App\Livewire;

use App\Mail\ActaFichaTecnica;
use App\Mail\NotificationRequeriment;
use App\Models\Application;
use App\Models\Companies;
use App\Models\DocumentApplications;
use App\Models\NotificationsApplications;
use App\Models\ReqApplications;
use App\Models\ReqRelationProfileTable;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Component;
use Session;
use DB;

class DetailPrecaAdminComponent extends Component
{

    use WithPagination;
    use WithFileUploads;

    public $Pagination = 10;
    public $searchInput, $messagesSendsAplications, $apllicationID;
    public $apllicationI, $nameDoc, $descriptionDoc, $docFile, $reqApplicationID, $otroid;
    public $docDatas = [], $docGlobalView, $selectStates, $messagesSends, $observacionesGlobals, $sendNotificationsCompanies;
    public $inputDateVence, $dataVenceInput, $nameTableRelations, $limitObservations;
    public $offset = 0; //;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount($id)
    {
        $this->otroid = $id;
        $this->limitObservations = 1;

    }


    public function render()
    {

        $this->apllicationID = $this->otroid;

        $applicationsData = Companies::where('id', $this->apllicationID)->first();
//        $dataApplication =
//            Application::join('companies', 'applications.fabric_id', '=', 'companies.id')
//                ->join('req_relation_profile_tables',
//                    'applications.fabric_id',
//                    '=',
//                    'req_relation_profile_tables.company_id')
//                ->join('requisitos', 'requisitos.id', '=', 'req_relation_profile_tables.req_id')
//                ->where('applications.distribution_id', $this->apllicationID)
//                ->where('req_relation_profile_tables.status', '<=', 5)
//                ->select(
//                    'companies.legal_name as grupo_nombre',
//                    'req_relation_profile_tables.id',
//                    'requisitos.codigo',
//                    'requisitos.descripcion',
//                    'requisitos.obligatorio',
//                    'requisitos.entregable',
//                    'requisitos.vence',
//                    'req_relation_profile_tables.date_vence',
//                    'req_relation_profile_tables.status',
//                )
//                ->orderBy('requisitos.descripcion')
//                ->get()
//                ->groupBy('grupo_nombre') // Agrupa por 'grupo_nombre' en lugar de 'grupos_requisitos.grupo'
//                ->collect(); // Convierte a colección de soporte


        $dataFabricantes = Application::join('companies', 'applications.fabric_id', '=', 'companies.id')
            ->join('req_relation_profile_tables',
                'applications.fabric_id',
                '=',
                'req_relation_profile_tables.company_id')
            ->join('requisitos', 'requisitos.id', '=', 'req_relation_profile_tables.req_id')
            ->where('req_relation_profile_tables.application_id', $this->apllicationID)
            ->where('applications.status', '>=', 1)
            ->select(
                'companies.legal_name as grupo_nombre',
                'req_relation_profile_tables.id',
                'requisitos.codigo',
                'requisitos.descripcion',
                'requisitos.obligatorio',
                'requisitos.entregable',
                'requisitos.vence',
                'req_relation_profile_tables.date_vence',
                'req_relation_profile_tables.status',
            )
            ->orderBy('requisitos.descripcion')
            ->get()
            ->groupBy('grupo_nombre') // Agrupa por 'grupo_nombre' en lugar de 'grupos_requisitos.grupo'
            ->collect(); // Convierte a colección de soporte


        $dataDistribuidores = Application::join('companies', 'applications.distribution_id', '=', 'companies.id')
            ->join('req_relation_profile_tables',
                'applications.distribution_id',
                '=',
                'req_relation_profile_tables.company_id')
            ->join('requisitos', 'requisitos.id', '=', 'req_relation_profile_tables.req_id')
            ->where('req_relation_profile_tables.application_id', $this->apllicationID)
            ->where('applications.status', '>=', 1)
            ->select(
                'companies.legal_name as grupo_nombre',
                'req_relation_profile_tables.id',
                'requisitos.codigo',
                'requisitos.descripcion',
                'requisitos.obligatorio',
                'requisitos.entregable',
                'requisitos.vence',
                'req_relation_profile_tables.date_vence',
                'req_relation_profile_tables.status',
            )
            ->orderBy('requisitos.descripcion')
            ->get()
            ->groupBy('grupo_nombre') // Agrupa por 'grupo_nombre' en lugar de 'grupos_requisitos.grupo'
            ->collect(); // Convierte a colección de soporte


        $dataApplication = [
            'Fabricantes' => $dataFabricantes,
            'Distribuidores' => $dataDistribuidores
        ];
        $applicationsola = Application::join('familia_producto', 'applications.family_id', '=', 'familia_producto.id')
            ->join('medicamentos', 'applications.product_id', '=', 'medicamentos.id')
            ->join('companies', 'applications.fabric_id', '=', 'companies.id')
            ->select('applications.*',
                'medicamentos.descripcion',
                'medicamentos.cod_medicamento',
                'companies.legal_name',
                'companies.email',
                'applications.id',
                DB::raw('(SELECT COUNT(*) FROM req_applications WHERE req_applications.states_req_applications > 3 AND req_applications.application_id = applications.id) as req_applications_count'))
            ->where('applications.id', $this->apllicationID)
            ->where('applications.status', '>=', 1)
            ->first();

        return view('livewire.detail-preca-admin-component',
            ['dataRequisitos' => $dataApplication,
                'applicationsData' => $applicationsData,
                'applicationsola' => $applicationsola])
            ->extends('layouts.master')
            ->section('content');
    }


    public function showFormChangeState($id)
    {
        $this->reqApplicationID = $id;
        $this->nameTableRelations = 'req_relation_profile_tables';
        $this->dispatch('showFormChangeState');
    }

    public function sendSendApplicationModal()
    {


        $rules = [
            'messagesSendsAplications' => 'required',


        ];
        $messages = [
            'messagesSendsAplications.required' => 'El mensaje es requerido',
        ];

        $this->validate($rules, $messages);

        try {
            DB::beginTransaction();

            $newNotification = NotificationsApplications::create([
                'application_id' => $this->apllicationID,
                'message' => $this->messagesSendsAplications,
                'distribuidor_id' => 0,
                'status' => 1
            ]);
            $applicationsData =
                Application::join('familia_producto', 'applications.family_id', '=', 'familia_producto.id')
                    ->join('medicamentos', 'applications.product_id', '=', 'medicamentos.id')
                    ->join('companies', 'applications.distribution_id', '=', 'companies.id')
                    ->select('applications.*',
                        'medicamentos.descripcion',
                        'medicamentos.cod_medicamento',
                        'companies.legal_name',
                        'companies.email',
                        'companies.address',
                        'companies.phone',
                        'companies.city',
                        'applications.id',
                        'applications.status',
                        DB::raw('(SELECT COUNT(*) FROM req_applications WHERE req_applications.states_req_applications > 3 AND req_applications.application_id = applications.id) as req_applications_count'))
                    ->where('applications.id', $this->apllicationID)
                    ->where('applications.status', '>=', 1)
                    ->first();

            $dataFabricantes = Application::join('companies', 'applications.fabric_id', '=', 'companies.id')
                ->join('req_relation_profile_tables',
                    'applications.fabric_id',
                    '=',
                    'req_relation_profile_tables.company_id')
                ->join('requisitos', 'requisitos.id', '=', 'req_relation_profile_tables.req_id')
                ->where('req_relation_profile_tables.application_id', $this->apllicationID)
                ->where('applications.status', '>=', 1)
                ->select(
                    'companies.legal_name as grupo_nombre',
                    'req_relation_profile_tables.id',
                    'requisitos.codigo',
                    'requisitos.descripcion',
                    'requisitos.obligatorio',
                    'requisitos.entregable',
                    'requisitos.vence',
                    'req_relation_profile_tables.date_vence',
                    'req_relation_profile_tables.status',
                )
                ->orderBy('requisitos.descripcion')
                ->get()
                ->groupBy('grupo_nombre') // Agrupa por 'grupo_nombre' en lugar de 'grupos_requisitos.grupo'
                ->collect(); // Convierte a colección de soporte


            $dataDistribuidores = Application::join('companies', 'applications.distribution_id', '=', 'companies.id')
                ->join('req_relation_profile_tables',
                    'applications.distribution_id',
                    '=',
                    'req_relation_profile_tables.company_id')
                ->join('requisitos', 'requisitos.id', '=', 'req_relation_profile_tables.req_id')
                ->where('req_relation_profile_tables.application_id', $this->apllicationID)
                ->where('applications.status', '>=', 1)
                ->select(
                    'companies.legal_name as grupo_nombre',
                    'req_relation_profile_tables.id',
                    'requisitos.codigo',
                    'requisitos.descripcion',
                    'requisitos.obligatorio',
                    'requisitos.entregable',
                    'requisitos.vence',
                    'req_relation_profile_tables.date_vence',
                    'req_relation_profile_tables.status',
                )
                ->orderBy('requisitos.descripcion')
                ->get()
                ->groupBy('grupo_nombre') // Agrupa por 'grupo_nombre' en lugar de 'grupos_requisitos.grupo'
                ->collect(); // Convierte a colección de soporte


            $dataApplication = [
                'Fabricantes' => $dataFabricantes,
                'Distribuidores' => $dataDistribuidores
            ];


            $viewData = compact('applicationsData', 'dataApplication');

            $pdf = Pdf::loadView('pdfs.pdf-acta-ficha-admin', $viewData)
                ->setPaper('a4')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'defaultFont' => 'helvetica',
                ]);

            $filename =
                'acta-recepcion-docA-' . $applicationsData->llegal_name . '-' . $applicationsData->cod_medicamento .
                '.pdf';

            $pdfContent = $pdf->output();
            Storage::disk('local')->put('temp/' . $filename, $pdfContent);

            Mail::to($applicationsData->email)->send(new ActaFichaTecnica($applicationsData->cod_medicamento . '-'
                . $applicationsData->descripcion,
                $applicationsData->descripcion,
                $this->messagesSendsAplications,
                'Notificacion', $filename));
            Storage::disk('local')->delete('temp/' . $filename);

            DB::commit();

            $this->messagesSendsAplications = '';

            $this->dispatch('sendSendApplicationSuccess', message: 'Notificacion enviada correctamente');
        } catch (\Throwable $e) {
            //este metodo lo que hace es deshacer los cambios en la base de datos
            DB::rollback();

            //este metodo lo que hace es mostrar el error en la consola
            dd($e->getMessage());
        }
    }

    public function precalificarReq()
    {


        $dataReqApplication = ReqRelationProfileTable::where('application_id', $this->apllicationID)
            ->where('status', '=', 0)
            ->count();


        if ($dataReqApplication <= 0) {

            Application::where('id', $this->apllicationID)
                ->update([
                    'calification_admin' => 1
                ]);

            $this->dispatch('precalificarReqExito',
                message: 'La precalificacion fue todo un exito');

        } else {
            Application::where('id', $this->apllicationID)
                ->update([
                    'calification_admin' => 0
                ]);

            $this->dispatch('precalificarReq',
                message: 'No se puede precalificar la solicitud, aun hay requerimientos pendientes');
        }


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


            ReqRelationProfileTable::where('id', $this->reqApplicationID)
                ->update([
                    'status' => $this->selectStates,
                ]);
            if ($this->selectStates == 0) {
                Application::where('id', $this->apllicationID)
                    ->update([
                        'calification_admin' => 0
                    ]);
            }

//            if ($this->selectStates == 3) {
//                $dataSends =
//                    ReqApplications::join('requisitos', 'requisitos.id', '=', 'req_applications.requirement_id')
//                        ->join('medicamentos', 'medicamentos.id', '=', 'req_applications.product_id')
//                        ->join('companies', 'companies.id', '=', 'req_applications.distribution_id')
//                        ->where('req_applications.id', $this->reqApplicationID)
//                        ->where('req_applications.status', 1)
//                        ->select(
//                            'req_applications.id',
//                            'requisitos.codigo',
//                            'requisitos.descripcion',
//                            'req_applications.states_req_applications',
//                            'medicamentos.cod_medicamento',
//                            'medicamentos.descripcion as medicamento_descripcion',
//                            'companies.email',
//                        )->first();
//                //                Mail::to($dataSends->email)->send(new NotificationRequeriment($dataSends->cod_medicamento . '-'
//                //                    . $dataSends->medicamento_descripcion,
//                //                    $dataSends->descripcion,
//                //                    $this->messagesSends,
//                //                    'Observacion'));
//            }

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

    public function viewMoreObservations()
    {
        $this->limitObservations = 20;
        // No necesitas incrementar el offset aquí
        $this->observacionesGlobals = NotificationsApplications::where('req_application_id', $this->reqApplicationID)
            ->orderBy('id', 'desc')
            ->limit($this->limitObservations)
            ->get();
    }

    #[On('showViewObservationsJSA')]
    public function showObservacionRequerimont($id)
    {

        $this->nameTableRelations = 'req_relation_profile_tables';
        $this->reqApplicationID = $id;
        $this->observacionesGlobals = NotificationsApplications::where('req_application_id', $id)
            ->orderBy('id', 'desc')
            ->offset($this->offset)
            ->limit($this->limitObservations)
            ->get();

        $this->dispatch('showObservacionRequerimont');
    }

    public function viewDocAdm($id)
    {

        $this->docGlobalView = DocumentApplications::where('id', $id)->first();
        $this->dispatch('viewDocAdmShow');
    }

    #[On('showDocumentsJSA')]
    public function showDoc($id)
    {
        $this->nameTableRelations = 'req_relation_profile_tables';
        $this->reqApplicationID = $id;
        $this->docDatas = [];
        $this->docDatas = DocumentApplications::where('req_application_id', $id)
            ->where('name_table', 'req_relation_profile_tables')
            ->get();
        //        dd($this->docDatas);
        $this->dispatch('showDoc');
    }

    #[On('showUpDocumentsJSA')]
    public function showUpDoc($id, $dataVenceparameter)
    {
        $this->dataVenceInput = $dataVenceparameter;

        $this->nameTableRelations = 'req_relation_profile_tables';
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


            DocumentApplications::where('req_application_id', $this->reqApplicationID)
                ->where('name_table', 'req_relation_profile_tables')
                ->update([
                    'status' => 0
                ]);


            $newDoc = DocumentApplications::create([
                'req_application_id' => $this->reqApplicationID,
                'document_name' => $this->nameDoc,
                'descriptions' => $this->descriptionDoc,
                'attachment' => $doc_name,
                'name_table' => 'req_relation_profile_tables',
                'status' => 1
            ]);


            if ($this->dataVenceInput == 1) {
                ReqRelationProfileTable::where('id', $this->reqApplicationID)
                    ->update([
                        'status' => 5,
                        'date_vence' => $this->inputDateVence
                    ]);
            } else {
                ReqRelationProfileTable::where('id', $this->reqApplicationID)
                    ->update([
                        'status' => 5
                    ]);
            }


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
