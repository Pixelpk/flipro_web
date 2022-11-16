<?php

namespace App\Http\Livewire;

use App\Models\Segment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LiveSegmentComponent extends Component
{
    protected $listeners = ['editModel' => 'edit', 'deleteModel' => 'deleteConfirmation'];

    public $user;
    public $name;
    public $description;
    public $model;

    protected $rules = [
        'name' => 'required',
        'description' => 'nullable',
        'model' => 'nullable',
    ];

    public function mount()
    {
        $this->user = Auth::user();

        if(!$this->user->hasRole('view-segments')) abort(403); 
    }

    public function create()
    {
        $this->validate();
        $user = Segment::forceCreate([
            'name' => $this->name,
            'description' => $this->description,
            'user_id' => $this->user->id
        ]); 
        
        $this->dispatchBrowserEvent('alert', [
            'title'=> "Success",
            'text'=> 'Segment created successfully',
            'type'=> "success",
            'confirmButtonClass'=> 'btn btn-primary',
            'buttonsStyling'=> false,
        ]);
        
        $this->emit('refreshTable');
        $this->dispatchBrowserEvent('toggleModal', [
            'id' => "createModal",
            'action' => 'hide'
        ]);
        $this->reset([
            'name', 'description', 'model'
        ]);
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'description' => 'required',
        ]);
        
        $this->model->name = $this->name;
        $this->model->description = $this->description;

        $this->model->update();
        
        $this->dispatchBrowserEvent('alert', [
            'title'=> "Success",
            'text'=> 'Segment updated successfully',
            'type'=> "success",
            'confirmButtonClass'=> 'btn btn-primary',
            'buttonsStyling'=> false,
        ]);
        
        $this->emit('refreshTable');
        $this->dispatchBrowserEvent('toggleModal', [
            'id' => "createModal",
            'action' => 'hide'
        ]);
        $this->reset([
            'name', 'description', 'model'
        ]);
    }

    public function openModal()
    {
        $this->reset([
            'name', 'description', 'model'
        ]);
    }

    public function edit(Segment $segment)
    {
        $this->model = $segment;
        $this->name = $segment->name;
        $this->description = $segment->description;
        
        $this->dispatchBrowserEvent('toggleModal', [
            'id' => "createModal",
            'action' => 'show'
        ]);
    }

    public function deleteConfirmation(Segment $segment)
    {
        $this->model = $segment;
        $this->dispatchBrowserEvent('toggleModal', [
            'id' => "deleteModal",
            'action' => 'show'
        ]);
    }
    
    public function delete()
    {
        $this->model->delete();
        $this->emit('refreshTable');
        $this->reset([
            'name', 'description', 'model'
        ]);
        $this->dispatchBrowserEvent('toggleModal', [
            'id' => "deleteModal",
            'action' => 'hide'
        ]);
        $this->dispatchBrowserEvent('alert', [
            'title'=> "Success",
            'text'=> 'Segment deleted successfully',
            'type'=> "success",
            'confirmButtonClass'=> 'btn btn-primary',
            'buttonsStyling'=> false,
        ]);
    }

    public function render()
    {
        return view('livewire.live-segment-component');
    }
}
