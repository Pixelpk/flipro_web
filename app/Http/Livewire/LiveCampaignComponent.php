<?php

namespace App\Http\Livewire;

use App\Models\EmailCampaign;
use App\Models\Segment;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LiveCampaignComponent extends Component
{
    protected $listeners = ['editModel' => 'edit', 'deleteModel' => 'deleteConfirmation'];

    public $user;
    public $name;
    public $description;
    public $model;
    public $types;
    public $campaign_type;
    public $segment_id;
    public $tag_id;
    public $segments;
    public $tags;

    protected $rules = [
        'name' => 'required',
        'campaign_type' => 'required',
        'segment_id' => 'nullable',
        'tag_id' => 'nullable',
        'description' => 'nullable',
        'model' => 'nullable',
    ];

    public function mount()
    {
        $this->user = Auth::user();
        $this->types = config('mailables.classes');
        $this->segments = Segment::where('user_id', $this->user->id)->get();
        $this->tags = Tag::where('user_id', $this->user->id)->get();
        if(!$this->user->hasRole('view-campaigns')) abort(403);
    }

    public function create()
    {
        $this->validate();
        $user = EmailCampaign::forceCreate([
            'name' => $this->name,
            'description' => $this->description,
            'campaign_type' => $this->campaign_type,
            'segment_id' => $this->segment_id,
            'tag_id' => $this->tag_id,
            'user_id' => $this->user->id
        ]);

        $this->dispatchBrowserEvent('alert', [
            'title'=> "Success",
            'text'=> 'Campaign created successfully',
            'type'=> "success",
            'confirmButtonClass'=> 'btn btn-primary',
            'buttonsStyling'=> false,
        ]);

        $this->emit('refreshTable');
        $this->dispatchBrowserEvent('toggleModal', [
            'id' => "createModal",
            'action' => 'hide'
        ]);
        $this->reset([
            'name', 'description', 'model'
        ]);
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'campaign_type' => 'required',
            'segment_id' => 'nullable',
            'tag_id' => 'nullable',
            'description' => 'required',
        ]);

        $this->model->name = $this->name;
        $this->model->campaign_type = $this->campaign_type;
        $this->model->segment_id = $this->segment_id;
        $this->model->tag_id = $this->tag_id;
        $this->model->description = $this->description;

        $this->model->update();

        $this->dispatchBrowserEvent('alert', [
            'title'=> "Success",
            'text'=> 'Campaign updated successfully',
            'type'=> "success",
            'confirmButtonClass'=> 'btn btn-primary',
            'buttonsStyling'=> false,
        ]);

        $this->emit('refreshTable');
        $this->dispatchBrowserEvent('toggleModal', [
            'id' => "createModal",
            'action' => 'hide'
        ]);
        $this->reset([
            'name', 'description', 'model'
        ]);
    }

    public function openModal()
    {
        $this->reset([
            'name', 'description', 'model'
        ]);
    }

    public function edit(EmailCampaign $campaign)
    {
        $this->model = $campaign;
        $this->name = $campaign->name;
        $this->campaign_type = $campaign->campaign_type;
        $this->segment_id = $campaign->segment_id;
        $this->tag_id = $campaign->tag_id;
        $this->description = $campaign->description;

        $this->dispatchBrowserEvent('toggleModal', [
            'id' => "createModal",
            'action' => 'show'
        ]);
    }

    public function deleteConfirmation(EmailCampaign $campaign)
    {
        $this->model = $campaign;
        $this->dispatchBrowserEvent('toggleModal', [
            'id' => "deleteModal",
            'action' => 'show'
        ]);
    }

    public function delete()
    {
        $this->model->delete();
        $this->emit('refreshTable');
        $this->reset([
            'name', 'description', 'model'
        ]);
        $this->dispatchBrowserEvent('toggleModal', [
            'id' => "deleteModal",
            'action' => 'hide'
        ]);
        $this->dispatchBrowserEvent('alert', [
            'title'=> "Success",
            'text'=> 'Campaign deleted successfully',
            'type'=> "success",
            'confirmButtonClass'=> 'btn btn-primary',
            'buttonsStyling'=> false,
        ]);
    }

    public function render()
    {
        return view('livewire.live-campaign-component');
    }
}
