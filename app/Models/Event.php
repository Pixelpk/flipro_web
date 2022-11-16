<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function attachedUser()
    {
        return $this->belongsTo(User::class, 'attached_user_id', 'id');
    }

    public function attachedLead()
    {
        return $this->belongsTo(Lead::class, 'lead_id', 'id');
    }

    public function getEventDateAttribute($value)
    {
        return \Carbon\Carbon::create($value)->format("Y-m-d\TH:i:s");
    }
}
