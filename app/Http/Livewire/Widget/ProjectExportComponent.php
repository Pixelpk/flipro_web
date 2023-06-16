<?php

namespace App\Http\Livewire\Widget;

use App\Models\Event;
use App\Models\Project;
use Livewire\Component;

class ProjectExportComponent extends Component
{
    public $project;
    public $tasks;

    public function mount($project)
    {
        $this->project = Project::find($project);
        $this->tasks = Event::with('attachedUser', 'attachedLead', 'createdBy')->where('project_id', $this->project->id)
        ->orderBy('id', 'desc')
        ->get();
    }
    public function render()
    {
        return view('livewire.widget.project-export-component') ->layout('layouts.pdf');
    }
}
