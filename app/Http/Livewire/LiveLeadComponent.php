<?php

namespace App\Http\Livewire;

use App\Imports\LeadImport;
use App\Models\Lead;
use App\Models\LeadSegment;
use App\Models\LeadTag;
use App\Models\Segment;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithFileUploads;

class LiveLeadComponent extends Component
{
    use WithFileUploads;
    protected $listeners = ['editModel' => 'edit', 'deleteModel' => 'deleteConfirmation'];
    public $type;
    public $user;
    public $name;
    public $email;
    public $address;
    public $phone_code;
    public $phone;
    public $password;
    public $segments;
    public $tags;
    public $selectedSegments;
    public $selectedTags;
    public $exelfile;
    public $userTypes = [
        'admin', 'franchise', 'builder', 'evaluator', 'home-owner'
    ];
    public $model;

    protected $rules = [
        'name' => 'required',
        'email' => 'required|email|unique:leads,email',
        'address' => 'required',
        'phone_code' => 'required',
        'phone' => 'required',
        'model' => 'nullable',
    ];

    public function mount()
    {
        $this->user = Auth::user();

        if(!$this->user->hasRole('view-leads')) abort(403);

        $this->segments = Segment::all();
        $this->tags = Tag::all();
    }

    public function create()
    {
        $this->validate();
        $user = Lead::forceCreate([
            'name' => $this->name,
            'email' => $this->email,
            'phone_code' => $this->phone_code,
            'phone' => $this->phone,
            'address' => $this->address,
            'user_id' => $this->user->id,
        ]);
        if($this->selectedSegments){
            foreach($this->selectedSegments as $segment) {
                LeadSegment::forceCreate([
                    'lead_id' => $user->id,
                    'segment_id' => $segment,
                    'user_id' => $this->user->id
                ]);
            }
        }
        $this->selectedSegments = null;

        if($this->selectedTags){
            foreach($this->selectedTags as $tag) {
                LeadTag::forceCreate([
                    'lead_id' => $user->id,
                    'tag_id' => $tag,
                    'user_id' => $this->user->id
                ]);
            }
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
            'name', 'email', 'address', 'phone_code', 'phone', 'selectedSegments', 'selectedTags', 'model'
        ]);
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$this->model->id,
            'address' => 'required',
            'phone_code' => 'required',
            'phone' => 'required',
        ]);

        $this->model->name = $this->name;
        $this->model->email = $this->email;
        $this->model->phone_code = $this->phone_code;
        $this->model->phone = $this->phone;
        $this->model->address = $this->address;

        $this->model->update();


        collect(LeadSegment::where('lead_id', $this->model->id)->get())->map(function($item, $index) {
            if(!in_array($item->id, $this->selectedSegments ?? [])){
                $item->delete();
            }
        });

        collect($this->selectedSegments)->map(function($item, $index){
            if(!in_array($item, LeadSegment::where('lead_id', $this->model->id)->pluck('id')->toArray())){
                LeadSegment::forceCreate([
                    'segment_id' => $item,
                    'lead_id' => $this->model->id,
                    'user_id' => $this->user->id
                ]);
            }
        });


        collect(LeadTag::where('lead_id', $this->model->id)->get())->map(function($item, $index) {
            if(!in_array($item->id, $this->selectedTags ?? [])){
                $item->delete();
            }
        });

        collect($this->selectedTags)->map(function($item, $index){
            if(!in_array($item, LeadTag::where('lead_id', $this->model->id)->pluck('id')->toArray())){
                LeadTag::forceCreate([
                    'tag_id' => $item,
                    'lead_id' => $this->model->id,
                    'user_id' => $this->user->id
                ]);
            }
        });

        $this->dispatchBrowserEvent('alert', [
            'title'=> "Success",
            'text'=> 'Lead updated successfully',
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
            'name', 'email', 'address', 'phone_code', 'phone', 'selectedSegments', 'selectedTags', 'model'
        ]);
    }

    public function openModal()
    {
        $this->reset([
            'name', 'email', 'address', 'phone_code', 'phone', 'selectedSegments', 'selectedTags', 'model'
        ]);
    }
    public function openModalexel()
    {
        $this->reset([
            'exelfile'
        ]);
    }

    public function edit(Lead $lead)
    {
        $this->model = $lead;
        $this->name = $lead->name;
        $this->email = $lead->email;
        $this->address = $lead->address;
        $this->phone_code = $lead->phone_code;
        $this->phone = $lead->phone;
        $this->selectedSegments = $this->model->segments->pluck('id')->toArray();
        $this->selectedTags = $this->model->tags->pluck('id')->toArray();

        $this->dispatchBrowserEvent('toggleModal', [
            'id' => "userCreateModal",
            'action' => 'show'
        ]);
    }

    public function deleteConfirmation(Lead $lead)
    {
        $this->model = $lead;
        $this->dispatchBrowserEvent('toggleModal', [
            'id' => "userDeleteModal",
            'action' => 'show'
        ]);
    }

    public function delete()
    {
        $this->model->delete();
        $this->emit('refreshTable');
        $this->reset([
            'name', 'email', 'address', 'phone_code', 'phone', 'selectedSegments', 'selectedTags', 'model'
        ]);
        $this->dispatchBrowserEvent('toggleModal', [
            'id' => "userDeleteModal",
            'action' => 'hide'
        ]);
        $this->dispatchBrowserEvent('alert', [
            'title'=> "Success",
            'text'=> 'Lead deleted successfully',
            'type'=> "success",
            'confirmButtonClass'=> 'btn btn-primary',
            'buttonsStyling'=> false,
        ]);
        return redirect()->to('leads');
    }

    public function render()
    {
        return view('livewire.live-lead-component');
    }

    public function import()
    {
        $this->validate([
            'exelfile' => 'required|mimes:xlsx, xls, csv',
        ]);
        Excel::import(new LeadImport, $this->exelfile);
        return redirect()->to('leads');
    }
}
