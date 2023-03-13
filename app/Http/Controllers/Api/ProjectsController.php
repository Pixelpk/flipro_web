<?php

namespace App\Http\Controllers\Api;

use App\Events\ProjectApproved;
use App\Events\ProjectCreated;
use App\Events\ProjectRejected;
use App\Http\Controllers\Controller;
use App\Libs\Firebase\Firebase;
use App\Models\EventLog;
use App\Models\Project;
use App\Models\ProjectAccess;
use App\Models\PropertyValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProjectsController extends Controller
{

    public function search(Request $request)
    {
        $search = $request->search;
        if($search)
        {
            $project = Project::join('project_accesses', 'project_accesses.project_id', 'projects.id')->where('project_accesses.user_id', $request->user()->id)->whereJsonContains('roles->view', true)->select('projects.*');

            if ($request->user()->hasRole('administrator')) {
                $project = Project::query();
            }

            $filters = $request->filters ?? [];
            foreach ($filters as $filter => $value) {
                $method = 'filter' . ucfirst($filter);
                if (method_exists($this, $method)) {
                    $project = $this->$method($project, $value);
                }
            }
            return [
                'message' => 'success',
                'data' => $project->where('title', 'like', $search .'%')->get(),
            ];
        }
    }
    function list(Request $request)
    {

        if (isset($request->filters['byId'])) {
            return [
                'message' => 'success',
                'data' => Project::find($request->filters['byId']),
            ];
        }

        $project = Project::join('project_accesses', 'project_accesses.project_id', 'projects.id')->where('project_accesses.user_id', $request->user()->id)->whereJsonContains('roles->view', true)->select('projects.*');

        if ($request->user()->hasRole('administrator')) {
            $project = Project::query();
        }

        $filters = $request->filters ?? [];

        foreach ($filters as $filter => $value) {
            $method = 'filter' . ucfirst($filter);

            if (method_exists($this, $method)) {
                $project = $this->$method($project, $value);
            }
        }

        return [
            'message' => 'success',
            'data' => $project->orderByDesc('id')->paginate(config('app.pageSize')),
        ];
    }

    public function filterStatus($project, $value)
    {
        return $project->where('status', $value);
    }

    public function filterEvaluated($project, $value)
    {
        $value = $value ? '!=' : '=';
        return $project->whereRaw(DB::raw("(select count(id) from property_values where projects.id = property_values.project_id) $value 0"));
    }

    public function filterEvaluationRejected($project, $value)
    {
        return $project->whereRaw(DB::raw("(select property_values.client_satisfied from property_values where projects.id = property_values.project_id order by property_values.id desc limit 1) = 0"));
    }

    public function filterEvaluationApproved($project, $value)
    {
        return $project->whereRaw(DB::raw("(select property_values.client_satisfied from property_values where projects.id = property_values.project_id order by property_values.id desc limit 1) = 1"));
    }

    public function filterAssigned($project, $value)
    {
        if ($value) {
            return $project->whereRaw(\DB::raw("(select id from project_accesses where project_accesses.project_id = projects.id limit 1) is not null"));
        } else {

            return $project->whereRaw(\DB::raw("(select id from project_accesses where project_accesses.project_id = projects.id limit 1) is null"));
        }
    }

    public function filterApproved($project, $value)
    {
        return $project->where('approved', $value);
    }

    public function create(Request $request)
    {
        // if (!$request->user()->hasRole('create-projects')) {
        //     return response([
        //         'message' => 'unauthorized',
        //         'data' => null,
        //     ], 403);
        // }

        $request->validate([
            'title' => 'required',
            'area' => 'required',
            'description' => 'required',
            'anticipated_budget' => 'required',
            'project_address' => 'required',
            'project_state' => 'required',
            'contractor_supplier_details' => 'required',
            'applicant_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'applicant_address' => 'required',
            'registered_owners' => 'required',
            'current_property_value' => 'required',
            'property_debt' => 'required',
            'cross_collaterized' => 'required',
            // 'photos' => 'required',
            // 'videos' => 'required',
        ]);
        $videos = [];
        if ($request->file('videos')) {
            foreach ($request->videos as $video) {
                $uploadedVideo = Storage::disk('local')->put('project-files', $video['file']);
                $uploadedThumbnail = Storage::disk('local')->put('project-files', $video['thumbnail']);
                $videoUrl = url('/stream/' . $uploadedVideo);
                $thumbnailUrl = url('/stream/' . $uploadedThumbnail);

                $videos[] = [
                    'file' => $videoUrl,
                    'thumbnail' => $thumbnailUrl,
                ];
            }
        }
        $photos = [];
        if ($request->file('photos')) {
            foreach ($request->photos as $photo) {
                $uploadedPhotos = Storage::disk('local')->put('project-files', $photo);
                $photos[] = url('/stream/' . $uploadedPhotos);
            }
        }

        $request->request->add([
            'user_id' => $request->user()->id,
            'anticipated_budget' => (int)$request->anticipated_budget,
            'current_property_value' => (int)$request->current_property_value,
            'property_debt' => (int)$request->property_debt,
        ]);
       
         
        $project = Project::forceCreate($request->only([
            'title',
            'area',
            'description',
            'anticipated_budget',
            'project_address',
            'project_state',
            'contractor_supplier_details',
            'applicant_name',
            'email',
            'phone',
            'applicant_address',
            'registered_owners',
            'current_property_value',
            'property_debt',
            'cross_collaterized',
            'user_id',
        ]));

        $project->videos = $videos;
        $project->photos = $photos;
        $project->update();

        ProjectAccess::forceCreate([
            'user_id' => $request->user()->id,
            'project_id' => $project->id,
            'acting_as' => 'franchise',
            'roles' => [
                'view' => true,
                'upload_progress' => true,
                'add_notes' => true,
                'add_photos' => true,
                'request_payment' => true,
            ]
        ]);

        if(Auth::user()->user_type == 'admin')
        {
            $project->approved = 'approved';
        }else{
            $project->approved = 'pending';
        }
        $project->update();

        EventLog::forceCreate([
            'user_id' => $request->user()->id,
            'project_id' => $project->id,
            'description' => $project->title.' Project created by '. $request->user()->name,
            'status' => 1,
        ]);

        ProjectCreated::dispatch($project);
        return response([
            'message' => 'success',
            'data' => $project,
        ]);

    }

    public function update(Request $request)
    {
        if (!$request->user()->hasRole('update-projects')) {
            return response([
                'message' => 'unauthorized',
                'data' => null,
            ], 403);
        }

        $request->validate([
            'id' => 'required|exists:projects,id',
            'title' => 'required',
            'area' => 'required',
            'description' => 'required',
            'anticipated_budget' => 'required',
            'project_address' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'applicant_address' => 'required',
            'registered_owners' => 'required',
            'current_property_value' => 'required',
            'property_debt' => 'required',
            'cross_collaterized' => 'required',
            // 'photos' => 'required',
            // 'videos' => 'required',
        ]);
        $project = Project::find($request->id);
        $oldPhotos = $project->photos ?? [];
        $oldVideos = $project->videos ?? [];
        $videos = [];
        if ($request->file('videos')) {
            foreach ($request->videos as $key => $video) {
                $uploadedVideo = Storage::disk('local')->put('project-files', $video['file']);
                $uploadedThumbnail = Storage::disk('local')->put('project-files', $video['thumbnail']);
                $videoUrl = url('/stream/' . $uploadedVideo);
                $thumbnailUrl = url('/stream/' . $uploadedThumbnail);

                $oldVideos[] = [
                    'file' => $videoUrl,
                    'thumbnail' => $thumbnailUrl,
                ];
            }
        }
        $photos = [];
        if ($request->file('photos')) {
            foreach ($request->photos as $photo) {
                $uploadedPhotos = Storage::disk('local')->put('project-files', $photo);
                $oldPhotos[] = url('/stream/' . $uploadedPhotos);
            }
        }

        $project->update($request->only([
            'title',
            'area',
            'description',
            'anticipated_budget',
            'project_address',
            'project_state',
            'contractor_supplier_details',
            'applicant_name',
            'email',
            'phone',
            'applicant_address',
            'registered_owners',
            'current_property_value',
            'property_debt',
            'cross_collaterized',
        ]));
        $project->videos = $oldVideos;
        $project->photos = $oldPhotos;
        $project->update();

        EventLog::forceCreate([
            'user_id' => $request->user()->id,
            'project_id' => $project->id,
            'description' => $request->user()->name. ' updated the project',
            'status' => 1,
        ]);

        return response([
            'message' => 'success',
            'data' => $project,
        ]);
    }

    public function approve(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'approved' => 'required|in:approved,rejected,pending',
        ]);

        if ($request->user()->hasRole('administrator')) {
            $project = Project::find($request->project_id);
            $project->approved = $request->approved;
            $project->update();

            if($request->approved == 'approved'){
                event(new ProjectApproved($project));
                EventLog::forceCreate([
                    'user_id' => $request->user()->id,
                    'project_id' => $project->id,
                    'description' => $request->user()->name. ' approved the project',
                    'status' => 1,
                ]);
            }

            if($request->approved == 'rejected'){
                event(new ProjectRejected($project));
                EventLog::forceCreate([
                    'user_id' => $request->user()->id,
                    'project_id' => $project->id,
                    'description' => $request->user()->name. ' rejected the project',
                    'status' => 1,
                ]);
            }


            return [
                'message' => 'success',
                'data' => $project,
            ];
        } else {
            return response([
                'message' => 'Access denied',
                'data' => null,
            ], 403);
        }
    }
}