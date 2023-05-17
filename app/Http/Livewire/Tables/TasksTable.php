<?php

namespace App\Http\Livewire\Tables;

use App\Models\Event;
use App\Models\Lead;
use App\Models\Project;
use App\Models\User;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class TasksTable extends LivewireDatatable
{
    protected $listeners = ['refreshTable'];
    public $exportable = true;

    public function builder()
    {
        return Event::where('user_id', $this->params['user_id']);
    }

    public function columns()
    {
        return [
            Column::name("id")->defaultSort('desc')->hide(),
            Column::name("title")->label("Title")->searchable(),
            Column::name("description")->label("Description")->searchable(),
            Column::callback("lead_id", function($id){
                if($id){
                    return Lead::find($id)->name ?? "";
                }
            })->label("Lead"),
            Column::callback("attached_user_id", function($id){
                if($id){
                    return User::find($id)->name ?? "";
                }
            })->label("User"),
            Column::callback("project_id", function($id){
                if($id){
                    return Project::find($id)->title ?? "";
                }
            })->label("Project"),
            DateColumn::name("event_date")->label("Date"),
            Column::callback(['id'], function($id){
                $editAction = "<span wire:click='edit($id)'><i class='bx bx-pencil'></i></span>";
                $deleteAction = "<span wire:click='delete($id)'><i class='bx bx-trash text-danger ml-2'></i></span>";
                return (request()->user()->hasRole('update-campaigns') ? $editAction : '') . ' ' . (request()->user()->hasRole('delete-campaigns') ? $deleteAction : '');
            })
        ];
    }

    public function edit($id)
    {
        $this->emit('editModel', $id);
    }

    public function delete($id)
    {
        $this->emit('deleteModel', $id);
    }

    public function refreshTable()
    {
        $this->refreshLivewireDatatable();
    }
}