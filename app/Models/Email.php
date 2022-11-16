<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

class Email extends Model
{
    use HasFactory, SoftDeletes, SearchableTrait;

    protected $fillable = ['read'];

    protected $appends = ['selected', 'attachment_files'];

    public function getSelectedAttribute()
    {
        return false;
    }

    public function getAttachmentFilesAttribute()
    {
        return json_decode($this->attachments);
    }
}
