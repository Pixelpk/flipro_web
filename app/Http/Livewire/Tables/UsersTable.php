<?php

namespace App\Http\Livewire\Tables;

use App\Models\User;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class UsersTable extends LivewireDatatable
{
    protected $listeners = ['refreshTable'];
    public $exportable = true;
    
    public function builder()
    {
        // dd($this->params['usertype'])
        return User::where('user_type', $this->params['usertype']);
    }

    public function columns()
    {
        return [
            Column::name("id")->defaultSort('desc')->hide(),
            Column::name("name")->label("Name")->searchable(),
            Column::name("email")->label("Email")->searchable(),
            Column::callback(['phone_code', 'phone'], function($phoneCode, $phone){
                return $phoneCode . $phone;
            })->label("Phone")->searchable(),
            Column::name("address")->label("Address"),
            Column::callback(['id'], function($id){
                return "<span wire:click='edit($id)'><i class='bx bx-pencil'></i></span>";
            })
        ];
    }

    public function edit($id)
    {
        $this->emit('editModel', $id);
    }

    public function refreshTable()
    {
        $this->refreshLivewireDatatable();
    }
}