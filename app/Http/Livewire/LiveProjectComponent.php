<?php

namespace App\Http\Livewire;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class LiveProjectComponent extends Component
{
    use WithFileUploads;
    public $projects;
    public $user;
    public $model;
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


    protected $listeners = [
        'editModel' => 'edit',
    ];

    public function mount()
    {
        $this->user = Auth::user();
        $this->model = new Project();
        $this->model['phone_code']  = 61;
        $this->model->cross_collaterized = 0;
        $this->homeowers = User::homeowners()->get();
        $this->model->cross_collaterized = false;
        $this->projects = Project::where('user_id', Auth::id())->get();
        $this->franchises = User::franchises()->get();
        $this->builders = User::builders()->get();
        $this->evaluators = User::evaluators()->get();
        $this->partTakers = collect([]);

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

    public function edit(Project $project)
    {
        $this->resetErrorBag();
        $this->model = $project;

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
       
       
        $this->model['phone_code'] = "+61";
        $this->model['anticipated_budget'] = str_replace( ',', '', $this->model['anticipated_budget']);
        $this->model['property_debt'] = str_replace( ',', '', $this->model['property_debt']);
        $this->model['current_property_value'] = str_replace( ',', '', $this->model['current_property_value']);
        // dd($this->partTakers);
        $this->validate();
        $data = collect($this->model)->except('pushImage','images', 'videos', 'project_roles', 'action_required', 'builders', 'lead', 'evaluators', 'franchisee', 'assigned', 'cover_photo', 'progress_satisfied', 'evaluation_satisfied', 'final_progress_reviews', 'evaluation_reviews', 'latest_payment_request', 'latest_note', 'latest_progress', 'latest_value', 'progress_reviewed', 'evaluation_reviewed')->toArray();
        $data['project_address'] = $this->model['title'];
        // dd($data);

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

        if($this->videos){
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
    public function formatNumber()
    {
        $inputString = $this->model['current_property_value'];

        // Remove any non-numeric characters from the input string
        $inputString = preg_replace('/[^0-9]/', '', $inputString);
    
        // dd('Input string: ' . $inputString);
    
        // Format the number with grouped thousands separators (commas) and no decimal places
        $formattedNumber = number_format($inputString, 0);
    
        // dd('Formatted number: ' . $formattedNumber);
    
        $this->model['current_property_value'] = $formattedNumber;
    }

}