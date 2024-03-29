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
            Column::callback(['phone', 'phone_code'], function($phone, $phone_code) {
                // return   '+'.$phone_code . ' ' . chunk_split($phone, 3, ' ');
                $phone = ltrim($phone, "0");
                // return   $phone_code . ' ' . chunk_split($phonenew, 4, ' ');
                return $phone_code . ' ' .substr($phone, 0, 3) . " " . substr($phone, 3, 3) . " " . substr($phone, 6);
            })->label('phone')->searchable(),
            Column::name("address")->label("Address")->searchable(),
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