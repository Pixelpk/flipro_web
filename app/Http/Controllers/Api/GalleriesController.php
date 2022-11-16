<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GalleriesController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'file' => 'required',
        ]);

        $file = $request->file('file')->store('media', 'publicf');

        return response([
            'message' => 'success',
            'data' => [
                'url' => url("$file")
            ]
            ]);

    }

}
