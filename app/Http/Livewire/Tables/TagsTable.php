<?php

namespace App\Http\Livewire\Tables;

use App\Models\Tag;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class TagsTable extends LivewireDatatable
{
    protected $listeners = ['refreshTable'];
    public $exportable = true;

    public function builder()
    {
        return Tag::where('user_id', $this->params['user_id']);
    }

    public function columns()
    {
        return [
            Column::name("id")->defaultSort('desc')->hide(),
            Column::name("name")->label("Name")->searchable(),
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