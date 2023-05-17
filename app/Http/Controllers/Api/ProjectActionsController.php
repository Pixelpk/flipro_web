<?php

namespace App\Http\Controllers\Api;

use App\Events\ProgressAdded;
use App\Http\Controllers\Controller;
use App\Libs\Firebase\Firebase;
use App\Models\EventLog;
use App\Models\Progress;
use App\Models\Project;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PDO;

class ProjectActionsController extends Controller
{
    public function uploadProgress(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required',
            'description' => 'required',
            'final_progress' => 'boolean',
            'videos.*.file' => "mimes:mp4",
            'photos.*' => "image",
        ]);

        $transaction = DB::transaction(function() use($request){
            try {
                // Create media collection
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
                // Create progress entry
                $request->request->add([
                    'user_id' => $request->user()->id,
                ]);
                $progress = Progress::forceCreate($request->only(['user_id', 'project_id', 'title', 'description', 'final_progress']));
                $progress->photos = $photos;
                $progress->videos = $videos;
                $progress->update();
                // Create progress entry
                $project = Project::find($request->project_id);
                $project->status = 'in-progress';
                // if($request->final_progress){
                //     $project->status = 'complete';
                // }
                EventLog::forceCreate([
                    'user_id' => $request->user()->id,
                    'project_id' => $project->id,
                    'description' => $request->final_progress ? $request->user()->name. " submitted  final progress" : $request->user()->name. ' submitted  new progress',
                    'status' => 2,
                ]);
                if($request->final_progress)
                {
                    $project->status = 'complete';
                    EventLog::forceCreate([
                        'user_id' => $request->user()->id,
                        'project_id' => $project->id,
                        'description' => $request->user()->name . " submitted the final progress - Project moved to  completed stage.",
                        'status' => 2,
                    ]);
                }

                $project->update();
                ProgressAdded::dispatch($project);
                DB::commit();

                return response([
                    'message' => 'success',
                    'data' => $progress
                ]);
            }
            catch(Exception $ex){
                DB::rollBack();
                return response([
                    'message' => 'error',
                    'data' => $ex->getMessage()
                ], 500);
            }
        });
        $project = Project::find($request->project_id);
        ProgressAdded::dispatch($project);
        return $transaction;

    }

    public function get(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id'
        ]);

        return [
            'message' => 'success',
            'data' => Progress::with('user')->where('project_id', $request->project_id)->orderByDesc('id')->paginate(config('app.pageSize'))
        ];
    }

    public function notify($project)
    {
        $partTakers = $project->partTakerFcmTokens();
        $project = collect($project)->except(['assigned', 'evaluators', 'franchisee', 'lead', 'cover_photo', 'action_required', 'project_roles', 'builders', 'progress_satisfied', 'evaluation_satisfied', 'final_progress_reviews', 'evaluation_reviews', 'latest_payment_request', 'latest_note', 'latest_progress', 'latest_value'])->toArray();
        $project['notification_type'] = 'progress';
        if($partTakers){
            foreach($partTakers as $token){
                $fcm = new Firebase();
                $fcm->setTitle('Project Update');
                $fcm->setBody('New progress report is added');
                $fcm->setData($project);
                $fcm->setToTokens($token['fcm']);
                $fcm->send();

                if($token['user_type'] == 'home-owner' && $project['status'] == 'complete'){
                    $project['notification_type'] = 'review-required';
                    $fcm->setTitle('Progress review required');
                    $fcm->setBody('Project progress waiting for your review');
                    $fcm->setData($project);
                    $fcm->setToTokens($token['fcm']);
                    $fcm->send();
                }
            }
        }
    }
}