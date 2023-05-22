<?php

namespace App\Http\Livewire\Tables;

use App\Models\Lead;
use App\Imports\LeadImport;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;


class LeadsTable extends LivewireDatatable
{
    use WithFileUploads;

    protected $listeners = ['refreshTable'];
    public $exportable = true;
    public $exelfile;

    public function builder()
    {
        return Lead::where('user_id', $this->params['user_id']);
    }

    public function columns()
    {
        return [
            DateColumn::raw('created_at')
            ->label('Created date')
            ->format('d-m-Y'),
            Column::name("name")->label("Name")->searchable(),
            Column::name("email")->label("Email")->searchable(),
            Column::callback(['phone_code', 'phone'], function($phoneCode, $phone){
                return isset($phoneCode) ? $phoneCode . $phone : "123";
            })->label("Phone")->searchable(),
            Column::name("address")->label("Address")->searchable(),
            Column::callback('id', function($id){
                $tags = Lead::find($id)->tags;  
                $tagstr = ''; 
                foreach($tags as $item){
                    $tagstr .= '<div class="chip mr-1">
                                <div class="chip-body">
                                    <span class="chip-text">'.isset($item->name) ? $item->name: null.'</span>
                                </div>
                            </div>';
                }

                $segments = Lead::find($id)->segments;
                $segmentstr = ''; 
                foreach($segments as $item){
                    $segmentstr .= '<div class="chip mr-1">
                                <div class="chip-body">
                                    <span class="chip-text">'.isset($item->name) ? $item->name: null.'</span>
                                </div>
                            </div>';
                }
                return "<b>Segments: </b>" . $segmentstr . "<br><b>Tags: </b>" . $tagstr;
            })->label('Tags & Segments'),
            Column::callback(['id'], function($ids){
                $editAction = "<span wire:click='edit($ids)'><i class='bx bx-pencil'></i></span>";
                $deleteAction = "<span wire:click='delete($ids)'><i class='bx bx-trash text-danger ml-2'></i></span>";
                return (request()->user()->hasRole('update-leads') ? $editAction : '') . ' ' . (request()->user()->hasRole('delete-leads') ? $deleteAction : '');
            })->label('Actions'),
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
    public function import()
    {
    //    dd($this->exelfile);
        $this->validate([
            'exelfile' => 'required|mimes:xlsx,xls,csv',
        ]);
       
        Excel::import(new LeadImport, $this->exelfile);
        return redirect()->to('leads');
    }
}