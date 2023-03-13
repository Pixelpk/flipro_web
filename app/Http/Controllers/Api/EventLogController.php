<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EventLog;
use Illuminate\Http\Request;

class EventLogController extends Controller
{
    public function list(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id'
        ]);
        $eventLog = EventLog::where('project_id', $request->project_id)->orderBy('id', 'desc');
        return [
            'message' => 'success',
            'data' => $eventLog->paginate(config('app.pageSize'))
        ];
    }
}
