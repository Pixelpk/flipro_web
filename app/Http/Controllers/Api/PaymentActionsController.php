<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libs\Firebase\Firebase;
use App\Models\EventLog;
use App\Models\Fcm;
use App\Models\PaymentRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentActionsController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:payment_requests,id',
            'status' => 'required|in:pending,rejected,approved',
        ]);

        $payment = PaymentRequest::find($request->id);
        $payment->status = $request->status;
        $payment->reason = $request->reason;
        $payment->update();
        EventLog::forceCreate([
            'user_id' => $request->user()->id,
            'project_id' => $payment->project_id,
            'description' => $payment->status == 'approved' ? $request->user()->name. " approved the payment request" : $request->user()->name. " rejected the payment request",
            'status' => 4,
        ]);
        $this->notifyStatusUpdate(Project::find($payment->project_id));

        return [
            'message' => 'success',
            'data' => null
        ];

    }

    public function create(Request $request)
    {

        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'amount' => 'required',
            //'description' => 'required'
        ]);

        $payment = PaymentRequest::forceCreate([
            'project_id' => $request->project_id,
            'user_id' => $request->user()->id,
            'amount' => (int)$request->amount,
            'description' => $request->description,
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

        $payment->images = $photos;
        $payment->videos = $videos;
        $payment->update();

        EventLog::forceCreate([
            'user_id' => $request->user()->id,
            'project_id' => $request->project_id,
            'description' => $request->user()->name. " submitted a new payment request of $".number_format((float)$request->amount, 0),
            'status' => 4,
        ]);

        $this->notifyCreation(Project::find($request->project_id));

        return [
            'message' => 'success',
            'data' => null
        ];

    }

    public function notifyCreation($project)
    {

        $partTakers = Fcm::adminFCMs();
        // dd($partTakers);

        $project = collect($project)->except(['assigned', 'evaluators', 'franchisee', 'lead', 'cover_photo', 'action_required', 'project_roles', 'builders', 'progress_satisfied', 'evaluation_satisfied', 'final_progress_reviews', 'evaluation_reviews', 'latest_payment_request', 'latest_note', 'latest_progress', 'latest_value'])->toArray();
        $project['notification_type'] = 'new-payment-request';
        if($partTakers){
            foreach($partTakers as $token){
                $fcm = new Firebase();
                $fcm->setTitle('Payment requested');
                $fcm->setBody('A new payment request is generated '.$project['title']);
                $fcm->setData($project);
                $fcm->setToTokens($token['token']);
                $fcm->send();
            }
        }
    }


    public function notifyStatusUpdate($project)
    {
        // $partTakers = Fcm::adminFCMs();
        $partTakers = Fcm::franFCMs();
        $project = collect($project)->except(['assigned', 'evaluators', 'franchisee', 'lead', 'cover_photo', 'action_required', 'project_roles', 'builders', 'progress_satisfied', 'evaluation_satisfied', 'final_progress_reviews', 'evaluation_reviews', 'latest_payment_request', 'latest_note', 'latest_progress', 'latest_value'])->toArray();
        $project['notification_type'] = 'new-payment-request';
        if($partTakers){
            foreach($partTakers as $token){
                $fcm = new Firebase();
                $fcm->setTitle('Payment request ' . request()->status);
                $fcm->setBody('A payment request is '. request()->status. ' on '. $project['title']);
                $fcm->setData($project);
                $fcm->setToTokens($token['token']);
                $fcm->send();
            }
        }
    }
}