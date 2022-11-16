<?php

namespace App\Http\Livewire\Widget;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class LiveBoardWidget extends Component
{
    use WithPagination;

    public $user;
    protected $projects;
    public $search;

    public function mount()
    {
        $this->user = Auth::user();
        $this->projects = Project::when(!$this->user->hasRole('administrator'), function($query) {
            $query->where(function($q) {
                $q->where('user_id', $this->user->id)->orWhere('lead_user_id', $this->user->id);
            });
        })->orderBy('created_at', 'desc');
    }

    public function getNewProjects()
    {
        $this->mount();
        return $this->projects->clone()->where('status', 'new')->where('approved', 'approved');
    }

    public function getInprogressProjects()
    {
        return $this->projects->clone()->where('status', 'in-progress');
    }

    public function getCompletedProjects()
    {
        return $this->projects->clone()->where('status', 'complete');
    }

    public function getClosedProjects()
    {
        return $this->projects->clone()->where('status', 'closed');
    }

    public function getPendingProjects()
    {

        return $this->projects->clone()->whereIn('approved', ['pending', 'rejected']);
    }

    public function getSearchProjects()
    {

        $search = $this->search;
        if($search){
            return $this->projects->where('title', 'like', $search .'%');
        }

    }



    public function render()
    {
        return view('livewire.widget.live-board-widget', [
            'newProjects' => $this->getNewProjects()->paginate(config('app.pageSize')),
            'inProgressProjects' => $this->getInprogressProjects()->paginate(config('app.pageSize')),
            'completedProjects' => $this->getCompletedProjects()->paginate(config('app.pageSize')),
            'closedProjects' => $this->getClosedProjects()->paginate(config('app.pageSize')),
            'pendingProjects' => $this->getPendingProjects()->paginate(config('app.pageSize')),
            'SearchProjects' => $this->search ?  $this->getSearchProjects()->paginate(config('app.pageSize')) : [],
        ]);
    }
}
