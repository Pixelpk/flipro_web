<?php

namespace App\Http\Livewire;

use App\Models\Event;
use App\Models\Lead;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LiveEventsComponent extends Component
{
    public $user;
    public $title;
    public $description;
    public $event_date;
    public $model;
    public $leads;
    public $users;
    public $projects;
    public $user_id;
    public $project_id;
    public $lead_id;

    protected $listeners = ['editModel' => 'edit', 'deleteModel' => 'deleteConfirmation'];

    public function mount()
    {
        $this->user = Auth::user();
        $this->leads = Lead::when($this->user->user_type != 'admin', function($q){
            $q->where('user_id', Auth::id());
        })->get();
        $this->users = User::when($this->user->user_type != 'admin', function($q){
            $q->where('created_by', Auth::id());
        })->get();
        $this->projects = Project::when($this->user->user_type != 'admin', function($q){
            $q->where('user_id', Auth::id());
        })->get();

    }

    public function create()
    {
        $this->validate();
        $user = Event::forceCreate([
            'title' => $this->title,
            'description' => $this->description,
            'event_date' => $this->event_date,
            'attached_user_id' => $this->user_id,
            'lead_id' => $this->lead_id,
            'project_id' => $this->project_id,
            'user_id' => $this->user->id,
        ]);

        $this->dispatchBrowserEvent('alert', [
            'title' => "Success",
            'text' => 'Task created successfully',
            'type' => "success",
            'confirmButtonClass' => 'btn btn-primary',
            'buttonsStyling' => false,
        ]);

        $this->emit('refreshTable');
        $this->dispatchBrowserEvent('toggleModal', [
            'id' => "userCreateModal",
            'action' => 'hide',
        ]);
        $this->reset([
            'title', 'description', 'event_date', 'model', 'user_id', 'lead_id', 'project_id',
        ]);
    }

    protected $rules = [
        'title' => 'required',
        'description' => 'required',
        'event_date' => 'required|date',
    ];

    public function update()
    {
        $this->validate([
            'title' => 'required',
            'description' => 'required',
            'event_date' => 'required|date',
        ]);

        $this->model->title = $this->title;
        $this->model->description = $this->description;
        $this->model->attached_user_id = $this->user_id;
        $this->model->project_id = $this->project_id;
        $this->model->lead_id = $this->lead_id;
        $this->model->event_date = $this->event_date;

        $this->model->update();

        $this->dispatchBrowserEvent('alert', [
            'title' => "Success",
            'text' => 'Tasks updated successfully',
            'type' => "success",
            'confirmButtonClass' => 'btn btn-primary',
            'buttonsStyling' => false,
        ]);

        $this->emit('refreshTable');
        $this->dispatchBrowserEvent('toggleModal', [
            'id' => "userCreateModal",
            'action' => 'hide',
        ]);
        $this->reset([
            'title', 'description', 'event_date', 'model', 'user_id', 'lead_id', 'project_id',
        ]);
    }

    public function openModal()
    {
        $this->reset([
            'title', 'description', 'event_date', 'model', 'user_id', 'lead_id', 'project_id',
        ]);
    }

    public function edit(Event $event)
    {
        $this->model = $event;
        $this->title = $event->title;
        $this->user_id = $event->attached_user_id;
        $this->lead_id = $event->lead_id;
        $this->project_id = $event->project_id;
        $this->description = $event->description;
        $this->event_date = $event->event_date;

        $this->dispatchBrowserEvent('toggleModal', [
            'id' => "userCreateModal",
            'action' => 'show',
        ]);
    }

    public function deleteConfirmation(Event $event)
    {
        $this->model = $event;
        $this->dispatchBrowserEvent('toggleModal', [
            'id' => "userDeleteModal",
            'action' => 'show',
        ]);
    }

    public function delete()
    {
        $this->model->delete();
        $this->emit('refreshTable');
        $this->reset([
            'title', 'description', 'event_date', 'model', 'user_id', 'lead_id', 'project_id',
        ]);
        $this->dispatchBrowserEvent('toggleModal', [
            'id' => "userDeleteModal",
            'action' => 'hide',
        ]);
        $this->dispatchBrowserEvent('alert', [
            'title' => "Success",
            'text' => 'Task deleted successfully',
            'type' => "success",
            'confirmButtonClass' => 'btn btn-primary',
            'buttonsStyling' => false,
        ]);
    }

    public function render()
    {
        return view('livewire.live-events-component');
    }
}
