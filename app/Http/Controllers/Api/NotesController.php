<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EventLog;
use App\Models\Note;
use Illuminate\Http\Request;

class NotesController extends Controller
{
    public function list(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id'
        ]);

        $notes = Note::with('user:id,name')->where('project_id', $request->project_id)->where(function($q)use($request){
            $q->where('user_id', $request->user()->id)->orWhere('private', 0);
        })->orderByDesc('id');

        $filters = $request->filters ?? [];

        foreach($filters as $filter => $value){
            $method = 'filter'.ucfirst($filter);
            if(method_exists($this, $method)){
                $notes = $this->$method($value, $notes);
            }
        }

        return [
            'message' => 'success',
            'data' => $notes->paginate(config('app.pageSize'))
        ];
    }

    public function filterPrivate($value, $notes)
    {
        return $notes->where('private', $value);
    }

    public function create(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'notes' => 'required',
            'private' => 'boolean'
        ]);

        Note::forceCreate([
            'project_id' => $request->project_id,
            'user_id' => $request->user()->id,
            'private' => $request->private,
            'notes' => $request->notes
        ]);

        EventLog::forceCreate([
            'user_id' => $request->user()->id,
            'project_id' => $request->project_id,
            'description' =>  $request->user()->name. " added a new note",
            'status' => 5,
        ]);

        return [
            'message' => 'success',
            'data' => null
        ];
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:notes,id',
            'notes' => 'required',
            'private' => 'boolean'
        ]);

        $note = Note::find($request->id);
        $note->notes = $request->notes;
        $note->private = $request->private;
        $note->update();

        EventLog::forceCreate([
            'user_id' => $request->user()->id,
            'project_id' => $note->project_id,
            'description' =>  $request->user()->name. " updated a note",
            'status' => 5,
        ]);

        return [
            'message' => 'success',
            'data' => null
        ];
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:notes,id'
        ]);

        $note = Note::find($request->id);

        if(!$note) {
            return response([
                'message' => "Note not found",
                'data' => null
            ], 404);
        }

        if($note->user_id != $request->user()->id){
            return response([
                'message' => 'Access denied',
                'data' => null
            ]);
        }

        EventLog::forceCreate([
            'user_id' => $request->user()->id,
            'project_id' => $note->project_id,
            'description' =>  $request->user()->name. " deleted a note",
            'status' => 5,
        ]);

        $note->delete();

        return [
            'message' => 'success',
            'data' => null
        ];

    }

}
