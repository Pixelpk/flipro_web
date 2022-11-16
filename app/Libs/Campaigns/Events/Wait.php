<?php
namespace App\Libs\Campaigns\Events;

use App\Libs\Interfaces\Event;
use App\Models\CampaignEventLog;
use App\Models\EmailCampaign;
use App\Models\EmailCampaignEvent;
use App\Models\Lead;
use DateTime;

class Wait implements Event {

    public $data;
    public $executed;
    public $error = false;
    public function execute($data)
    {
        $campaign = EmailCampaign::find($data['email_campaign_id']);
        $lead = Lead::find($data['lead_id']);
        $position = $data['position'];
        $previousEvent = CampaignEventLog::where('lead_id', $lead->id)
        ->where('email_campaign_id', $campaign->id)
        ->where('position', \DB::raw($position - 1))
        ->where('failed', false)->first();
        if($previousEvent){
            $previouseEventExecutionTime = strtotime($previousEvent->created_at->format('Y-m-d H:i:s'));
            $currentTime = strtotime(date('Y-m-d H:i:s'));
            $diff = $currentTime - $previouseEventExecutionTime;
            $daysPassed = round($diff / (60 * 60 * 24));

            if($daysPassed >= json_decode($data['data'])->days){
                $this->executed = true;
                return;
            }
        }
        $this->executed = false;
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