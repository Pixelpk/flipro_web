<?php
namespace App\Libs\Campaigns\Events;

use App\Libs\Interfaces\Event;
use App\Models\Lead;
use App\Models\LeadSegment;
use App\Models\LeadTag;
use Illuminate\Support\Facades\Log;

class Tag implements Event {

    public $data;
    private $executed = false;
    private $error = false;
    public function execute($data)
    {
        $lead = Lead::find($data['lead_id']);
        // if(!$lead){
        //     $this->executed = true;
        //     return;
        // }
        $eventData = json_decode($data['data']);
        $tagsToAdd = $eventData->add ?? [];
        $tagsToRemove = $eventData->remove ?? [];
        foreach($tagsToAdd as $tag){
            if(LeadTag::where('lead_id', $lead->id)->where('tag_id', $tag)->first() == null){
                LeadTag::forceCreate([
                    'tag_id' => $tag,
                    'lead_id' => $lead->id,
                    'user_id' => $lead->user_id
                ]);
            }
        }

        foreach($tagsToRemove as $tag){
            LeadTag::where('lead_id', $lead->id)->where('tag_id', $tag)->delete();
        }

        $this->executed = true;
    }

    public function hasExecuted()
    {
        return $this->executed;
    }

    public function hasError()
    {
        return $this->error;
    }

}