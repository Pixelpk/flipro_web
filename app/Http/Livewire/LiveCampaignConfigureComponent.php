<?php

namespace App\Http\Livewire;

use App\Models\CampaignEventLog;
use App\Models\EmailCampaign;
use App\Models\EmailCampaignEvent;
use App\Models\EmailTemplate;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use PDO;

class LiveCampaignConfigureComponent extends Component
{
    public $user;
    public $model;
    public $campaign;
    public $content;
    protected $campaignType;
    public $campaignTypeName;
    public $campaignTypeDescription;
    public $events = [];
    public $emailEvent = [];
    public $waitEvent = [];
    public $tagEvent = [];
    public $labels;
    public $emailContent;
    public $emailTemplates;
    public $subject;
    public $templateId = '';
    public $leads;
    public $totalCompleted;
    public $partTakerCount;
    
    protected $listeners = ['contentChanged' => 'updateContent', 'eventdroped' => 'handleDrop', 'emailBodyChanged'];

    protected $rules = [
        'emailEvent.subject' => 'nullable',
        'emailEvent.body' => 'nullable',
        'emailEvent.eventType' => 'nullable',
        'waitEvent.days' => 'nullable',
        'tagEvent.add' => 'nullable',
        'tagEvent.remove' => 'nullable',
        'tagEvent.addraw' => 'nullable',
        'tagEvent.removeraw' => 'nullable',
    ];

    public function emailBodyChanged($data)
    {
        $this->emailEvent['body'] = $data;
    }

    public function updateContent($content)
    {
        $this->content = $content;
    }

    public function moveUp($position)
    {
        $currentEvent = EmailCampaignEvent::where('email_campaign_id', $this->campaign->id)->where('position', $position)->first();
        $upperPosition = EmailCampaignEvent::where('email_campaign_id', $this->campaign->id)->where('position', $position - 1)->first();
        $currentEvent->position = $position -1;
        $currentEvent->update();
        $upperPosition->position = $position;
        $upperPosition->update();
        $this->fetchEvents();
    }

    public function moveDown($position)
    {
        $currentEvent = EmailCampaignEvent::where('email_campaign_id', $this->campaign->id)->where('position', $position)->first();
        $lowerPosition = EmailCampaignEvent::where('email_campaign_id', $this->campaign->id)->where('position', $position + 1)->first();
        $currentEvent->position = $position +1;
        $currentEvent->update();
        $lowerPosition->position = $position;
        $lowerPosition->update();
        $this->fetchEvents();
    }

    public function remove($key)
    {
        $this->events[$key]->delete();
        $this->fetchEvents();
        $position = 1;
        foreach($this->events as $key => $event){
            $event->position = $position;
            $event->update();
            ++$position;
        }
        $this->fetchEvents();
    }

    public function addEmailEvent()
    {
        $this->validate([
            'templateId' => 'required',
        ]);

        $template = EmailTemplate::find($this->templateId);

        $data = [
            'position' => $this->newPosition(),
            'event_type' => \App\Libs\Campaigns\Events\Email::class,
            'data' => json_encode([
                'subject' => $template->name,
                'body' => $template->content
            ]),
            'email_campaign_id' => $this->campaign->id
        ];

        $this->templateId = '';

        EmailCampaignEvent::forceCreate($data);
        $this->fetchEvents();
        $this->dispatchBrowserEvent('toggleModal', [
            'id' => "createEmailModal",
            'action' => 'hide'
        ]);

    }

    public function createEmail()
    {
        $this->validate([
            'subject' => 'required'
        ]);

        $email = EmailTemplate::forceCreate([
            'name' => $this->subject,
            'content' => Storage::disk('htmlTemplates')->get('/blank.html'),
            'user_id' => $this->user->id
        ]);
        $this->getEmailTemplates();
        $this->templateId = $email->id;
        $this->subject = '';
    }

    public function addWaitEvent()
    {
        $this->validate([
            'waitEvent.days' => 'required'
        ], [], ['waitEvent.days' => 'days']);

        $data = [
            'position' => $this->newPosition(),
            'event_type' => \App\Libs\Campaigns\Events\Wait::class,
            'data' => json_encode($this->waitEvent),
            'email_campaign_id' => $this->campaign->id
        ];

        EmailCampaignEvent::forceCreate($data);

        $this->fetchEvents();
        
        $this->dispatchBrowserEvent('toggleModal', [
            'id' => "createWaitModal",
            'action' => 'hide'
        ]);

    }

    public function showEmail($key)
    {
        $this->emailContent = json_decode($this->events[$key]['data'])->body;
        $this->dispatchBrowserEvent('toggleModal', [
            'id' => "showEmailModal",
            'action' => 'show'
        ]);
    }

    public function addTagEvent()
    {   
        $toAdd = isset($this->tagEvent['add']) ? implode(', ', Tag::whereIn('id', $this->tagEvent['add'])->pluck('name')->toArray()) : '';
        $toRemove = isset($this->tagEvent['remove']) ? implode(', ', Tag::whereIn('id', $this->tagEvent['remove'])->pluck('name')->toArray()) : '';
        if($toAdd === '' && $toRemove === ''){
            $this->addError('tags', 'Please select atleast one tag to add or remove');
            return;
        }
        $this->tagEvent['addraw'] = $toAdd;
        $this->tagEvent['removeraw'] = $toRemove;

        $data = [
            'position' => $this->newPosition(),
            'event_type' => \App\Libs\Campaigns\Events\Tag::class,
            'data' => json_encode($this->tagEvent),
            'email_campaign_id' => $this->campaign->id
        ];

        EmailCampaignEvent::forceCreate($data);

        $this->fetchEvents();

        $this->dispatchBrowserEvent('toggleModal', [
            'id' => "createTagModal",
            'action' => 'hide'
        ]);

    }

    public function newPosition()
    {
        $events = collect($this->events);
        $position = 1;
        if($events->count() != 0){
            $position = $events->max('position') + 1;
        }

        return $position;
    }

    public function fetchEvents()
    {
         $this->events = EmailCampaignEvent::where('email_campaign_id', $this->campaign->id)->orderBy('position')->get();
    }
    
    public function getEmailTemplates()
    {
        $this->emailTemplates = EmailTemplate::where('user_id', $this->user->id)->get();
    }

    public function mount(Request $request, EmailCampaign $campaign)
    {

        $this->user = Auth::user();
        $this->campaign = $campaign;
        $this->leads = $campaign->campaign_type::getLeads($campaign)->get();
        $this->partTakerCount = $this->leads->count() + CampaignEventLog::where('email_campaign_id', $campaign->id)->where('failed', false)->whereNotIn('lead_id', $this->leads->pluck('id')->toArray())->groupBy('lead_id')->get()->count();
        $this->totalCompleted = $campaign->campaign_type::countCompleted($campaign);
        $this->campaignType = new $campaign->campaign_type;
        $this->campaignTypeName = $this->campaignType->getName();
        $this->campaignTypeDescription = $this->campaignType->getDescription();
        $this->labels = Tag::all();
        $this->getEmailTemplates();
        $this->fetchEvents();
    }

    public function submit()
    {
        // Process form data, save to the database, etc.
      
		// Emit the reinit event after you've done processing the form
        $this->emit('reinit');
    }

    public function delete()
    {
        
    }
    
    public function openModal()
    {
        
    }
    
    public function create()
    {
        
    }
    
    public function update()
    {
        
    }

    public function render()
    {
        return view('livewire.live-campaign-configure-component')->layout('layouts.app');
    }

}
