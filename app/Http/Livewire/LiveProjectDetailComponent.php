<?php

namespace App\Http\Livewire;

use App\Events\AdminPaymentRequest;
use App\Models\Event;
use App\Models\EventLog;
use App\Models\Lead;
use App\Models\PaymentRequest;
use App\Models\Progress;
use App\Models\Project;
use App\Models\ProjectAccess;
use App\Models\PropertyValue;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LiveProjectDetailComponent extends Component
{
    public Project $project;
    public $team;
    public $user;
    public $roles;
    public $userRoles = [];
    public $selectedUser;
    public $timeLine;
    public $homeOwnerRoles = [];
    public $builderRoles = [];
    public $franchiseRoles = [];
    public $valuerRoles = [];
    public $tasks;
    public $selectedTask;
    public $leads;
    public $users;
    public $propertyValue;
    public $projectAccess;
    public $progress;
    public $finalProgress;
    public $paymentRequestReason;
    public $paymentRequest;
    public $paymentRequestStatus;
    public $finalProgressReviews;
    public $client_satisfied;
    public $projectStatus;
    public $eventLogs = [];


    protected $listeners = ['projectClose', 'updatePrjectStatus'];

    protected $rules = [
        'selectedTask.status' => 'required',
        'selectedTask.action_taken' => 'nullable',
        'selectedTask.title' => 'required',
        'selectedTask.description' => 'required',
        'selectedTask.event_date' => 'required|date',
        'selectedTask.attached_user_id' => 'nullable',
        'selectedTask.lead_id' => 'nullable',
    ];


    protected $validationAttributes = [

        'selectedTask.status' => 'status',
        'selectedTask.action_taken' => 'action',
        'selectedTask.title' => 'title',
        'selectedTask.description' => 'description',
        'selectedTask.event_date' => 'task date',
        'selectedTask.attached_user_id' => 'user',
        'selectedTask.lead_id' => 'lead',
    ];

    public function softDelete()
    {
        // dd( $this->project->save());
        $this->project->deleted_at = now();
        $this->project->save();
        return redirect('/projects');
    }
    public function getEventLog()
    {
        $this->eventLogs  = EventLog::where('project_id', $this->project->id)->orderBy('id', 'desc')->get();
    }

    public function openTaskModal()
    {
        $this->dispatchBrowserEvent('toggleModal', [
            'id' => "taskModal",
            'action' => 'show',
        ]);
        $this->reset(['selectedTask']);
        $this->resetErrorBag();

    }
    public function openPaymentRequestModel($id,$status)
    {
        $this->paymentRequest = PaymentRequest::find($id);
        $this->paymentRequestStatus = $status;
        $this->dispatchBrowserEvent('toggleModal', [
            'id' => "paymentRequestModal",
            'action' => 'show',
        ]);
        $this->resetErrorBag();
    }
    public function openAddValueModal()
    {
        $this->dispatchBrowserEvent('toggleModal', [
            'id' => "addValueModal",
            'action' => 'show',
        ]);
        $this->propertyValue = null;
        // $this->reset(['selectedTask']);
        $this->resetErrorBag();
    }
    public function savePaymentRequestAction()
    {
        $this->paymentRequest->reason = $this->paymentRequestReason;
        $this->paymentRequest->status = $this->paymentRequestStatus;
        $this->paymentRequest->update();
        EventLog::forceCreate([
            'user_id' => Auth::user()->id,
            'project_id' => $this->project->id,
            'description' => $this->paymentRequestStatus == 'approved' ? Auth::user()->name." Payment request approved" : Auth::user()->name.' Payment request rejected',
            'status' => 4,
        ]);
        event(new AdminPaymentRequest($this->project, $this->paymentRequestStatus));
        $this->dispatchBrowserEvent('alert', [
            'title' => "Success",
            'text' => "Payment request $this->paymentRequestStatus successfully",
            'type' => "success",
            'confirmButtonClass' => 'btn btn-primary',
            'buttonsStyling' => false,
        ]);
        return redirect('/projects/' . $this->project->id);
    }

    public function saveTask()
    {
        $this->validate();
        if($this->selectedTask->project_id ?? false){
            $this->selectedTask->update();
            $this->dispatchBrowserEvent('toggleModal', [
                'id' => "taskModal",
                'action' => 'hide',
            ]);

            $this->dispatchBrowserEvent('alert', [
                'title' => "Success",
                'text' => 'Task saved successfully',
                'type' => "success",
                'confirmButtonClass' => 'btn btn-primary',
                'buttonsStyling' => false,
            ]);
            EventLog::forceCreate([
                'user_id' => Auth::user()->id,
                'project_id' => $this->project->id,
                'description' =>  Auth::user()->name. " edit new task",
                'status' => 7,
            ]);
            return redirect('/projects/' . $this->project->id);
        }
        else {
            $this->selectedTask['project_id'] = $this->project->id;
            $this->selectedTask['user_id'] = $this->user->id;
            Event::forceCreate($this->selectedTask);
            $this->dispatchBrowserEvent('toggleModal', [
                'id' => "taskModal",
                'action' => 'hide',
            ]);

            $this->dispatchBrowserEvent('alert', [
                'title' => "Success",
                'text' => 'Task saved successfully',
                'type' => "success",
                'confirmButtonClass' => 'btn btn-primary',
                'buttonsStyling' => false,
            ]);
            EventLog::forceCreate([
                'user_id' => Auth::user()->id,
                'project_id' => $this->project->id,
                'description' =>  Auth::user()->name. " create new task",
                'status' => 7,
            ]);
            return redirect('/projects/' . $this->project->id);
        }




        $this->reset(['selectedTask']);
        $this->resetErrorBag();
    }

    public function render()
    {
        // dd($this->user->email);
        return view('livewire.live-project-detail-component');
    }

    public function selectTask($task)
    {
        $this->reset(['selectedTask']);
        $this->resetErrorBag();
        $this->selectedTask = Event::with('createdBy','attachedLead','attachedUser')->find($task['id']);
    }

    public function addUser($type)
    {
        $this->validate([
            'selectedUser' => 'required'
        ], [
            'selectedUser.required' => 'Please select a user'
        ]);
        $oldRecord = $this->team->where('user_id', $this->selectedUser)->first();

        $roles = [];

        foreach($this->roles as $role){
            $roles[$role] = false;
            if(in_array($role, $this->userRoles)){
                $roles[$role] = true;
            }
        }

        if($oldRecord){
            $oldRecord->roles = $roles;
            $oldRecord->update();
        }else {
            ProjectAccess::forceCreate([
                'project_id' => $this->project->id,
                'acting_as' => $type,
                'roles' => $roles,
                'user_id' => $this->selectedUser
            ]);
        }
        $user = User::find($this->selectedUser);
        EventLog::forceCreate([
            'user_id' => Auth::user()->id,
            'project_id' => $this->project->id,
            'description' =>  $oldRecord ? Auth::user()->name." edit the access of $user->name" : Auth::user()->name." assigned $user->name to project",
            'status' => 6,
            'data' => $roles ? $roles :  null
        ]);
        $this->getTeam();
        $this->reset(['userRoles']);
    }

    public function getTeam()
    {
        $this->team = ProjectAccess::where('project_id', $this->project->id)->get();
    }

    public function deleteUser($item)
    {
        ProjectAccess::find($item['id'])->delete();
        $this->getTeam();
    }

    public function mount(Request $request, Project $project)
    {
        // dd('ads');
        $this->roles = config('roles.projectRoles');
        $this->homeOwnerRoles = config('roles.homeownerroles');
        // dd($this->homeOwnerRoles);
        $this->builderRoles = config('roles.builderroles');
        $this->franchiseRoles = config('roles.franchiseroles');
        // dd($this->franchiseRoles);
        $this->valuerRoles = config('roles.valuerroles');
        $this->user = Auth::user();

        $this->getTeam();
        $this->project = $project;
        $this->getProjectTimeline();
        $this->tasks = Event::with('attachedUser', 'attachedLead', 'createdBy')->where('project_id', $this->project->id)
        ->orderBy('id', 'desc')
        ->get();
        $this->leads = Lead::when($this->user->user_type != 'admin', function($q){
            $q->where('user_id', Auth::id());
        })->get();
        $this->users = User::when($this->user->user_type != 'admin', function($q){
            $q->where('created_by', Auth::id());
        })->get();
        $this->projectAccess = ProjectAccess::where('user_id', $this->user->id)->where('project_id', $this->project->id)->first();
        // dd($this->projectAccess->roles['add_value']);
        $this->finalProgress = Progress::where('project_id', $this->project->id)->where('final_progress', 1)->first();
        $this->client_satisfied = Progress::where('project_id', $this->project->id)->where('client_satisfied', 1)->first();
        $this->getEventLog();
        // dd( $this->finalProgress);

    }

    public function getFranchisesProperty()
    {
        return $this->team->where('acting_as', 'franchise');
    }

    public function getHomeOwnersProperty()
    {
        return $this->team->where('acting_as', 'home-owner');
    }

    public function getBuildersProperty()
    {
        return $this->team->where('acting_as', 'builder');
    }

    public function getEvaluatorsProperty()
    {
        return $this->team->where('acting_as', 'evaluator');
    }

    public function getProjectTimeline()
    {
        $this->timeLine = Progress::where('project_id', $this->project->id)->orderBy('id', 'desc')->get();
        $this->finalProgressReviews = Progress::where('project_id', $this->project->id)->whereIn('client_satisfied', [0,1])->get();
    }

    public function saveValue()
    {

        $this->validate([
            'propertyValue' => 'required',
        ]);

        $propertyValue = PropertyValue::where('project_id', $this->project->id)->first();

        EventLog::forceCreate([
            'user_id' => $this->user->id,
            'project_id' => $this->project->id,
            'description' =>  $this->user->name ." added $".   number_format((float)$this->propertyValue, 2)  ." value",
            'status' => 3,
        ]);
        PropertyValue::forceCreate([
            'user_id' => $this->user->id,
            'value' => $this->propertyValue,
            'project_id' => $this->project->id,
        ]);
        $this->dispatchBrowserEvent('alert', [
            'title' => "Success",
            'text' => 'Value saved successfully',
            'type' => "success",
            'confirmButtonClass' => 'btn btn-primary',
            'buttonsStyling' => false,
        ]);
        return redirect('/projects/' . $this->project->id);
    }
    public function addProggress()
    {
        $this->validate([
            'progress.reason' => "nullable",
            "progress.satisfaction" => "required",
        ]);
        Progress::forceCreate([
            'final_progress' => $this->progress['satisfaction'],
            'description' => $this->progress['reason'],
            'project_id' => $this->project->id,
            'user_id' => Auth::user()->id,
        ]);

        if(!$this->progress['satisfaction']){
            $this->project->status = 'in-progress';
            $this->project->update();
            EventLog::forceCreate([
                'user_id' => Auth::user()->id,
                'project_id' => $this->project->id,
                'description' => "Project is move to in-progress",
                'status' => 1,
            ]);
        }
        if($this->progress['satisfaction']){
            $this->project->status = 'complete';
            $this->project->update();
            EventLog::forceCreate([
                'user_id' => Auth::user()->id,
                'project_id' => $this->project->id,
                'description' => "Progress review added",
                'status' => 1,
            ]);
        }
        $this->dispatchBrowserEvent('alert', [
            'title' => "Success",
            'text' => 'Progress saved successfully',
            'type' => "success",
            'confirmButtonClass' => 'btn btn-primary',
            'buttonsStyling' => false,
        ]);
        return redirect('/projects/' . $this->project->id);
    }

    public function statusConfirmation($event)
    {
        // dd($event);
        $this->dispatchBrowserEvent('confirmation', ['message' => "Are you sure?", 'function' => $event]);
    }

    public function confirmAcceptPaymentRequest($id)
    {
        $this->dispatchBrowserEvent('confirmation', ['message' => "Are you sure?", 'function' => 'acceptPaymentRequest']);
    }
    public function acceptPaymentRequest($id)
    {
        $this->dispatchBrowserEvent('confirmation', ['message' => "Are you sure?", 'function' => 'acceptPaymentRequest']);
    }

    public function projectClose()
    {
        PropertyValue::forceCreate([
            'project_id' => $this->project->id,
            'user_id' => Auth::user()->id,
            'client_satisfied' => 1,
            "client_reviews" => "client reviews"
        ]);
        EventLog::forceCreate([
            'user_id' => Auth::user()->id,
            'project_id' => $this->project->id,
            'description' => "Project moved to close stage",
            'status' => 2,
        ]);
       $this->project->status = "closed";
       $this->project->update();
       $this->dispatchBrowserEvent('alert', [
        'title' => "Success",
        'text' => 'Progress saved successfully',
        'type' => "success",
        'confirmButtonClass' => 'btn btn-primary',
        'buttonsStyling' => false,
        ]);
        return redirect('/projects/' . $this->project->id);
    }
    public function confirmProjectStatus($status)
    {
        $this->projectStatus = $status;
        $this->dispatchBrowserEvent('confirmation', ['message' => "Are you sure?", 'function' => 'updatePrjectStatus']);
    }

    public function updatePrjectStatus()
    {
        $this->project->approved =  $this->projectStatus;
        $this->project->update();
        return redirect('/projects/' . $this->project->id);
    }
}