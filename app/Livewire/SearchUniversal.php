<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;
use Session;
use DB;

class SearchUniversal extends Component
{

use WithPagination;
    public $Pagination = 10;
    public $searchInput;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {

    }


    public function render()
    {
        return view('livewire.settings.search-universal');
    }
    #[On('openmodal')]
       public function openmodals()
        {
         //  dd('hola desd modal');
            $this->dispatch('open-modal', messages: 'No se puede eliminar el Rol porque tiene permisos asociados');
            return;
        }


          public function update()
            {
                try {
                    //este metodo lo que hace es inicailizar las transacciones en la base de datos
                    DB::beginTransaction();

                    //Aqui se escribe el codigo que se desea hacer en la transaccion

                    //este metodo lo que hace es guardar los cambios en la base de datos
                    DB::commit();

                }catch (\Throwable $e) {
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

                }catch (\Throwable $e) {
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
