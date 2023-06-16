<?php

namespace App\Http\Livewire;

use App\Models\Lead;
use App\Models\User;
use App\Models\Project;
use App\Models\ProjectAccess;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class LiveProjectComponent extends Component
{
    use WithFileUploads;
    public $projects;
    public $user;
    public $model;
    public $columns;

    public $images = [];
    public $pushImage = [];
    public $pushVideos = [];
    public $videos;
    public $homeowers;
    public $franchises;
    public $builders;
    public $partTakers = [];
    public $franchise;
    public $builder;
    public $evaluator;
    public $leads = [];
    public $lead_id;
    public $evaluators;
    public $same_owner;


    protected $listeners = [
        'editModel' => 'edit',
    ];

    public function mount()
    {
        
        $this->leads = Lead::orderBy('id', 'desc')->get();
        $this->user = Auth::user();
        $this->model = new Project();
        $this->columns = Schema::getColumnListing('projects');
        // dd($this->columns);
        $this->model['phone_code']  = "+61";
        $this->model['area']  = 0;
        $this->model['anticipated_budget']  = 0;
        $this->model['current_property_value']  = 0;
        $this->model['property_debt']  = 0;
        $this->model->cross_collaterized = 0;
        $this->homeowers = User::homeowners()->get();
        $this->model->cross_collaterized = false;
        $this->projects = Project::where('user_id', Auth::id())->get();
        $this->franchises = User::franchises()->get();
        $this->builders = User::builders()->get();
        $this->evaluators = User::evaluators()->get();
        $this->partTakers = collect([]);

    }

    public function getLeadData()
    {
        $lead = Lead::find($this->lead_id);
        $this->model['applicant_name'] = $lead->name;
        $this->model['email'] = $lead->email;
        $this->model['phone'] = $lead->phone;
        $this->model['phone_code'] = $lead->phone_code;
        $this->model['title'] = $lead->address;
        if($this->same_owner) {
            $this->model['registered_owners'] = $lead->name;
        }else{
            $this->model['registered_owners'] = null;
        }
        $this->dispatchBrowserEvent('phone-updated', ['newPhone' => $lead->phone]);
    }

    protected $rules = [
        'model.title' => 'required',
        'model.area' => 'required',
        'model.project_state' => 'required',
        'model.description' => 'required',
        'model.anticipated_budget' => 'required',
        //'model.project_address' => 'required',
        'model.contractor_supplier_details' => 'required',
        'model.applicant_name' => 'required',
        'model.email' => 'required|email',
        'model.phone' => 'required',
        'model.phone_code' => 'required',
        'model.applicant_address' => 'required',
        'model.registered_owners' => 'required',
        'model.current_property_value' => 'required',
        'model.property_debt' => 'required',
        'model.cross_collaterized' => 'nullable|boolean',
    ];

    protected $validationAttributes = [
        'model.title' => 'project address',
        'model.anticipated_budget' => 'anticipated budget',
        //'model.project_address' => 'title',
        'model.contractor_supplier_details' => 'Existing queries',
        'model.applicant_name' => 'applicant name',
        'model.email' => 'email',
        'model.phone' => 'phone',
        'model.phone_code' => 'phone code',
        'model.applicant_address' => 'applicant address',
        'model.registered_owners' => 'registered owner',
        'model.current_property_value' => 'property value',
        'model.property_debt' => 'property debts',
        'model.cross_collaterized' => 'cross collaterized',
    ];

    public function render()
    {
        return view('livewire.live-project-component');
    }

    public function checkSameowner()
    {
        if($this->same_owner) {
            $this->model['registered_owners'] = $this->model['applicant_name'];
        } else{
            $this->model['registered_owners'] = null;
        }
    }   

    public function edit(Project $project)
    {
        $this->resetErrorBag();
        $this->model = $project;
        $this->dispatchBrowserEvent('phone-updated', ['newPhone' => $project->phone]);

        $this->dispatchBrowserEvent('toggleModal', [
            'id' => "createModal",
            'action' => 'show'
        ]);
    }

    public function update()
    {
        $this->validate();
        $images = $this->model->photos ?? [];
        $videos = $this->model->videos ?? [];
        if($this->images){
            foreach($this->images as $image){
                $image = $image->store('project-files');
                $images[] = url("stream/".$image);
            }
            $this->model->photos = $images;
        }

        if($this->videos){
            foreach($this->videos as $video){
                $video = $video->store('project-files');
                $videos[] = ['thumbnail' => '', 'file' => 'url("stream/".$video)'];
            }
            $this->model->videos = $videos;
        }
        $this->model['phone'] = str_replace(' ', '', $this->model['phone']);
        $this->model->update();


        $this->dispatchBrowserEvent('alert', [
            'title'=> "Success",
            'text'=> 'Project updated successfully',
            'type'=> "success",
            'confirmButtonClass'=> 'btn btn-primary',
            'buttonsStyling'=> false,
        ]);

        $this->emit('refreshTable');

        $this->dispatchBrowserEvent('toggleModal', [
            'id' => "createModal",
            'action' => 'hide'
        ]);

        return redirect('/projects/'.$this->model->id);
        $this->reset(['model']);
    }

    public function openModal()
    {
        $this->resetErrorBag();
        $this->reset(['model', 'images']);
        $this->model = new Project();
        $this->model->cross_collaterized = 0;
        $this->images = null;
    }

    public function updatedImages()
    {
      
        $this->validate([
            'images.*' => 'image|max:1024', // 1MB Max
        ]);
        foreach($this->images as $image)
        {
            array_push($this->pushImage, $image);
        }
    }
    public function updatedVideos()
    {
        $this->validate([
            'videos.*' => 'nullable|max:60024', // 60MB Max
        ]);
        foreach($this->videos as $video){
            array_push($this->pushVideos, $video);
        }
    }

    public function create()
    {
        // dd($this->model);
        // $this->model['phone_code'] = "+61";
        // dd('asd');
        // dd($this->partTakers);
        $this->validate();
        $data = collect($this->model)->except('pushImage','images', 'videos', 'project_roles', 'action_required', 'builders', 'lead', 'evaluators', 'franchisee', 'assigned', 'cover_photo', 'progress_satisfied', 'evaluation_satisfied', 'final_progress_reviews', 'evaluation_reviews', 'latest_payment_request', 'latest_note', 'latest_progress', 'latest_value', 'progress_reviewed', 'evaluation_reviewed')->toArray();
        $data['project_address'] = $this->model['title'];
        // dd($data);
        $data['phone'] = str_replace(' ', '', $this->model['phone']);
        $project = Project::forceCreate($data);
        $images = [];
        $videos = [];
        
        if($this->images)
        {
            foreach($this->pushImage as $image){
                $image = $image->store('project-files');
                $images[] = url("/stream/$image");
            }
            $project->photos = $images;
        }

        if($this->videos)
        {
            foreach($this->pushVideos as $video){
                $video = $video->store('project-files');
                $videos[] = ['file' => url("/stream/$video"), 'thumbnail' => url("/video.png")];
            }
            $project->videos = (array)$videos;
        }

        $project->user_id = Auth::id();
        if(Auth::user()->user_type == 'admin')
        {
            $project->approved = 'approved';
           
            $getRoles = config('roles.projectRoles');
        
            $roles = [];
        
            foreach($getRoles as $role){
                $roles[$role] = false;
                if(in_array($role, $getRoles)){
                    $roles[$role] = true;
                }
            }

           
            ProjectAccess::forceCreate([
                'project_id' => $project->id,
                'acting_as' => 'franchise',
                'roles' => $roles,
                'user_id' => auth()->user()->id,
            ]);
            
        }
        else
        {
            $project->approved = 'pending';
        }
        $project->update();

        $this->dispatchBrowserEvent('alert', [
            'title'=> "Success",
            'text'=> 'Project created successfully',
            'type'=> "success",
            'confirmButtonClass'=> 'btn btn-primary',
            'buttonsStyling'=> false,
        ]);

        $this->emit('refreshTable');

        $this->dispatchBrowserEvent('toggleModal', [
            'id' => "createModal",
            'action' => 'hide'
        ]);
        return redirect('/projects/'. $project->id);
        $this->reset(['model', 'images']);
    }

    public function delpushImage($index)
    {
        unset($this->pushImage[$index]);
    }
    public function delpushVideos($index)
    {
        unset($this->pushVideos[$index]);
    }

    public function delAllVideos()
    {
        $this->pushVideos = [];
    }
    public function delAllImages()
    {
        $this->pushImage = [];
    }

    public function assignValue()
    {
        $this->model['area'] = 0;
    }

    // public function phoneFomat()
    // {
    //     $mobileNumber= $this->model['phone'];
    //     $formattedNumber = substr($mobileNumber, 0, 2) . " " . substr($mobileNumber, 2, 2) . " " . substr($mobileNumber, 4, 4) . " " . substr($mobileNumber, 8);
    //     return $formattedNumber;
    // }

    
}