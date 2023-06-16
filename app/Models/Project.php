<?php

namespace App\Models;

use PDO;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory ,SoftDeletes;

    protected $appends = [
        'assigned',
        'evaluators',
        'franchisee',
        'lead',
        'cover_photo',
        'action_required',
        'project_roles',
        'builders',
        'progress_satisfied',
        'evaluation_satisfied',
        'final_progress_reviews',
        'evaluation_reviews',
        'latest_payment_request',
        'latest_note',
        'latest_progress',
        'latest_value',
        'progress_reviewed',
        'evaluation_reviewed'
    ];

    protected $hidden = [];

    protected $casts = [
        'photos' => 'array',
        'videos' => 'array',
        'anticipated_budget' => 'float',
        'current_property_value' => 'float',
        'property_debt' => 'float',
        'cross_collaterized' => 'integer'
    ];

    protected $fillable = [
        'title',
        'anticipated_budget',
        'project_address',
        'project_state',
        'contractor_supplier_details',
        'applicant_name',
        'email',
        'phone',
        'phone_code',
        'applicant_address',
        'registered_owners',
        'current_property_value',
        'property_debt',
        'cross_collaterized',
        'photos',
        'videos',
        'final_progress',
        'area',
        'description',
    ];

    public function getProgressReviewedAttribute()
    {
        $progress = Progress::where("project_id", $this->id)->orderByDesc('id')->first();
        if(!$progress) return false;
        if($progress->client_satisfied === null) {
            return false;
        }
        return true;
    }

    public function getEvaluationReviewedAttribute()
    {
        $progress = PropertyValue::where("project_id", $this->id)->orderByDesc('id')->first();
        if(!$progress) return false;
        if($progress->client_satisfied === null) {
            return false;
        }
        return true;
    }

    public function getBuildersAttribute()
    {
        if($this->id != null){
            return User::join('project_accesses',function($join){
                $join->on('project_accesses.project_id', \DB::raw($this->id));
                $join->on('project_accesses.user_id', 'users.id');
            })->select('users.*', 'project_accesses.roles')->where('user_type', 'builder')->get();
        }
        return [];
    }

    public function getEvaluatorsAttribute()
    {
        if($this->id != null){
            return User::join('project_accesses',function($join){
                $join->on('project_accesses.project_id', \DB::raw($this->id));
                $join->on('project_accesses.user_id', 'users.id');
            })->select('users.*', 'project_accesses.roles')->where('user_type', 'evaluator')->get();
        }
        return [];
    }

    public function getActionRequiredAttribute()
    {
        if(!request()->user()){
            return [];
        }

        $user = request()->user();
        $scopes = ProjectAccess::where('user_id', $user->id)->where('project_id', $this->id)->first()->roles ?? [];

        $actions = [];
        if($scopes){
            if($this->status == "new" || $this->status == "in-progress"){
                if(isset($scopes['upload_progress'])){
                    $actions[] = 'upload-progress';
                }
            }

            if($this->status == "complete"){
                if($scopes['evaluate'] ?? false){
                    $actions[] = 'evaluate';
                }
            }
            // dd($actions);
            return $actions;
        }
        // if($scopes){
        //     switch($this->status){
        //         case "new" || "in-progress":
        //             if($scopes['upload_progress']){
        //                 return "upload-progress";
        //             }
        //         break;
        //         case "completed":
        //             if($scopes['evaluate'])
        //         break;
        //     }
        // }
        return [];
    }

    public function getCoverPhotoAttribute()
    {
        return isset($this->photos[0]) ? $this->photos[0] : url('/no-image.png');
        return url('/no-image.png');

    }

    public function getVideoGalleryAttribute()
    {
        $videos = [];
        if($this->videos){
            foreach($this->videos as $video){
                $videos[] = url('/stream/' . $video);
            }
        }
        return $videos;
    }

    // public function getFranchiseeAttribute()
    // {
    //     $user = User::find($this->user_id);
    //     if(!$user) return null;
    //     $roles = ProjectAccess::where('user_id', $this->user_id)->where('project_id', $this->id)->first();
    //     $rolesResult = [];

    //     $allRoles = config('roles.projectRoles');
    //     if($roles) {
    //         $roles = $roles->roles;
    //     }
    //     else {
    //         $roles = [];
    //     }

    //     foreach($allRoles as $role){
    //         $rolesResult[$role] = isset($roles[$role]) ? $roles[$role] : false;
    //     }

    //     $user->roles = json_encode($rolesResult);
    //     return $user;
    // }

    public function getFranchiseeAttribute()
    {
        if($this->id != null){
            return User::join('project_accesses',function($join){
                $join->on('project_accesses.project_id', \DB::raw($this->id));
                $join->on('project_accesses.user_id', 'users.id');
            })->select('users.*', 'project_accesses.roles')->where('user_type', 'franchise')->get();
        }
        return [];
    }

    public function getLeadAttribute()
    {
        if($this->id){
            return User::join('project_accesses',function($join){
                $join->on('project_accesses.project_id', \DB::raw($this->id));
                $join->on('project_accesses.user_id', 'users.id');
            })->select('users.*', 'project_accesses.roles')->where('user_type', 'home-owner')->get();
        }

        return [];
        // $user = User::find($this->lead_user_id);
        // if(!$user) return null;
        // $roles = ProjectAccess::where('user_id', $this->lead_user_id)->where('project_id', $this->id)->first();
        // $rolesResult = [];

        // $allRoles = config('roles.projectRoles');
        // if($roles) {
        //     $roles = $roles->roles;
        // }
        // else {
        //     $roles = [];
        // }

        // foreach($allRoles as $role){
        //     $rolesResult[$role] = isset($roles[$role]) ? $roles[$role] : false;
        // }

        // $user->roles = json_encode($rolesResult);
        // return $user;
    }

    public function getProjectRolesAttribute()
    {
        $allRoles = config('roles.projectRoles');
        $roles = ProjectAccess::where('project_id', $this->id)->where('user_id', request()->user()->id ?? 0)->first();
        if($roles) {
            $roles = $roles->roles;
        }
        else {
            $roles = [];
        }
        $results = [];

        foreach($allRoles as $role){
            $result[$role] = isset($roles[$role]) ? $roles[$role] : false;
        }

        return $result;

    }

    public function getAssignedAttribute()
    {
        return ProjectAccess::where('project_id', $this->id)->first() ? true : false;
    }

    public function getProgressSatisfiedAttribute()
    {
        $progress = Progress::where("project_id", $this->id)->orderByDesc('id')->first();
        if(!$progress) return false;
        return (boolean)$progress->client_satisfied;
    }

    public function getEvaluationSatisfiedAttribute()
    {
        $evaluation = PropertyValue::where('project_id', $this->id)->orderByDesc('id')->first();
        if(!$evaluation) return false;
        return (boolean)$evaluation->client_satisfied;
    }

    public function getFinalProgressReviewsAttribute()
    {
        $progress = Progress::where("project_id", $this->id)->orderByDesc('id')->first();
        if(!$progress) return null;
        return $progress->client_reviews;
    }

    public function getEvaluationReviewsAttribute()
    {
        $value = PropertyValue::where("project_id", $this->id)->orderByDesc('id')->first();
        if(!$value) return null;
        return $value->client_reviews;
    }

    public function getLatestPaymentRequestAttribute()
    {
        return PaymentRequest::with('user')->where('project_id', $this->id)->orderByDesc('id')->first();
    }

    public function getLatestProgressAttribute()
    {
        return Progress::with('user')->where('project_id', $this->id)->orderByDesc('id')->first();
    }

    public function getLatestNoteAttribute()
    {
        return Note::with('user')->where('project_id', $this->id)->orderByDesc('id')->first();
    }

    public function getLatestValueAttribute()
    {
        $value = PropertyValue::where('project_id', $this->id)->orderByDesc('id')->first();
        if($value) return $value->value;
        if(!$value) return '0';
    }

    public function evaluations()
    {
        return $this->hasMany(PropertyValue::class)->orderBy('id', 'desc');
    }
    public function paymentRequest()
    {
        return $this->hasMany(PaymentRequest::class);
    }
    public function eventLog()
    {
        return $this->hasMany(EventLog::class)->orderBy('id', 'desc');
    }

    public function partTakerFcmTokens($except = [])
    {
        $admins = User::where('user_type', 'admin')->join('fcms', 'fcms.user_id', 'users.id')->select(['fcms.user_id', 'fcms.token', 'users.user_type'])->whereNotIn('users.id', $except)->get()->toArray() ?? [];
        $parttakers = ProjectAccess::join('fcms', 'fcms.user_id', 'project_accesses.user_id')->join('users', 'users.id', 'project_accesses.user_id')->whereJsonContains('project_accesses.roles->view', true)->whereNotIn('fcms.user_id', $except)->select(['fcms.user_id', 'fcms.token', 'users.user_type'])->whereNotIn('users.id', $except)->get()->toArray() ?? [];

        $result = [];
        $fcm = [];

        foreach($admins as $admin){
            if(!in_array($admin['token'], $fcm)){
                $result[] = [
                    'user_id' => $admin['user_id'],
                    'fcm' => $admin['token'],
                    'user_type' => $admin['user_type'],
                ];
            }
            $fcm[] = $admin['token'];
        }
        foreach($parttakers as $admin){
            if(!in_array($admin['token'], $fcm)){
                $result[] = [
                    'user_id' => $admin['user_id'],
                    'fcm' => $admin['token'],
                    'user_type' => $admin['user_type']
                ];
            }
            $fcm[] = $admin['token'];
        }

        return $result;
    }

    public function notes()
    {
        return $this->hasMany(Note::class)->orderBy('id', 'desc');
    }
}