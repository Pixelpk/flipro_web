<?php

namespace App\Http\Livewire\Tables;

use App\Models\EmailCampaign;
use App\Models\Segment;
use App\Models\Tag;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class CampaignsTable extends LivewireDatatable
{
    protected $listeners = ['refreshTable'];
    public $exportable = true;

    public function builder()
    {
        return EmailCampaign::where('user_id', $this->params['user_id']);
    }

    public function columns()
    {
        return [
            Column::name("name")->label("Name")->searchable(),
            Column::callback(['segment_id'], function($id){
                $segment = Segment::find($id);
                return $segment ? $segment->name : '';
            })->label('Email List'),
            Column::callback(['tag_id'], function($id){
                $segment = Tag::find($id);
                return $segment ? $segment->name : '';
            })->label('Tag'),
            Column::callback(['campaign_type'], function($class){
                $obj = new $class();
                return $obj->getName();
            })->label('Trigger'),
            Column::name("description")->label("Description")->searchable(),
            Column::callback(['id', 'active'], function($id, $active){
                $checked = $active ? 'checked' : '';
                return "<input type='checkbox' value='1' wire:change='toggleActive($id, $active)' $checked>";
            })->label('Active'),
            Column::callback(['id'], function($id){
                $editAction = "<span wire:click='edit($id)'><i class='bx bx-pencil'></i></span>";
                $editAction .= "<a href='/campaigns/configure/$id'><span><i class='bx bx-cog ml-2'></i></span></a>";
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

    public function toggleActive($id, $active)
    {
        $campaign = EmailCampaign::find($id);
        $campaign->active = !$active;
        $campaign->update();
    }
}