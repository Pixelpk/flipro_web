<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;

class LiveEmailDesignerComponent extends Component
{
    public function render()
    {
        return view('livewire.components.live-email-designer-component')->layout('layouts.email-designer');
    }
}
