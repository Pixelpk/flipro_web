<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailCampaignEvent extends Model
{
    use HasFactory;

    protected $appends = [
        'completed_count',
        'failed_count',
    ];

    public function getCompletedCountAttribute()
    {
        return CampaignEventLog::where('email_campaign_event_id', $this->id)->where('failed', false)->count();
    }

    public function getFailedCountAttribute()
    {
        return CampaignEventLog::where('email_campaign_event_id', $this->id)->where('failed', true)->count();
    }
}
