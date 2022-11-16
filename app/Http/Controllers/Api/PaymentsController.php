<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaymentRequest;
use App\Models\ProjectAccess;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    private $isAdmin = false;

    public function list(Request $request)
    {
        $request->validate([
            'filters.byProjectId' => 'exists:projects,id',
        ], [], [
            'filters.byProjectId' => 'project id'
        ]);

        $filters = $request->filters ?? [];

        $this->isAdmin = $request->user()->hasRole('administrator');

        // if(!isset($filters['byProjectId'])&& !$this->isAdmin){
        //     return response([
        //         'message' => 'Access denied',
        //         'data' => null
        //     ], 403);
        // }

        $payment = PaymentRequest::query();

        // return $filters;
        foreach($filters as $filter => $value)
        {
            $method = 'filter' . ucfirst($filter);
            if(method_exists($this, $method)){
                if(!$this->$method($payment, $value)){
                    return response([
                        'message' => 'Access denied',
                        'data' => null
                    ], 403);
                }
                $payment = $this->$method($payment, $value);
            }
        }

        return [
            'message' => 'success',
            'data' => $payment->orderByDesc('id')->paginate(config('app.pageSize'))
        ];

        return [
            'message' => 'success',
            'data' => $payment->with('user')->paginate(config('app.pageSize'))
        ];
    }

    public function filterByProjectId($payment, $value)
    {
        // $canRequestPayment = ProjectAccess::where('project_id', request()->project_id)->where('user_id', request()->user()->id)->whereJsonContains('roles->request_payment', true)->first() == null ? false : true;

        // if(!$this->isAdmin && !$canRequestPayment){
        //     return false;
        // }

        return $payment->where('project_id', $value);
    }

    public function filterStatus($payment, $value)
    {
        return $payment->where('status', $value);
    }
}
