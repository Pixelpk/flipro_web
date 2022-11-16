<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailCampaign extends Model
{
    use HasFactory;

    protected $appends = ['events'];

    public function getEventsAttribute()
    {
        return EmailCampaignEvent::where('email_campaign_id', $this->id)->get();
    }

    public function emailList(){
        return $this->hasOne(Segment::class, 'segment_id', 'id');
    }

    public function tag(){
        return $this->hasOne(Tag::class);
    }
}
