<?php

namespace App\Livewire;

use App\Models\Application;
use App\Models\Auctions;
use App\Models\Companies;
use App\Models\Countries;
use App\Models\EventsAuction;
use App\Models\IntituteCountries;
use App\Models\Intitutions;
use App\Models\PostorEvent;
use App\Models\ProductEvent;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;
use Session;
use DB;

class EventsStart extends Component
{

    use WithPagination;

    public $Pagination = 10;
    public $searchInput;
    public $selectedYears, $selectedEvents, $eventsData, $productsEvents;
    public $selectedProductEvent, $productEventIndivisual, $dataAplication;
    public $viewPostorDataVar;
    public $productSubasta, $idSubasta, $codProducts, $qtyProducts, $priceRef, $dateStart;
    public $timeStart, $timeDuration, $porcReduce, $timeRecovery, $typeSubasta, $observacionSubasta;
    public $countriesData, $instotutionsData, $countryEventData, $instotutionCountryData;
    public $qtyProductsReferent, $priceProductReferent, $selectedType;
    public $idCountrySelecteds;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {

//        $this->qtyProducts = 30000;
    }

    public function updated()
    {
        $this->eventsData =
            EventsAuction::join('familia_producto', 'events_auctions.family_id', '=', 'familia_producto.id')
                ->where('events_auctions.status', 1)
                ->where('events_auctions.years', $this->selectedYears)
                ->select('events_auctions.id as id_events', 'familia_producto.*', 'events_auctions.*')
                ->get();


        $this->productsEvents = ProductEvent::join('medicamentos', 'product_events.product_id', '=', 'medicamentos.id')
            ->where('product_events.event_id', $this->selectedEvents)
            ->select('product_events.id as id_product_event',
                'medicamentos.*',
                'product_events.*')
            ->get();


    }


    public function render()
    {
        return view('livewire.events.events-start')
            ->extends('layouts.master')
            ->section('content');
    }

    public function createNeedes($idevent)
    {
        $this->selectedProductEvent = $idevent;
        $this->countriesData = Countries::where('status', 1)->get();

        $this->dispatch('create-needs-create', messages: 'El evento fue agregado con exito');

    }

    public function viewIntitutions($id)
    {
        $this->idCountrySelecteds = $id;
        $this->instotutionsData = Intitutions::where('country_id', $id)->get();
        $this->dispatch('view-institutions-create', messages: 'El evento fue agregado con exito');

    }

    public function viewsInstituteCountry($id)
    {
        $this->instotutionCountryData =
            IntituteCountries::join('intitutions', 'intitute_countries.intitute_id', '=', 'intitutions.id')
                ->where('intitute_countries.country_event_id', $id)
                ->select('intitute_countries.*', 'intitutions.*', 'intitute_countries.id as id_intitute_country')
                ->get();

        $this->dispatch('view-institutions-country-create', messages: 'El evento fue agregado con exito');

    }


    public function createIntitutions()
    {

        $rules = [
            'selectedType' => 'required',
            'qtyProductsReferent' => 'required',
            'priceProductReferent' => 'required',
        ];
        $messages = [
            'selectedType.required' => 'La intitucion es requerida.',
            'qtyProductsReferent.required' => 'La cantida de productos es requerida',
            'priceProductReferent.required' => 'El precio de referencia es requerido',
        ];

        $this->validate($rules, $messages);

        try {
            DB::beginTransaction();
            $eventCoontrie = ProductEvent::find($this->selectedProductEvent);


            $intitutionCreate = IntituteCountries::create([
                'country_event_id' => $this->idCountrySelecteds,
                'intitute_id' => $this->selectedType,
                'product_id' => $this->selectedProductEvent,
                'qty' => $this->qtyProductsReferent,
                'price' => $this->priceProductReferent,
                'type_product' => 'Referente',
                'events_id' => $eventCoontrie->event_id,
                'status' => 1,
            ]);

            DB::commit();
            $this->selectedType = '';
            $this->qtyProductsReferent = '';
            $this->priceProductReferent = '';

            $this->dispatch('intitutions-create-susses', messages: 'La intitucion fue agregada con exito');

        } catch (\Throwable $e) {
            DB::rollback();
            dd($e->getMessage());
        }

    }


