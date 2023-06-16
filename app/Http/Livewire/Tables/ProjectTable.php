<?php

namespace App\Http\Livewire\Tables;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\DateColumn;

class ProjectTable extends LivewireDatatable
{
    public $hideable = 'select';
    protected $listeners = ['refreshTable'];

    public function builder()
    {
        $user = Auth::user();
        $projects = Project::query();
        if(!$user->hasRole('administrator')){
            return $projects->where('user_id', Auth::id())->orWhere('lead_user_id', Auth::id());
        }

        return $projects;
    }

    public function columns()
    {
        return [
            Column::name("id")->defaultSort('desc')->hide(),
            DateColumn::raw('created_at')
            ->label('Created date')
            ->hide()
            ->format('d-m-Y'),

            // Column::name('title')->searchable(),
           

            Column::callback(['id', 'title'], function ($id, $title) {
                return "<a href='projects/$id'>$title</a>";
            })->label('Title'),


            Column::name("area")->hide()->label('Area'),
            Column::name("description")->hide()->label('Description'),
            Column::name("approved")->hide()->label('Approved'),
            Column::name("registered_owners")->hide()->label('Registered Owner'),
            
            Column::name('applicant_name')->searchable()->label('Applicant Name'),
            
            Column::callback(['anticipated_budget'], function($value){
                return '$'.number_format((float)$value);
            })->label('Anticipated Budget'),
            
            // Column::name('anticipated_budget')->searchable(),
            Column::name('project_address')->searchable()->label('Project Address'),
            Column::name('project_state')->searchable()->label('Project State'),
            // Column::name('phone')->searchable(),
            
            Column::callback(['phone', 'phone_code'], function($phone, $phone_code) 
            {
                $phone = ltrim($phone, "0");
                return   $phone_code . ' ' . substr($phone, 0, 3) . " " . substr($phone, 3, 3) . " " . substr($phone, 6);
                
            })->searchable()->label('Phone'),

            
            Column::name('email')->searchable()->label('Email'),
            // Column::name('current_property_value')->searchable(),
            Column::callback(['current_property_value'], function($value){
                return '$'.number_format((float)$value);
            })->label('Current Property Value'),
            // Column::name('property_debt'),
            Column::callback(['property_debt'], function($value){
                return '$'.number_format((float)$value);
            })->label('Property Debt'),
            Column::callback(['cross_collaterized'], function($value){
                return $value ? 'Yes' : 'No';
            })->label('Cross Collaterized'),
            Column::callback(['user_id'], function($userId){
                return User::find($userId)->name ?? '';
            })->label('Partners'),
            Column::callback(['lead_user_id'], function($userId){
                return User::find($userId)->name ?? "Not Assigned";
            })->label('Home Owner'),
            Column::name('status'),
            Column::callback(['id','status', 'approved'], function($id,$status,$approved)
            {
                if($status == 'new')
                {
                    return "<div style='width:100px'><i class='bx bx-pencil' wire:click='edit($id)'></i> <a href='/projects/$id'><i class='bx bx-show-alt'></i></a></div>";
                }else{
                    return "<div style='width:100px'> <a href='/projects/$id'><i class='bx bx-show-alt'></i></a></div>";
                }

            })->label('Action'),
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