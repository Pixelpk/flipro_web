<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProjectAccess;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    #NOTE: TO Add filter a method needs to be created with filter prefix
    #Example:
    #If http get request is passed having filters[search] the get method will automatically call filterSearch method if it exists in class instance with dynamically loaded user model class and filter value

    public function get(Request $request)
    {
       
        $users = new User();

        #NOTE: If byId will return single record with given id
        if(isset($request->filters['byId'])){
            return response([
                "message" => 'success',
                #NOTE: if resource id is provided return resource object else return resource array list
                "data" => $users->find($request->filters['byId'])
            ]);
        }
        
        if($request->filters){
            foreach($request->filters as $filter => $value){
                $filter = "filter". ucfirst($filter); #Add filter prefix to the filters received in request to avoid method execution injection
                if(method_exists($this, $filter)){
                    #If filter method exists call filter method with dynamically loaded part taker  and filter value
                    $users = $this->$filter($users, $value);
                }
            }
        }
        
        return response([
            "message" => 'success',
            #NOTE: if resource id is provided return resource object else return resource array list
            "data" => $users->orderBy('id', 'desc')->paginate(config('app.pageSize'))
        ]);
        
    }

    public function filterSearch($resource, $filterValue)
    {
        return $resource->search($filterValue);
    }

    public function filterById($resource, $filterValue)
    {
        return $resource->where('id', $filterValue);
    }

    public function filterType($resource, $filterValue)
    {
        return $resource->where('user_type', $filterValue);
    }

    public function filterassignable($resource, $filterValue)
    {
        $accesses = ProjectAccess::where('project_id', $filterValue)->pluck('user_id')->toArray();
        return $resource->whereNotIn('id', $accesses);
    }
}