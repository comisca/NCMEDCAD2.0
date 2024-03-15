<?php

namespace App\Livewire\Instituciones;

use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;
use Session;
use DB;
use App\Models\Instituciones;
use App\Models\Paises;
use Carbon\Carbon;

class InstitucionesComponent extends Component
{

use WithPagination;
    public $pagination = 10;
    public $idSelecte;
    public $namePage, $tittleModal, $detailModal, $searchQuety;
    public $id_pais, $institucion, $id_institucion_padre, $paga_cuota, $cuota_pagada, $es_minsa, $encabezado_nota_cobro, $paises;
    public $modalVisibility = false;
    public $options = [];
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {   
        $this->namePage = 'Instituciones';
        $this->idSelecte = 0;
        $this->tittleModal = 'Adicionar Institución';
        $this->detaiModal = 'Formulario para adicionar una nueva Institución';
        

    }


    public function render()
    {
        $paises = Paises::all();
        $options = [
            0 => 'No',
            1 => 'Si'
        ];
        if (strlen($this->searchQuety) > 0) {
            $institucion = Instituciones::where('institucion', 'like', '%' . $this->searchQuety . '%')
                ->paginate($this->pagination);
        
        } else {
            $institucion = Instituciones::where('id_institucion_padre', '=', null)->orderBy('id', 'desc')->paginate($this->pagination);
        }
        return view('livewire.instituciones.instituciones-component',['data'=>$institucion, 'dataPaises'=>$paises,'dataOptions'=>$options])
        ->extends('layouts.master')
        ->section('content');
    }

    public function create()
    {
        $rules = [
            'id_pais' => 'required',
            'institucion' => 'required',
            'paga_cuota' => 'required',
            'es_minsa' => 'required',
            'cuota_pagada' => 'required',
            'encabezado_nota_cobro' => 'nullable',
        ];

        $messages = [
            'id_pais.required' => 'El país debe ser seleccionado.',
            'institucion.required' => 'El nombre de la institución es requerido.',
            'paga_cuota.required' => 'La opción paga cuota es requerido.',
            'es_minsa.required' => 'La opción de Ministerio de Salud es requerido.',
            'cuota_pagada.required' => 'La opción de cuota pagada es requerido.',
        ];


        $this->validate($rules, $messages);
        try {
            //este metodo lo que hace es inicailizar las transacciones en la base de datos
            DB::beginTransaction();
            $institucionCreate = Instituciones::create([
                'id_pais' => $this->id_pais,
                'institucion' => $this->institucion, 
                'paga_cuota' => $this->paga_cuota, 
                'es_minsa' => $this->cuota_pagada, 
                'encabezado_nota_cobro' => $this->encabezado_nota_cobro, 
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            $institucionCreate->save();

            //Aqui se escribe el codigo que se desea hacer en la transaccion
            

            //este metodo lo que hace es guardar los cambios en la base de datos
            DB::commit();
            $this->resetUI();
            $this->dispatch('message-exito', messages: 'Institución registrada correctamente');

        }catch (\Throwable $e) {
            //este metodo lo que hace es deshacer los cambios en la base de datos
            DB::rollback();
            $this->dispatch('message-error', messages: 'Ocurrio un problema, comunicate con soporte');
            //este metodo lo que hace es mostrar el error en la consola
            dd($e->getMessage());
        }
    }

    public function edit($id){
        $institucion = Instituciones::where('id', '=', $id)->first();
        

        $this->id_pais = $institucion->id_pais;
        $this->institucion = $institucion->institucion;
        $this->paga_cuota = $institucion->paga_cuota;
        $this->cuota_pagada = $institucion->cuota_pagada;
        $this->es_minsa = $institucion->es_minsa;
        $this->idSelecte = $institucion->id;
        $this->encabezado_nota_cobro = $institucion->encabezado_nota_cobro;
        $this->dispatch('institucion-edit');
    }
    public function update()
    {
        $rules = [
            'id_pais' => 'required',
            'institucion' => 'required',
            'paga_cuota' => 'required',
            'es_minsa' => 'required',
            'cuota_pagada' => 'required',
            'encabezado_nota_cobro' => 'nullable',
        ];

        $messages = [
            'id_pais.required' => 'El país debe ser seleccionado.',
            'institucion.required' => 'El nombre de la institución es requerido.',
            'paga_cuota.required' => 'La opción paga cuota es requerido.',
            'es_minsa.required' => 'La opción de Ministerio de Salud es requerido.',
            'cuota_pagada.required' => 'La opción de cuota pagada es requerido.',
        ];


        $this->validate($rules, $messages);
        try {
            //este metodo lo que hace es inicailizar las transacciones en la base de datos
            DB::beginTransaction();
            //Aqui se escribe el codigo que se desea hacer en la transaccion
            $institucionUpdate = Instituciones::find($this->idSelecte);
            $institucionUpdate->id_pais = $this->id_pais;
            $institucionUpdate->institucion = $this->institucion;
            $institucionUpdate->paga_cuota = $this->paga_cuota;
            $institucionUpdate->es_minsa = $this->es_minsa;
            $institucionUpdate->cuota_pagada = $this->cuota_pagada;
            $institucionUpdate->encabezado_nota_cobro = $this->encabezado_nota_cobro;
            $institucionUpdate->save();

            //este metodo lo que hace es guardar los cambios en la base de datos
            DB::commit();
            $this->resetUI();
            $this->dispatch('refresh-institucion');
            $this->dispatch('message-exito', messages: 'Institución fue actualizado correctamente!!');

        }catch (\Throwable $e) {
            //este metodo lo que hace es deshacer los cambios en la base de datos
            DB::rollback();

            //este metodo lo que hace es mostrar el error en la consola
            dd($e->getMessage());
        }
    }

    #[On('deletedata')]
    public function delete($institucionId)
    {
        try {
            //este metodo lo que hace es inicailizar las transacciones en la base de datos
            DB::beginTransaction();
            $institucionDelete = Instituciones::find($institucionId);
            $institucionDelete->delete();

            //Aqui se escribe el codigo que se desea hacer en la transaccion

            //este metodo lo que hace es guardar los cambios en la base de datos
            DB::commit();
            $this->dispatch('message-exito', messages: 'Institución fue eliminado correctamente!!');

        }catch (\Throwable $e) {
            //este metodo lo que hace es deshacer los cambios en la base de datos
            DB::rollback();

            //este metodo lo que hace es mostrar el error en la consola
            dd($e->getMessage());
        }
    }

    public function resetUI()
    {
        $this->id_pais = '';
        $this->institucion = '';
        $this->id_institucion_padre = '';
        $this->paga_cuota = '';
        $this->cuota_pagada = '';
        $this->es_minsa = '';
        $this->encabezado_nota_cobro = '';
        $this->idSelecte = 0;
    }



}
