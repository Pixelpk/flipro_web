<?php

namespace App\Http\Controllers;

use App\Models\EmailCampaign;
use App\Models\EmailCampaignEvent;
use Illuminate\Http\Request;

class CampaignEventsController extends Controller
{
    public function handle()
    {
        $campaigns = $this->filterEmpty(EmailCampaign::where('active', 1)->get())->all();
        foreach($campaigns as $campaign){
            $campaign->campaign_type::handle($campaign);
        }

    }

    public function filterEmpty($campaigns)
    {
        return $campaigns = collect($campaigns)->filter(function($item, $key) {
            return count($item->events) != 0;
        });

    }
}
