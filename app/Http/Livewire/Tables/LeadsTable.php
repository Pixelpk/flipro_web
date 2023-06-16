<?php

namespace App\Http\Livewire\Tables;

use App\Models\Lead;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\DateColumn;
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
            Column::name("id")->defaultSort('desc')->hide(),
            DateColumn::raw('created_at')
            ->label('Created date')
            ->format('d-m-Y'),
            Column::name("name")->label("Name")->searchable(),
            Column::name("email")->label("Email")->searchable(),
            Column::callback(['phone_code', 'phone'], function($phoneCode, $phone){
                // return $phoneCode . $phone;
                $phonemew = ltrim($phone, "0");
                // return $phonemew;
                return  $phoneCode . ' ' .substr($phonemew, 0, 3) . " " . substr($phonemew, 3, 3) . " " . substr($phonemew, 6);
            })->label("Phone")->searchable(),
            Column::name("address")->label("Project Address"),
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
            })->label('Tags & Segments')
            ->excludeFromExport(),
            // ->exportCallback(function ($value) {
            //     if($value){
            //         return "Active";
            //     }else{
            //         return "In-Active";
            //     }
            // }),
            Column::callback(['id'], function($id){
                $editAction = "<span wire:click='edit($id)'><i class='bx bx-pencil'></i></span>";
                $deleteAction = "<span wire:click='delete($id)'><i class='bx bx-trash text-danger ml-2'></i></span>";
                return (request()->user()->hasRole('update-leads') ? $editAction : '') . ' ' . (request()->user()->hasRole('delete-leads') ? $deleteAction : '');
            })->excludeFromExport(),
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