<?php

namespace App\Http\Livewire;

use App\Models\UserSmtp;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LiveSettingsComponent extends Component
{
    public $user;
    public $userSmtps;

    protected $rules = [
        'userSmtps.incomming_server' => 'nullable',
        'userSmtps.outgoing_server' => 'nullable',
        'userSmtps.incomming_port' => 'nullable',
        'userSmtps.outgoing_port' => 'nullable',
        'userSmtps.username' => 'nullable',
        'userSmtps.password' => 'nullable',
        'userSmtps.auth' => 'nullable',
        'userSmtps.sender_name' => 'nullable',
        'userSmtps.authentication_type' => 'nullable',
    ];

    public function saveEmailSettings()
    {
        if(isset($this->userSmtps->id)){
            $this->userSmtps->update();
        }
        else {
            $this->userSmtps['user_id'] = $this->user->id;
            $this->userSmtps = UserSmtp::forceCreate($this->userSmtps);
        }
        $this->dispatchBrowserEvent('alert', [
            'title'=> "Success",
            'text'=> 'Email settings updated successfully',
            'type'=> "success",
            'confirmButtonClass'=> 'btn btn-primary',
            'buttonsStyling'=> false,
        ]);
    }

    public function mount()
    {
        $this->user = Auth::user();
        $this->userSmtps = $this->user->emailSettings;
    }

    public function render()
    {
        return view('livewire.live-settings-component');
    }
}
