<?php

namespace App\Livewire;

use App\Models\Pujas;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;
use Session;
use DB;

class MyNewBidComponent extends Component
{

    use WithPagination;

    public $Pagination = 10;
    public $searchInput;
    public $varNewMyBid;
    public $auctionmynewbid;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount($auctionmynewbid)
    {
        $this->auctionmynewbid = $auctionmynewbid;
        $this->varNewMyBid = Pujas::where('auction_id', $this->auctionmynewbid->id)
            ->where('status', 1)
            ->where('postor_id', Session::get('id_company'))
            ->orderBy('amount', 'asc')
            ->get();

    }


    public function render()
    {
        return view('livewire.events.my-new-bid-component');
    }


    #[On('myNewBid')]
    public function myNewBidAuction()
    {
        if (Session::has('id_company')) {

            $this->varNewMyBid = Pujas::where('auction_id', $this->auctionmynewbid->id)
                ->where('status', 1)
                ->where('postor_id', Session::get('id_company'))
                ->orderBy('amount', 'asc')
                ->get();

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
