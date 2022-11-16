<?php

namespace App\Http\Livewire\Tables;

use App\Models\Lead;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class LeadsTable extends LivewireDatatable
{
    protected $listeners = ['refreshTable'];
    public $exportable = true;

    public function builder()
    {
        return Lead::where('user_id', $this->params['user_id']);
    }

    public function columns()
    {
        return [
            Column::name("name")->label("Name")->searchable(),
            Column::name("email")->label("Email")->searchable(),
            Column::callback(['phone_code', 'phone'], function($phoneCode, $phone){
                return $phoneCode . $phone;
            })->label("Phone")->searchable(),
            Column::name("address")->label("Address"),
            Column::callback('id', function($id){
                $tags = Lead::find($id)->tags;
                $tagstr = ''; 
                foreach($tags as $item){
                    $tagstr .= '<div class="chip mr-1">
                                <div class="chip-body">
                                    <span class="chip-text">'.$item->name.'</span>
                                </div>
                            </div>';
                }

                $segments = Lead::find($id)->segments;
                $segmentstr = ''; 
                foreach($segments as $item){
                    $segmentstr .= '<div class="chip mr-1">
                                <div class="chip-body">
                                    <span class="chip-text">'.$item->name.'</span>
                                </div>
                            </div>';
                }
                return "<b>Segments: </b>" . $segmentstr . "<br><b>Tags: </b>" . $tagstr;
            })->label('Tags & Segments'),
            Column::callback(['id'], function($id){
                $editAction = "<span wire:click='edit($id)'><i class='bx bx-pencil'></i></span>";
                $deleteAction = "<span wire:click='delete($id)'><i class='bx bx-trash text-danger ml-2'></i></span>";
                return (request()->user()->hasRole('update-leads') ? $editAction : '') . ' ' . (request()->user()->hasRole('delete-leads') ? $deleteAction : '');
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