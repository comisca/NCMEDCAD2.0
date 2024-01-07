<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;
use Session;
use DB;

class Stubs extends Component
{
    use WithPagination;
    public $Pagination = 10;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {

    }

    public function render()
    {
        return view('livewire.stubs')
            ->extends('layouts.master')
            ->section('content');
    }
}
