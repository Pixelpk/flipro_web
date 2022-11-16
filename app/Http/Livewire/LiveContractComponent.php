<?php

namespace App\Http\Livewire;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LiveContractComponent extends Component
{
    public $user;
    public $project;
    
    public function render()
    {
        return view('livewire.live-contract-component');
    }

    public function mount($project)
    {
        $this->project = $project;
       
        $this->user = Auth::user();
    }
}
