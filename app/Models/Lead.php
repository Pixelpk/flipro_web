<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use HasFactory, SoftDeletes;
   
    protected $fillable = [
        'email',
        'name',
        'phone',
        'phone_code',
        'date',
        'user_id',
    ];
    protected $appends = ['segments', 'tags'];

    public function getSegmentsAttribute()
    {
        return LeadSegment::where('lead_id', $this->id)->join('segments', 'segments.id', 'lead_segments.segment_id')->select('segments.*')->get();
    }

    public function getTagsAttribute()
    {
        return LeadTag::where('lead_id', $this->id)->join('tags', 'tags.id', 'lead_tags.tag_id')->select('tags.*')->get();
    }
}