    public function selectedProductEventID($id)
    {
        $this->selectedProductEvent = $id;
        $productEvernt = ProductEvent::find($id);

        $this->dataAplication = Application::join('medicamentos', 'applications.product_id', '=', 'medicamentos.id')
            ->join('companies as distribution_company', 'applications.distribution_id', '=', 'distribution_company.id')
            ->join('companies as fabric_company', 'applications.fabric_id', '=', 'fabric_company.id')
            ->where('medicamentos.id', $productEvernt->product_id)
            ->where('applications.status', 10)
            ->select(
                'applications.*',
                'medicamentos.*',
                'distribution_company.legal_name as distribution_first_name',
                'fabric_company.legal_name as fabric_first_name',
                'applications.id as id_application',
                'distribution_company.id as id_postor',
                'applications.status as status_application'
            )
            ->get();


        $this->dispatch('selectedProductEventDispach', messages: 'El evento fue agregado con exito');

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

    public function addPostorMethod($id)
    {
        try {
            DB::beginTransaction();

            $confirmProductEvent = PostorEvent::where('id_product_event', $this->selectedProductEvent)
                ->where('postor_id', $id)
                ->where('status', 1)
                ->first();

            $companiesData = Companies::find($id);
            $EventAuction = ProductEvent::find($this->selectedProductEvent);

            if (empty($confirmProductEvent)) {

                PostorEvent::create([
                    'id_product_event' => $this->selectedProductEvent,
                    'postor_id' => $id,
                    'type_postor' => $companiesData->type_company,
                    'event_id' => $EventAuction->event_id,
                    'name_anonimous' => $this->generatePassword(),
                    'status' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

            }

            DB::commit();

            $this->dispatch('postor-add_create-susses', messages: 'El postor fue agregado con exito');

        } catch (\Throwable $e) {
            //este metodo lo que hace es deshacer los cambios en la base de datos
            DB::rollback();

            //este metodo lo que hace es mostrar el error en la consola
            dd($e->getMessage());
        }

    }

    public function createConfigSubasta($id)
    {

        $dataLocalProductEvent = ProductEvent::join('medicamentos', 'product_events.product_id', '=', 'medicamentos.id')
            ->where('product_events.id', $id)
            ->select('product_events.id as id_product_event',
                'medicamentos.*',
                'product_events.*')
            ->first();

        $this->qtyProducts = IntituteCountries::where('product_id', $id)->sum('qty');

        $this->productSubasta = $dataLocalProductEvent->descripcion;
        $this->codProducts = $dataLocalProductEvent->cod_medicamento;
        $this->idSubasta = $id;
        $this->dispatch('modal-config-subasta', messages: 'El evento fue agregado con exito');


    }


    public function viewPostorData($id)
    {
        $this->viewPostorDataVar = PostorEvent::join('companies', 'postor_events.postor_id', '=', 'companies.id')
            ->where('postor_events.id_product_event', $id)
            ->select('postor_events.*', 'companies.*', 'postor_events.id as id_postor_event')
            ->get();

        $this->dispatch('view-postor-data', messages: 'El postor fue agregado con exito');

    }

    function generatePassword($minLength = 6, $maxLength = 8)
    {
        $length = rand($minLength, $maxLength);
        return Str::random($length);
    }


    public function createAuctions()
    {

        $rules = [
            'typeSubasta' => 'required',
            'idSubasta' => 'required',
            'qtyProducts' => 'required',
            'priceRef' => 'required',
            'timeStart' => 'required',
            'timeDuration' => 'required',
            'dateStart' => 'required',
            'porcReduce' => 'required',
        ];
        $messages = [
            'typeSubasta.required' => 'Tienes que seleccionar el tipo de subasta',
            'idSubasta.required' => 'El id de la negociacion es requerido',
            'qtyProducts.required' => 'La cantidad de productos es requerida',
            'priceRef.required' => 'El precio de referencia es requerido',
            'timeStart.required' => 'La hora de inicio es requerida',
            'timeDuration.required' => 'La duracion de la subasta es requerida',
            'dateStart.required' => 'La fecha de inicio es requerida',
            'porcReduce.required' => 'El porcentaje de reduccion es requerido',
        ];

        $this->validate($rules, $messages);

        try {

            DB::beginTransaction();

            $dataLastEvents = ProductEvent::join('medicamentos', 'product_events.product_id', '=', 'medicamentos.id')
                ->where('product_events.id', $this->idSubasta)
                ->select('product_events.id as id_product_event',
                    'medicamentos.*',
                    'product_events.*')
                ->first();

            if ($this->typeSubasta == 'Directa') {
                $this->timeRecovery = 0;
                $toleranciapor = $this->porcReduce;
                $rebajaporc = 0;
            } else {
                $toleranciapor = 0;
                $rebajaporc = $this->porcReduce;
            }

            Auctions::create([
                'product_id' => $dataLastEvents->product_id,
                'event_id' => $this->idSubasta,
                'type_product' => $dataLastEvents->type_product,
                'auction_state' => 'Pendiente',
                'auction_result' => 'Pendiente',
                'total' => $this->qtyProducts,
                'price_reference' => $this->priceRef,
                'date_start' => $this->dateStart,
                'hour_start' => $this->timeStart,
                'duration_time' => $this->timeDuration,
                'porcentage_reductions' => $rebajaporc,
                'porcentage_tolerance' => $toleranciapor,
                'recovery_time' => $this->timeRecovery,
                'observation' => $this->observacionSubasta,
                'type_auction' => $this->typeSubasta,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);


            DB::commit();

            $this->dispatch('auctions-create-susses', messages: 'La subasta fue creada con exito');
            $this->resetUI();
        } catch (\Throwable $e) {
            //este metodo lo que hace es deshacer los cambios en la base de datos
            DB::rollback();


            dd($e->getMessage());
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
        $this->productSubasta = '';
        $this->idSubasta = '';
        $this->codProducts = '';
        $this->qtyProducts = '';
        $this->priceRef = '';
        $this->dateStart = '';
        $this->timeStart = '';
        $this->timeDuration = '';
        $this->porcReduce = '';
        $this->timeRecovery = '';
        $this->typeSubasta = '';
        $this->observacionSubasta = '';


    }

}
