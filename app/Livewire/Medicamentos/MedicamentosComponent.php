<?php

namespace App\Livewire\Medicamentos;

use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;
use Session;
use DB;
use Carbon\Carbon;
use App\Models\Medicamentos;
use App\Models\FamiliaProducto;
use App\Models\GrupoFamilia;
use App\Models\GrupoRequisitos;

class MedicamentosComponent extends Component
{

use WithPagination;
    public $pagination = 10;
    public $namePage, $tittleModal, $detailModal, $searchQuety, $idSelecte, $addInstitucion;
    public $medicamentos, $familias_producto, $FamProductoId, $grupo_familia=[], $GrupoFamiliaId, $grupo_requisitos=[], $GrupoRequisitoId;
    public $cod_medicamento, $descripcion, $id_familia_producto, $id_grupo_familia, $id_grupo_requerimiento;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->namePage = 'Medicamentos';
        $this->idSelecte = 0;
        $this->tittleModal = 'Adicionar Medicamentos';

        $this->familias_producto = FamiliaProducto::all();
        $this->grupo_familia = collect();
        $this->grupo_requisitos = collect();

    }
    public function updatedFamProductoId($id): void{
        $this->grupo_familia = GrupoFamilia::where('id_familia_producto', $id)->get();
        $this->GrupoFamiliaId = $this->grupo_familia->first()->id ?? null;

        $this->grupo_requisitos = GrupoRequisitos::where('id_familia_producto', $id)->get();
        $this->GrupoRequisitoId = $this->grupo_requisitos->first()->id ?? null;
       
    }

    public function render()
    {   
        if (strlen($this->searchQuety) > 0) {
        $medicamentos = Medicamentos::where('cod_medicamento', 'like', '%' . $this->searchQuety . '%')
            ->paginate($this->pagination);
    
    } else {
        $medicamentos = Medicamentos::orderBy('id', 'desc')->paginate($this->pagination);
    }
        return view('livewire.medicamentos.medicamentos-component',['data'=>$medicamentos])
        ->extends('layouts.master')
        ->section('content');
    }

   

       public function create()
        {
            $rules = [
                'cod_medicamento' => 'required',
                'descripcion' => 'required',
                'id_familia_producto' => 'nullable',
                'id_grupo_familia' => 'nullable',
                'id_grupo_requerimiento' => 'nullable',
            ];
    
            $messages = [
                'cod_medicamento.required' => 'El codigo de medicamento debe ser llenado.',
                'descripcion.required' => 'La descripcion del medicamento debe ser llenado.',
            ];
            $this->validate($rules, $messages);
            try {
                //este metodo lo que hace es inicailizar las transacciones en la base de datos
                DB::beginTransaction();
                $medicamentoCreate = Medicamentos::create([
                    'cod_medicamento' => $this->cod_medicamento,
                    'descripcion' => $this->descripcion, 
                    'id_familia_producto' => $this->FamProductoId, 
                    'id_grupo_familia' => $this->GrupoFamiliaId, 
                    'id_grupo_requerimiento' => $this->GrupoRequisitoId, 
                    'activo'=> 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                $medicamentoCreate->save();

                //Aqui se escribe el codigo que se desea hacer en la transaccion

                //este metodo lo que hace es guardar los cambios en la base de datos
                DB::commit();
                $this->resetUI();
                $this->dispatch('message-exito', messages: 'Medicamento registrado correctamente');
    

            }catch (\Throwable $e) {
                //este metodo lo que hace es deshacer los cambios en la base de datos
                DB::rollback();

                //este metodo lo que hace es mostrar el error en la consola
               dd($e->getMessage());
            }
        }
        public function edit($id){
            $this->tittleModal = 'Editar Medicamento';
            $this->detaiModal = 'Formulario para editar medicamento';

            $medicamento = Medicamentos::where('id', '=', $id)->first();

            $this->cod_medicamento = $medicamento->cod_medicamento;
            $this->descripcion = $medicamento->descripcion;
            $this->FamProductoId = $medicamento->id_familia_producto;
            $this->GrupoFamiliaId = $medicamento->id_grupo_familia;
            $this->GrupoRequisitoId = $medicamento->id_grupo_requerimiento;
            $this->idSelecte = $medicamento->id;
            $this->dispatch('medicamento-edit');

        }

          public function update()
            {
                $rules = [
                    'cod_medicamento' => 'required',
                    'descripcion' => 'required',
                    'id_familia_producto' => 'nullable',
                    'id_grupo_familia' => 'nullable',
                    'id_grupo_requerimiento' => 'nullable',
                ];
        
                $messages = [
                    'cod_medicamento.required' => 'El codigo de medicamento debe ser llenado.',
                    'descripcion.required' => 'La descripcion del medicamento debe ser llenado.',
                ];
                $this->validate($rules, $messages);

                try {
                    //este metodo lo que hace es inicailizar las transacciones en la base de datos
                    DB::beginTransaction();
                    $medicamento = Medicamentos::find($this->idSelecte);
                    $medicamento->cod_medicamento = $this->cod_medicamento;
                    $medicamento->descripcion = $this->descripcion;
                    $medicamento->id_familia_producto = $this->FamProductoId;
                    $medicamento->id_grupo_familia = $this->GrupoFamiliaId;
                    $medicamento->id_grupo_requerimiento = $this->GrupoRequisitoId;
                    $medicamento->save();

                    //Aqui se escribe el codigo que se desea hacer en la transaccion

                    //este metodo lo que hace es guardar los cambios en la base de datos
                    DB::commit();
                    $this->resetUI();
                    $this->dispatch('refresh-medicamento');
                    $this->dispatch('message-exito', messages: 'Medicamento fue actualizado correctamente!!');

                }catch (\Throwable $e) {
                    //este metodo lo que hace es deshacer los cambios en la base de datos
                    DB::rollback();

                    //este metodo lo que hace es mostrar el error en la consola
                    dd($e->getMessage());
                }
            }

            #[On('deletedata')]
            public function deletexid($medicamentoId)
            {
                try {
                    //este metodo lo que hace es inicailizar las transacciones en la base de datos
                    DB::beginTransaction();
                    $medicamentoDelete = Medicamentos::find($medicamentoId);
                    $medicamentoDelete->delete();
                    //Aqui se escribe el codigo que se desea hacer en la transaccion

                    //este metodo lo que hace es guardar los cambios en la base de datos
                    DB::commit();
                    $this->dispatch('message-exito', messages: 'Medicamento fue eliminado correctamente!!');
                }catch (\Throwable $e) {
                    //este metodo lo que hace es deshacer los cambios en la base de datos
                    DB::rollback();

                    //este metodo lo que hace es mostrar el error en la consola
                    dd($e->getMessage());
                }
            }





     public function resetUI()
        {   
            $this->cod_medicamento = '';
            $this->descripcion = '';
            $this->FamProductoId = '';
            $this->GrupoFamiliaId = '';
            $this->GrupoRequisitoId = '';
            $this->idSelecte = 0;


        }

}
