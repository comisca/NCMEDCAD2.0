<?php

namespace App\Livewire;

use App\Mail\ActaRecepcionDoc;
use App\Mail\NotificationRequeriment;
use App\Models\Application;
use App\Models\Companies;
use App\Models\DocumentApplications;
use App\Models\DocumentsTables;
use App\Models\NotificationsApplications;
use App\Models\ReqApplications;
use App\Models\ReqRelationProfile;
use App\Models\ReqRelationProfileTable;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Session;
use DB;

class RecepDocumentsDetailComponent extends Component
{

    use WithPagination;
    use WithFileUploads;

    public $Pagination = 10;
    public $searchInput, $messagesSendsAplications, $apllicationID, $selectedRequeriment;
    public $apllicationI, $nameDoc, $descriptionDoc, $docFile, $reqApplicationID, $otroid;
    public $docDatas = [], $docGlobalView, $selectStates, $messagesSends, $observacionesGlobals, $sendNotificationsCompanies;
    public $dataRequisitos, $idCompany, $nameTableRelations, $dataVenceInput, $inputDateVence;
    public $documentDataDetail, $limitObservations;
    public $offset = 0; //

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount($id, $idCompany)
    {
        $this->otroid = $id;
        $this->apllicationID = $this->otroid;
        $this->idCompany = $idCompany;
        $this->limitObservations = 1;
    }

    public function updated()
    {
        if ($this->selectedRequeriment == 'T') {

            $this->dataRequisitos =
                ReqApplications::join('requisitos', 'requisitos.id', '=', 'req_applications.requirement_id')
                    ->join('medicamentos', 'medicamentos.id', '=', 'req_applications.product_id')
                    ->join('grupos_requisitos', 'grupos_requisitos.id', '=', 'requisitos.grupo_requisito_id')
                    ->where('req_applications.application_id', $this->apllicationID)
                    ->where('req_applications.status', '>=', 1)
                    ->select(
                        'grupos_requisitos.grupo as grupo_nombre',
                        'req_applications.id',
                        'requisitos.codigo',
                        'requisitos.descripcion',
                        'requisitos.obligatorio',
                        'requisitos.entregable',
                        'requisitos.vence',
                        'req_applications.date_vence',
                        'req_applications.states_req_applications',
                    )
                    ->orderBy('grupos_requisitos.grupo')
                    ->get()
                    ->groupBy('grupo_nombre') // Agrupa por 'grupo_nombre' en lugar de 'grupos_requisitos.grupo'
                    ->collect(); // Convierte a colección de soporte

        } else {
            $company = Companies::where('id', $this->idCompany)->first();

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


            $this->dataRequisitos = [
                'Fabricantes' => $dataFabricantes,
                'Distribuidores' => $dataDistribuidores
            ];

        }
    }

    public function createActaReceive()
    {

        if ($this->selectedRequeriment == 'T') {

            $dataRequiurementsF =
                ReqApplications::join('requisitos', 'requisitos.id', '=', 'req_applications.requirement_id')
                    ->join('medicamentos', 'medicamentos.id', '=', 'req_applications.product_id')
                    ->join('grupos_requisitos', 'grupos_requisitos.id', '=', 'requisitos.grupo_requisito_id')
                    ->where('req_applications.application_id', $this->apllicationID)
                    ->where('req_applications.status', '>=', 1)
                    ->select(
                        'grupos_requisitos.grupo as grupo_nombre',
                        'req_applications.id',
                        'requisitos.codigo',
                        'requisitos.descripcion',
                        'requisitos.obligatorio',
                        'requisitos.entregable',
                        'requisitos.vence',
                        'req_applications.date_vence',
                        'req_applications.states_req_applications',
                    )
                    ->orderBy('grupos_requisitos.grupo')
                    ->get()
                    ->groupBy('grupo_nombre') // Agrupa por 'grupo_nombre' en lugar de 'grupos_requisitos.grupo'
                    ->collect(); // Convierte a colección de soporte

        } else {
            $company = Companies::where('id', $this->idCompany)->first();

//            $dataRequiurementsD = Application::join('companies', 'applications.fabric_id', '=', 'companies.id')
//                ->join('req_relation_profile_tables',
//                    'applications.fabric_id',
//                    '=',
//                    'req_relation_profile_tables.company_id')
//                ->join('requisitos', 'requisitos.id', '=', 'req_relation_profile_tables.req_id')
//                ->where('applications.distribution_id', $this->idCompany)
//                ->where('applications.status', '>=', 1)
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


            $dataRequiurementsD = [
                'Fabricantes' => $dataFabricantes,
                'Distribuidores' => $dataDistribuidores
            ];


        }
        $dataApplicant = Application::join('familia_producto', 'applications.family_id', '=', 'familia_producto.id')
            ->join('medicamentos', 'applications.product_id', '=', 'medicamentos.id')
            ->join('companies', 'applications.fabric_id', '=', 'companies.id')
            ->select(
                'applications.*',
                'medicamentos.descripcion',
                'medicamentos.cod_medicamento',
                'companies.legal_name',
                'companies.email',
                'applications.id',
                DB::raw('(SELECT COUNT(*) FROM req_applications WHERE req_applications.states_req_applications = 3 AND req_applications.application_id = applications.id) as req_applications_count')
            )
            ->where('applications.id', $this->apllicationID)
            ->where('applications.status', '>=', 1)
            ->first();
        if ($this->selectedRequeriment == 'T') {
            // Genera el PDF
            $viewData = compact('dataApplicant', 'dataRequiurementsF');
            $pdf = Pdf::loadView('pdfs.pdf-recepcion-doc', $viewData)
                ->setPaper('a4')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'defaultFont' => 'helvetica',
                ]);

