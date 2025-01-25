<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;
use Session;
use DB;

class AutionTimerComponent extends Component
{


    public $timeLeft;

    protected $listeners = ['updateTimer' => 'updateTimeLeft'];

    public function mount($timeLeft)
    {
        $this->timeLeft = $timeLeft;
    }

    public function updateTimeLeft($timeLeft)
    {
        $this->timeLeft = $timeLeft;
    }


    public function render()
    {
        return view('livewire.events.aution-timer-component');
    }


}
