<?php
namespace App\Libs\Campaigns\Types;

use App\Libs\Campaigns\EventHandler;
use App\Libs\Interfaces\Campaign;
use App\Models\CampaignEventLog;
use App\Models\LeadTag;
use Illuminate\Support\Facades\Log;

class TagCampaign implements Campaign {

    public function requireList(): bool {
        return false;
    }

    public function requireTag(): bool {
        return true;
    }

    public function getClassName(): string
    {
        return self::class;
    }

    public function getName(): string
    {
        return "Tag";
    }

    public function getDescription(): string
    {
        return "Run when a tag is applied to lead";
    }

    public static function getLeads($campaign)
    {
        return LeadTag::where('tag_id', $campaign->tag_id)->join('leads', 'leads.id', 'lead_tags.lead_id')->select('leads.*')->groupBy('leads.id');
    }

    public static function countCompleted($campaign)
    {
        $lastEvent = $campaign->events->sortByDesc('position')->first();
        if(!$lastEvent) return 0;
        return CampaignEventLog::where('email_campaign_event_id', $lastEvent->id)->count();
    }

    public static function handle($campaign)
    {
        $emailList = self::getLeads($campaign)->get();
        foreach($campaign->events->sortBy('position') as $event){
            foreach($emailList as $lead){
                $executed = CampaignEventLog::where('lead_id', $lead->id)->where('email_campaign_event_id', $event->id)->where('failed', false)->first();
                $previousExecution = CampaignEventLog::where('lead_id', $lead->id)->where('position', \DB::raw($event->position - 1))
                ->where('failed', false)
                ->first();
                if(($event->position == 1 || $previousExecution) && $executed == null){
                    $data = [
                        'email_campaign_id' => $campaign->id,
                        'email_campaign_event_id' => $event->id,
                        'lead_id' => $lead->id,
                        'data' => $event->data,
                        'event_type' => $event->event_type,
                        'position' => $event->position
                    ];
                    
                    $handler = new EventHandler(new ($event->event_type), $data);
                    $handler->attempt();
                }

            }
        }
    }
}