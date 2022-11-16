<?php

namespace App\Http\Livewire\Tables;

use App\Models\Contract;
use Illuminate\Support\Facades\Auth;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class ProjectContractTable extends LivewireDatatable
{
    public function builder()
    {
        $contracts = Contract::where('user_id', Auth::id())->where('project_id', '!=', 0);

        if(isset($this->params['withoutProject']) && $this->params['withoutProject'] == 'withoutProject'){
            $contracts = Contract::where('project_id', 0);
        }
        if(isset($this->params['project_id'])){
            $contracts = $contracts->where('project_id', $this->params['project_id']);
        }
        
        return $contracts;
    }

    public function columns()
    {
        return [
            Column::name('title'),
            Column::callback(['signatories'], function($signatories){
                $signatories = json_decode($signatories, false);

                $output = '';

                foreach($signatories as $key => $person){
                    $number = $key + 1;
                    preg_match_all("/[sig:[a-zA-Z]{4,}(?: [a-zA-Z]+){0,2},[a-z|A-Z||0-9|.|_]*@[a-z|A-Z]*.[a-z|A-Z]*]/i", $person, $text);
                    $signatory = Contract::parseSignatory($text[0][0]);
                    $output .= "$number) <b>Name: </b>" . ucfirst($signatory['name']) . ' | <b>Email: </b>' . $signatory['email'] . '<br>';
                }
                return $output;
            })->label('Signatories'),
            Column::name('status')->label('Status'),
            Column::name('updated_at')
        ];
    }
}