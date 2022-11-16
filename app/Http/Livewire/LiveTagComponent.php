<?php

namespace App\Http\Livewire;

use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LiveTagComponent extends Component
{
    protected $listeners = ['editModel' => 'edit', 'deleteModel' => 'deleteConfirmation'];

    public $user;
    public $name;
    public $model;

    protected $rules = [
        'name' => 'required',
        'model' => 'nullable',
    ];

    public function mount()
    {
        $this->user = Auth::user();

        if(!$this->user->hasRole('view-tags')) abort(403); 
    }

    public function create()
    {
        $this->validate();
        $user = Tag::forceCreate([
            'name' => $this->name,
            'user_id' => $this->user->id
        ]); 
        
        $this->dispatchBrowserEvent('alert', [
            'title'=> "Success",
            'text'=> 'Tag created successfully',
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
            'name', 'model'
        ]);
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
        ]);
        
        $this->model->name = $this->name;

        $this->model->update();
        
        $this->dispatchBrowserEvent('alert', [
            'title'=> "Success",
            'text'=> 'Tag updated successfully',
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
            'name', 'model'
        ]);
    }

    public function openModal()
    {
        $this->reset([
            'name', 'model'
        ]);
    }

    public function edit(Tag $tag)
    {
        $this->model = $tag;
        $this->name = $tag->name;
        
        $this->dispatchBrowserEvent('toggleModal', [
            'id' => "createModal",
            'action' => 'show'
        ]);
    }

    public function deleteConfirmation(Tag $tag)
    {
        $this->model = $tag;
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
            'name', 'model'
        ]);
        $this->dispatchBrowserEvent('toggleModal', [
            'id' => "deleteModal",
            'action' => 'hide'
        ]);
        $this->dispatchBrowserEvent('alert', [
            'title'=> "Success",
            'text'=> 'Tag deleted successfully',
            'type'=> "success",
            'confirmButtonClass'=> 'btn btn-primary',
            'buttonsStyling'=> false,
        ]);
    }

    public function render()
    {
        return view('livewire.live-tag-component');
    }
}
