<?php

namespace App\Http\Livewire\Widget;

use App\Models\Progress;
use App\Models\Project;
use Livewire\Component;

class ProjectGallery extends Component
{
    public $project;
    public $timeLine = [];
    public function mount($project)
    {
        $this->project = Project::find($project);
        $this->timeLine = Progress::where('project_id', $this->project->id)->orderBy('id', 'desc')->get();
       
    }
    public function render()
    {
        return view('livewire.widget.project-gallery');
    }
}
