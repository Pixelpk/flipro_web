<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentRequest extends Model
{
    use HasFactory;

    protected $casts = [
        'images' => 'array',
        'videos' => 'array',
    ];

    protected $appends = ['project'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getProjectAttribute()
    {
        return Project::find($this->project_id)->only([
            'id',
            'title',
            'description',
            'cover_photo',
            'project_address'
        ]);
    }
}
