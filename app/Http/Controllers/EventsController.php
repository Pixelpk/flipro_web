<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventsController extends Controller
{
    public function list(Request $request)
    {
        return [
            'message' => 'success',
            'data' => Event::where('user_id', Auth::user()->id)->get()
        ];
    }
}