            // Nombre del archivo PDF
//        $filename = 'acta-' . $id . '-event.pdf';

            // Retorna el PDF como descarga
            return response()->streamDownload(
                function () use ($pdf) {
                    echo $pdf->output();
                },
                'acta-recepcion-doc-' . $dataApplicant->llegal_name . '-' . $dataApplicant->cod_medicamento . '.pdf'
            );
        } else {
            // Genera el PDF
            $viewData2 = compact('dataApplicant', 'dataRequiurementsD');
            $pdf2 = Pdf::loadView('pdfs.pdf-recepcion-doc2', $viewData2)
                ->setPaper('a4')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'defaultFont' => 'helvetica',
                ]);

            // Nombre del archivo PDF
//        $filename = 'acta-' . $id . '-event.pdf';

            // Retorna el PDF como descarga
            return response()->streamDownload(
                function () use ($pdf2) {
                    echo $pdf2->output();
                },
                'acta-recepcion-doc-' . $dataApplicant->llegal_name . '-' . $dataApplicant->cod_medicamento . '.pdf'
            );
        }


//        Mail::to($dataPf->email)->send(new ActaRecepcionDoc());


    }


    public function render()
    {


        $applicationsData = Application::join('familia_producto', 'applications.family_id', '=', 'familia_producto.id')
            ->join('medicamentos', 'applications.product_id', '=', 'medicamentos.id')
            ->join('companies', 'applications.fabric_id', '=', 'companies.id')
            ->select(
                'applications.*',
                'medicamentos.descripcion',
                'medicamentos.cod_medicamento',
                'companies.legal_name',
                'companies.email',
                'applications.id',
                DB::raw('(SELECT COUNT(*) FROM req_applications WHERE req_applications.states_req_applications = 3 AND req_applications.application_id = applications.id) as req_applications_count')
            )
            ->where('applications.id', $this->apllicationID)
            ->where('applications.status', '>=', 1)
            ->first();

        //        $dataApplication =
        //            ReqApplications::join('requisitos', 'requisitos.id', '=', 'req_applications.requirement_id')
        //                ->join('medicamentos', 'medicamentos.id', '=', 'req_applications.product_id')
        //                ->join('grupos_requisitos', 'grupos_requisitos.id', '=', 'requisitos.grupo_requisito_id')
        //                ->where('req_applications.application_id', $this->apllicationID)
        //                ->where('req_applications.status', '>=', 1)
        //                ->select(
        //                    'grupos_requisitos.grupo as grupo_nombre',
        //                    'req_applications.id',
        //                    'requisitos.codigo',
        //                    'requisitos.descripcion',
        //                    'req_applications.states_req_applications',
        //                )
        //                ->orderBy('grupos_requisitos.grupo')
        //                ->get()
        //                ->groupBy('grupo_nombre') // Agrupa por 'grupo_nombre' en lugar de 'grupos_requisitos.grupo'
        //                ->collect(); // Convierte a colección de soporte

        return view(
            'livewire.recepcion.recep-documents-detail-component',
            ['applicationsData' => $applicationsData]
        )
            ->extends('layouts.master')
            ->section('content');
    }

    public function showFormChangeState($id, $nameTable)
    {
        $this->reqApplicationID = $id;
        $this->nameTableRelations = $nameTable;
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
            $dataSends =
                Application::join('familia_producto', 'applications.family_id', '=', 'familia_producto.id')
                    ->join('medicamentos', 'applications.product_id', '=', 'medicamentos.id')
                    ->join('companies', 'applications.distribution_id', '=', 'companies.id')
                    ->select(
                        'applications.*',
                        'medicamentos.descripcion',
                        'medicamentos.cod_medicamento',
                        'companies.legal_name',
                        'companies.email',
                        'applications.id',
                        DB::raw('(SELECT COUNT(*) FROM req_applications WHERE req_applications.states_req_applications = 3 AND req_applications.application_id = applications.id) as req_applications_count')
                    )
                    ->where('applications.id', $this->apllicationID)
                    ->where('applications.status', '>', 0)
                    ->first();


            $dataRequiurementsF =
                ReqApplications::join('requisitos', 'requisitos.id', '=', 'req_applications.requirement_id')
                    ->join('medicamentos', 'medicamentos.id', '=', 'req_applications.product_id')
                    ->join('grupos_requisitos', 'grupos_requisitos.id', '=', 'requisitos.grupo_requisito_id')
                    ->where('req_applications.application_id', $this->apllicationID)
                    ->where('req_applications.status', '>=', 1)
                    ->select(
                        'grupos_requisitos.grupo as grupo_nombre',
                        'req_applications.id',
                        'requisitos.codigo',
                        'requisitos.descripcion',
                        'requisitos.obligatorio',
                        'requisitos.entregable',
                        'requisitos.vence',
                        'req_applications.date_vence',
                        'req_applications.states_req_applications',
                    )
                    ->orderBy('grupos_requisitos.grupo')
                    ->get()
                    ->groupBy('grupo_nombre') // Agrupa por 'grupo_nombre' en lugar de 'grupos_requisitos.grupo'
                    ->collect(); // Convierte a colección de soporte


            $company = Companies::where('id', $this->idCompany)->first();

//            $dataRequiurementsD = Application::join('companies', 'applications.fabric_id', '=', 'companies.id')
//                ->join('req_relation_profile_tables',
//                    'applications.fabric_id',
//                    '=',
//                    'req_relation_profile_tables.company_id')
//                ->join('requisitos', 'requisitos.id', '=', 'req_relation_profile_tables.req_id')
//                ->where('applications.distribution_id', $this->idCompany)
//                ->where('applications.status', '>=', 1)
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


            $dataRequiurementsD = [
                'Fabricantes' => $dataFabricantes,
                'Distribuidores' => $dataDistribuidores
            ];


            $dataApplicant = Application::join('familia_producto', 'applications.family_id', '=', 'familia_producto.id')
                ->join('medicamentos', 'applications.product_id', '=', 'medicamentos.id')
                ->join('companies', 'applications.fabric_id', '=', 'companies.id')
                ->select(
                    'applications.*',
                    'medicamentos.descripcion',
                    'medicamentos.cod_medicamento',
                    'companies.legal_name',
                    'companies.email',
                    'applications.id',
                    DB::raw('(SELECT COUNT(*) FROM req_applications WHERE req_applications.states_req_applications = 3 AND req_applications.application_id = applications.id) as req_applications_count')
                )
                ->where('applications.id', $this->apllicationID)
                ->where('applications.status', '>=', 1)
                ->first();

            // Genera el PDF
            $viewData = compact('dataApplicant', 'dataRequiurementsD');
            $viewData2 = compact('dataApplicant', 'dataRequiurementsF');
            $pdf = Pdf::loadView('pdfs.pdf-recepcion-doc2', $viewData)
                ->setPaper('a4')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'defaultFont' => 'helvetica',
                ]);

            $viewData = compact('dataApplicant', 'dataRequiurementsF');
            $pdf2 = Pdf::loadView('pdfs.pdf-recepcion-doc', $viewData2)
                ->setPaper('a4')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'defaultFont' => 'helvetica',
                ]);

            // Nombre del archivo PDF
            $filename = 'acta-recepcion-docA-' . $dataApplicant->llegal_name . '-' . $dataApplicant->cod_medicamento .
                '.pdf';
            $filename2 = 'acta-recepcion-docT-' . $dataApplicant->llegal_name . '-' . $dataApplicant->cod_medicamento
                . '.pdf';

            // Guarda el PDF temporalmente
            $pdfContent = $pdf->output();
            Storage::disk('local')->put('temp/' . $filename, $pdfContent);
            $pdfContent2 = $pdf2->output();
            Storage::disk('local')->put('temp/' . $filename2, $pdfContent2);

            Mail::to($dataSends->email)->send(new NotificationRequeriment(
                $dataSends->cod_medicamento . '-'
                . $dataSends->descripcion,
                $dataSends->descripcion,
                $this->messagesSendsAplications,
                'Notificacion',
                $filename,
                $filename2,
                storage_path('app/temp/' . $filename),
                storage_path('app/temp/' . $filename2),
            ));
            Storage::disk('local')->delete('temp/' . $filename);
            Storage::disk('local')->delete('temp/' . $filename2);


            DB::commit();


            $this->messagesSendsAplications = '';

            $this->dispatch('sendSendApplicationSuccess', message: 'Notificacion enviada correctamente');
        } catch (\Throwable $e) {
            //este metodo lo que hace es deshacer los cambios en la base de datos
            DB::rollback();

            //este metodo lo que hace es mostrar el error en la consola
            dd($e);
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

            if ($this->nameTableRelations == 'req_applications') {


                ReqApplications::where('id', $this->reqApplicationID)
                    ->update([
                        'states_req_applications' => $this->selectStates
                    ]);

            } elseif ($this->nameTableRelations == 'req_relation_profile_tables') {
                ReqRelationProfileTable::where('id', $this->reqApplicationID)
                    ->update([
                        'status' => $this->selectStates,
                    ]);
            }

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
                //                Mail::to($dataSends->email)->send(new NotificationRequeriment($dataSends->cod_medicamento . '-'
                //                    . $dataSends->medicamento_descripcion,
                //                    $dataSends->descripcion,
                //                    $this->messagesSends,
                //                    'Observacion'));
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

    #[On('showViewObservationsJS')]
    public function showObservacionRequerimont($id, $nameTable)
    {

        $this->nameTableRelations = $nameTable;
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

    public function viewMoreObservations()
    {
        $this->limitObservations = 20;
        // No necesitas incrementar el offset aquí
        $this->observacionesGlobals = NotificationsApplications::where('req_application_id', $this->reqApplicationID)
            ->orderBy('id', 'desc')
            ->limit($this->limitObservations)
            ->get();
    }

    #[On('showDocumentsJS')]
    public function showDocWire($id, $nameTable)
    {
        //  dd($nameTable);
        $this->nameTableRelations = $nameTable;
        $this->reqApplicationID = $id;
        $this->docDatas = [];
        $this->docDatas = DocumentApplications::where('req_application_id', $id)
            ->where('name_table', $nameTable)
            ->orderBy('id', 'asc')
            ->get();
//        dd($this->docDatas);
        $this->dispatch('show-doc-js');
    }

    #[On('showUpDocumentsJS')]
    public function showUpDoc($id, $nameTable, $dataVenceparameter)
    {
        $this->dataVenceInput = $dataVenceparameter;

        $this->nameTableRelations = $nameTable;
        $this->reqApplicationID = $id;
        $this->dispatch('showUpDoc');
    }

    #[On('detailCompany')]
    public function detailCompany($id)
    {

        if ($this->selectedRequeriment == 'T') {
            $this->documentDataDetail = DocumentApplications::where('req_application_id', $id)
                ->where('name_table', 'req_applications')
                ->get();
        } else {
            $this->documentDataDetail = DocumentApplications::where('req_application_id', $id)
                ->where('name_table', 'req_relation_profile_tables')
                ->get();
        }


        $this->dispatch('detail_company', ['id' => $id]);

    }


    public function createDocUp()
    {

        $nameUpTable = $this->nameTableRelations;
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
                ->where('name_table', $nameUpTable)
                ->update([
                    'status' => 0
                ]);

            //  dd($nameUpTable);
            $newDoc = DocumentApplications::create([
                'req_application_id' => $this->reqApplicationID,
                'document_name' => $this->nameDoc,
                'descriptions' => $this->descriptionDoc,
                'attachment' => $doc_name,
                'name_table' => $nameUpTable,
                'status' => 1
            ]);


            if ($this->nameTableRelations == 'req_applications') {
                if ($this->dataVenceInput == 1) {
                    ReqApplications::where('id', $this->reqApplicationID)
                        ->update([
                            'states_req_applications' => 10,
                            'date_vence' => $this->inputDateVence
                        ]);
                } else {
                    ReqApplications::where('id', $this->reqApplicationID)
                        ->update([
                            'states_req_applications' => 10,
                        ]);
                }
            } elseif ($this->nameTableRelations == 'req_relation_profile_tables') {
                if ($this->dataVenceInput == 1) {
                    ReqRelationProfileTable::where('id', $this->reqApplicationID)
                        ->update([
                            'status' => 10,
                            'date_vence' => $this->inputDateVence
                        ]);
                } else {
                    ReqRelationProfileTable::where('id', $this->reqApplicationID)
                        ->update([
                            'status' => 10
                        ]);
                }

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


    public function showFormChangeStateA($id)
    {
        $this->reqApplicationID = $id;
        $this->dispatch('showFormChangeState');
    }


    public function showObservacionRequerimontA($id)
    {
        $this->reqApplicationID = $id;
        $this->dispatch('showFormChangeState');
    }

    public function showUpDocA($id)
    {
        $this->reqApplicationID = $id;
        $this->dispatch('showFormChangeState');
    }


    public function viewDocAdmShow($id)
    {
        $this->reqApplicationID = $id;
        $this->dispatch('showFormChangeState');
    }


}
