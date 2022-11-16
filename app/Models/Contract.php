<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;
  	protected $guarded = [];

    public static function parseSignatory($signatory)
    {
        $clean = str_replace('[sig:', '', str_replace(']', '', $signatory));
        $split = explode(',', $clean);
        return [
            'name' => $split[0],
            'email' => $split[1]
        ];
    }
}
