<?php

namespace App\Http\Livewire\Widget;

use App\Models\Lead;
use App\Models\LeadSegment;
use App\Models\LeadTag;
use App\Models\Segment;
use App\Models\Tag;
use Livewire\Component;

class LiveEmailSenderMediaWidget extends Component
{
    public $email;
    public $user;
    public $lead;
    public $name;
    public $message;
    public $segments;
    public $tags;
    public $model = null;
    public $address;
    public $phone_code;
    public $phone;
    public $selectedSegments = [];
    public $selectedTags = [];

    public function create()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'address' => 'required',
            'phone_code' => 'required',
            'phone' => 'required',
            'model' => 'nullable',
        ]);

        $user = Lead::forceCreate([
            'name' => $this->name,
            'email' => $this->email,
            'phone_code' => $this->phone_code,
            'phone' => $this->phone,
            'address' => $this->address,
            'user_id' => $this->user->id,
        ]); 

        foreach($this->selectedSegments as $segment) {
            LeadSegment::forceCreate([
                'lead_id' => $user->id,
                'segment_id' => $segment,
                'user_id' => $this->user->id
            ]);
        }
        $this->selectedSegments = null;


        foreach($this->selectedTags as $tag) {
            LeadTag::forceCreate([
                'lead_id' => $user->id,
                'tag_id' => $tag,
                'user_id' => $this->user->id
            ]);
        }
        $this->selectedTags = null;

        $this->dispatchBrowserEvent('alert', [
            'title'=> "Success",
            'text'=> 'Lead created successfully',
            'type'=> "success",
            'confirmButtonClass'=> 'btn btn-primary',
            'buttonsStyling'=> false,
        ]);
        
        $this->emit('refreshTable');
        $this->dispatchBrowserEvent('toggleModal', [
            'id' => "userCreateModal",
            'action' => 'hide'
        ]);
        $this->reset([
            'address', 'phone_code', 'phone', 'model'
        ]);

        $this->lead = $user;
    }

    public function mount()
    {
        $this->lead = Lead::where('email', $this->email)->where('user_id', $this->user->id)->first();
        $this->segments = Segment::owned()->get();
        $this->tags = Tag::owned()->get();
        if($this->lead){
            $this->name = $this->lead->name;
            $this->email = $this->lead->email;
        }else{
            if($this->message){
                $this->name = $this->message['name'];
                $this->email = $this->message['from'];
            }
        }
    }

    public function openModal()
    {
        $this->reset([
            'name', 'email', 'address', 'phone_code', 'phone', 'model'
        ]);
    }

    public function render()
    {
        return view('livewire.widget.live-email-sender-media-widget');
    }
}
