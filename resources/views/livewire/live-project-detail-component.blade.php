<div class="app-content content">
    <div class="content-overlay"></div>
    <button data-toggle="modal" data-target="#exampleModal" class="btn btn-lg btn-primary rotate" style="
    position: fixed;
    right: -75px;
    top: 80%;
    z-index: 99; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px">
        Progress Timeline</button>
    @if(Auth::user()->user_type == 'admin')
    <button data-toggle="modal" data-target="#exampleModal90" class="btn btn-lg btn-primary rotate" style="
    position: fixed;
    right: -75px;
    top: 45%;
    z-index: 99; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px">
        Activity Timeline</button>
    @endif
    @if(Auth::user()->user_type == 'franchise' && $finalProgress && ($project->status == 'complete'))
    <button data-toggle="modal" data-target="#exampleModal11" class="btn btn-lg btn-primary rotate" style="
    position: fixed;
    right: -37px;
    top: 55%;
    z-index: 99; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px">
        Add Progress Review</button>
    @endif

    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2 mt-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h5 class="content-header-title float-left pr-1 mb-0">Home</h5>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item"><a href="/"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Project Details</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class="col-md-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{$project->project_address}}</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    @php
                                                    $photo = $project->photos[0] ?? '/no-image.png';
                                                    if($photo)
                                                    if(filter_var($photo, FILTER_VALIDATE_URL)){
                                                    $photo = explode("/", $photo);
                                                    $photo = $photo[count($photo) -2] . '/' . $photo[count($photo)-1];
                                                    }
                                                    @endphp
                                                    <img src="/stream/{{$photo}}" width="440px;" alt="Image">
                                                </div>
                                                <div class="col-md-12 text-center mt-2">
                                                    <a href="#gallery"><button class="btn btn-primary">View
                                                            All</button></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <h4 class="display-4 mb-1" style="font-size:2.5rem;">Applicant Information
                                            </h4>
                                            <ul>
                                                @if(Auth::user()->user_type == 'admin')
                                                @if($project->approved == 'pending')
                                                <li class="mb-1">
                                                    <button wire:loading.attr="disabled" class="btn btn-success"
                                                        wire:click="confirmProjectStatus('approved')">Approve

                                                        <span wire:loading
                                                            wire:target="confirmProjectStatus('approved')"
                                                            class="spinner-border spinner-border-sm" role="status"
                                                            aria-hidden="true"></span>
                                                    </button>
                                                    <button wire:loading.attr="disabled" class="btn btn-danger"
                                                        wire:click="confirmProjectStatus('rejected')">
                                                        <span wire:loading
                                                            wire:target="confirmProjectStatus('rejected')"
                                                            class="spinner-border spinner-border-sm" role="status"
                                                            aria-hidden="true"></span>
                                                        Reject</button>
                                                </li>
                                                @elseif($project->approved == 'rejected')
                                                <button wire:loading.attr="disabled" class="btn btn-success"
                                                    wire:click="confirmProjectStatus('approved')">Approve

                                                    <span wire:loading wire:target="confirmProjectStatus('approved')"
                                                        class="spinner-border spinner-border-sm" role="status"
                                                        aria-hidden="true"></span>
                                                </button>

                                                @endif
                                                @endif

                                                <li class="mb-1">
                                                    <b>Created date:</b>
                                                    {{ date('d-m-Y', strtotime($project->created_at)) }}
                                                </li>
                                                @if($project->approved == 'rejected')
                                                <li class="mb-1">
                                                    <b>Project Status:</b> Rejected
                                                </li>
                                                @endif
                                                @if($project->approved == 'approved')
                                                <li class="mb-1">
                                                    <b>Project Status:</b> {{$project->status}}
                                                </li>
                                                @endif
                                                <li class="mb-1">
                                                    <b>Applicant Name:</b> {{$project->applicant_name}}
                                                </li>
                                                <li class="mb-1">
                                                    <b>Applicant Email:</b> {{$project->email}}
                                                </li>
                                                <li class="mb-1">
                                                    <b>Applicant Phone:</b> {{$project->phone}}
                                                </li>
                                                <li class="mb-1">
                                                    <b>Register Owner:</b> {{$project->registered_owners}}
                                                </li>
                                                {{--  <li class="mb-1">
                                                    <b>Property State:</b> {{$project->project_state}}
                                                </li>
                                                <li class="mb-1">
                                                    <b>Property Address:</b> {{$project->title  }}
                                                </li>
                                                <li class="mb-1">
                                                    <b>Cross Collaterized:</b> {{$project->cross_collaterized ? 'Yes' :
                                                    'No'}}
                                                </li> --}}
                                            </ul>
                                            <h4 class="display-4 mb-1" style="font-size:2.5rem;">Financials</h4>
                                            <ul>
                                                <li class="mb-1">
                                                    <b>Current Value:</b>
                                                    ${{number_format((float)$project->current_property_value)}}
                                                </li>
                                                <li class="mb-1">
                                                    <b>Property Debts:</b>
                                                    ${{ number_format((float)$project->property_debt)}}
                                                </li>

                                                <li class="mb-1">
                                                    <b>Cross Collaterized:</b>
                                                    @if($project->cross_collaterized == 1)
                                                    Yes
                                                    @else
                                                    No
                                                    @endif
                                                </li>
                                                {{--  <li class="mb-1">
                                                    <b>Anticipated Budget:</b>
                                                    ${{number_format($project->anticipated_budget)}}
                                                </li> --}}
                                            </ul>
                                            <h4 class="display-4 mb-1" style="font-size:2.5rem;">Project Information
                                            </h4>
                                            <ul>
                                                <li class="mb-1">
                                                    <b>Project Address:</b>
                                                    {{ $project->title }}
                                                </li>

                                                <li class="mb-1">
                                                    <b>Area (Square Meters):</b>

                                                    {{ number_format((float)$project->area)}}
                                                </li>
                                                <li class="mb-1">
                                                    <b>Anticipated Budget:</b>

                                                    ${{ number_format((float)$project->anticipated_budget)}}
                                                </li>
                                                {{-- <li class="mb-1">
                                                    <b>Project Title:</b>
                                                    {{ $project->project_address }}
                                                </li> --}}

                                                <li class="mb-1">
                                                    <b>Applicant Address:</b>
                                                    {{ $project->applicant_address }}
                                                </li>


                                                <li class="mb-1">
                                                    <b>Suburb, State and postal code:</b>
                                                    {{ $project->project_state }}
                                                </li>


                                                <li class="mb-1">
                                                    <b>Existing Queries:</b>
                                                    @if($project->contractor_supplier_details == 1)
                                                    Yes
                                                    @else
                                                    No
                                                    @endif
                                                </li>

                                                <li class="mb-1">
                                                    <b>Description:</b>
                                                    {{ $project->description }}
                                                </li>
                                                {{--  <li class="mb-1">
                                                    <b>Anticipated Budget:</b>
                                                    ${{number_format($project->anticipated_budget)}}
                                                </li> --}}
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Team</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                <li class="nav-item">
                                                    <a wire:ignore.self class="nav-link active" id="home-tab"
                                                        data-toggle="tab" href="#home-owner" role="tab"
                                                        aria-controls="home" aria-selected="true">Home Owner</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a wire:ignore.self class="nav-link" id="profile-tab"
                                                        data-toggle="tab" href="#builder" role="tab"
                                                        aria-controls="profile" aria-selected="false">Builders</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a wire:ignore.self class="nav-link" id="contact-tab"
                                                        data-toggle="tab" href="#franchise" role="tab"
                                                        aria-controls="contact" aria-selected="false">Partners</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a wire:ignore.self class="nav-link" id="contact1-tab"
                                                        data-toggle="tab" href="#evaluator" role="tab"
                                                        aria-controls="contact1" aria-selected="false">Evaluator</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content" id="myTabContent">
                                                <div wire:ignore.self class="tab-pane fade show active" id="home-owner"
                                                    role="tabpanel" aria-labelledby="home-tab">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label for="">Select User</label>
                                                            <select wire:loading.attr="disabled"
                                                                wire:model='selectedUser' class="form-control">
                                                                <option value="">
                                                                    Select
                                                                </option>
                                                                @foreach ($user->homeOwners()->get() as $item)
                                                                <option value="{{$item->id}}">
                                                                    {{$item->name}}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                            </select>
                                                            @error('selectedUser')
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="">Roles</label><br>
                                                            @foreach ($roles as $key => $item)
                                                            @if (in_array($item, $homeOwnerRoles))
                                                            {{--  <input wire:model="userRoles" type="checkbox"
                                                                value="{{$item}}"> {{ucfirst(str_replace('_', ' ',
                                                            $item))}} --}}
                                                            <div class="form-check">
                                                                <input wire:loading.attr="disabled"
                                                                    wire:model="userRoles" class="form-check-input"
                                                                    type="checkbox" value="{{$item}}" id="{{ $key }}">
                                                                <label class="form-check-label" for="{{ $key }}">
                                                                    {{ucfirst(str_replace('_', ' ',
                                                            $item))}}
                                                                </label>
                                                            </div>
                                                            @endif
                                                            @endforeach
                                                        </div>
                                                        <div class="col-md-6">
                                                            @if($project->approved == 'approved')
                                                            <button wire:loading.attr="disabled" class="btn btn-primary"
                                                                wire:click='addUser("home-owner")'>Add
                                                                <span wire:loading wire:target="addUser"
                                                                    class="spinner-border spinner-border-sm"
                                                                    role="status" aria-hidden="true"></span>
                                                            </button>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-12">
                                                            <table class="table mt-1">
                                                                <tr>
                                                                    <th>
                                                                        Name
                                                                    </th>
                                                                    <th>
                                                                        Email
                                                                    </th>
                                                                      <th>
                                                                        Phone
                                                                    </th>
                                                                    <th>
                                                                        Roles
                                                                    </th>
                                                                    <th></th>
                                                                </tr>
                                                                @foreach ($this->homeOwners as $homeOwner)
                                                                <tr>
                                                                    <td>
                                                                        {{$homeOwner->user->name}}
                                                                    </td>
                                                                    <td>
                                                                        {{$homeOwner->user->email}}
                                                                    </td>
                                                                     <td>
                                                                        {{$homeOwner->user->phone}}
                                                                    </td>
                                                                    <td>
                                                                        <ul>
                                                                            @foreach ($homeOwner->roles as $key =>
                                                                            $role)
                                                                            @if (in_array($key, $homeOwnerRoles))
                                                                            <li><b>{{$key}}: </b> {!!$role ? '<i
                                                                                    class="bx bx-check-circle text-success"></i>'
                                                                                : '<i
                                                                                    class="bx bx-x-circle text-danger"></i>'!!}
                                                                            </li>

                                                                            @endif
                                                                            @endforeach
                                                                        </ul>
                                                                    </td>
                                                                    <td>
                                                                        {{--  <button class="btn btn-danger" wire:click='deleteUser({{$homeOwner}})'>Delete</button>
                                                                        --}}
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div wire:ignore.self class="tab-pane fade" id="builder" role="tabpanel"
                                                    aria-labelledby="profile-tab">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label for="">Select User</label>
                                                            <select wire:loading.attr="disabled"
                                                                wire:model='selectedUser' class="form-control">
                                                                <option value="">
                                                                    Select
                                                                </option>
                                                                @foreach ($user->builders()->get() as $item)
                                                                <option value="{{$item->id}}">
                                                                    {{$item->name}}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                            </select>
                                                            @error('selectedUser')
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="">Roles</label><br>
                                                            @foreach ($roles as $item)
                                                            @if (in_array($item, $builderRoles))
                                                            <input wire:loading.attr="disabled" wire:model="userRoles"
                                                                type="checkbox" value="{{$item}}"> {{ucfirst(str_replace('_', ' ',
                                                            $item))}}
                                                            @endif
                                                            @endforeach
                                                        </div>
                                                        <div class="col-md-6">
                                                            @if($project->approved == 'approved')
                                                            <button wire:loading.attr="disabled" class="btn btn-primary"
                                                                wire:click='addUser("builder")'>Add
                                                                <span wire:loading wire:target="addUser"
                                                                    class="spinner-border spinner-border-sm"
                                                                    role="status" aria-hidden="true"></span>
                                                            </button>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-12">
                                                            <table class="table mt-1">
                                                                <tr>
                                                                    <th>
                                                                        Name
                                                                    </th>
                                                                    <th>
                                                                        Email
                                                                    </th>
                                                                     <th>
                                                                        Phone
                                                                    </th>

                                                                    <th>
                                                                        Roles
                                                                    </th>
                                                                    <th></th>
                                                                </tr>
                                                                @foreach ($this->builders as $builder)
                                                                <tr>
                                                                    <td>
                                                                        {{$builder->user->name}}
                                                                    </td>
                                                                    <td>
                                                                        {{$builder->user->email}}
                                                                    </td>
                                                                    <td>
                                                                        {{$builder->user->phone}}
                                                                    </td>
                                                                    <td>
                                                                        <ul>
                                                                            <ul>
                                                                                @foreach ($builder->roles as $key =>
                                                                                $role)
                                                                                @if (in_array($key, $builderRoles))
                                                                                <li><b>{{$key}}: </b> {!!$role ? '<i
                                                                                        class="bx bx-check-circle text-success"></i>'
                                                                                    : '<i
                                                                                        class="bx bx-x-circle text-danger"></i>'!!}
                                                                                </li>

                                                                                @endif
                                                                                @endforeach
                                                                            </ul>
                                                                        </ul>
                                                                    </td>
                                                                    <td>
                                                                        {{--  <button class="btn btn-danger"
                                                                            wire:click="deleteUser({{$builder}})">Delete</button>
                                                                        --}}
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div wire:ignore.self class="tab-pane fade" id="franchise"
                                                    role="tabpanel" aria-labelledby="contact-tab">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label for="">Select User</label>
                                                            <select wire:loading.attr="disabled"
                                                                wire:model='selectedUser' class="form-control">
                                                                <option value="">
                                                                    Select
                                                                </option>
                                                                @foreach ($user->franchises()->get() as $item)
                                                                <option value="{{$item->id}}">
                                                                    {{$item->name}}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                            </select>
                                                            @error('selectedUser')
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="">Roles</label><br>
                                                            @foreach ($roles as $key => $item)
                                                            @if (in_array($item, $franchiseRoles))
                                                            {{--  <input wire:model="userRoles" type="checkbox"
                                                                value="{{$item}}"> {{ucfirst(str_replace('_', ' ',
                                                            $item))}} --}}
                                                            <div class="form-check">
                                                                <input wire:loading.attr="disabled"
                                                                    wire:model="userRoles" class="form-check-input"
                                                                    type="checkbox" value="{{$item}}" id="{{ $key }}">
                                                                <label class="form-check-label" for="{{ $key }}">
                                                                    {{ucfirst(str_replace('_', ' ',
                                                                    $item))}}
                                                                </label>
                                                            </div>
                                                            @endif
                                                            @endforeach
                                                        </div>
                                                        <div class="col-md-6">
                                                            @if($project->approved == 'approved')
                                                            <button wire:loading.attr="disabled" class="btn btn-primary"
                                                                wire:click='addUser("franchise")'>
                                                                Add
                                                                <span wire:loading wire:target="addUser"
                                                                    class="spinner-border spinner-border-sm"
                                                                    role="status" aria-hidden="true"></span>
                                                            </button>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-12">
                                                            <table class="table mt-1">
                                                                <tr>
                                                                    <th>
                                                                        Name
                                                                    </th>
                                                                    <th>
                                                                        Email
                                                                    </th>
                                                                    <th>
                                                                        Phone
                                                                    </th>
                                                                    <th>
                                                                        Roles
                                                                    </th>
                                                                    <th></th>
                                                                </tr>
                                                                @foreach ($this->franchises as $franchise)
                                                                <tr>
                                                                    <td>
                                                                        {{$franchise->user->name}}
                                                                    </td>
                                                                    <td>
                                                                        {{$franchise->user->email}}
                                                                    </td>
                                                                     <td>
                                                                        {{$franchise->user->phone}}
                                                                    </td>
                                                                    <td>
                                                                        <ul>
                                                                            <ul>
                                                                                @foreach ($franchise->roles as $key =>
                                                                                $role)
                                                                                @if (in_array($key, $franchiseRoles))
                                                                                <li><b>{{$key}}: </b> {!!$role ? '<i
                                                                                        class="bx bx-check-circle text-success"></i>'
                                                                                    : '<i
                                                                                        class="bx bx-x-circle text-danger"></i>'!!}
                                                                                </li>
                                                                                @endif
                                                                                @endforeach
                                                                            </ul>
                                                                        </ul>
                                                                    </td>
                                                                    <td>
                                                                        {{--  <button class="btn btn-danger"
                                                                            wire:click='deleteUser({{$franchise}})'>Delete</button>
                                                                        --}}
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div wire:ignore.self class="tab-pane fade" id="evaluator"
                                                    role="tabpanel" aria-labelledby="contact-tab">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label for="">Select User</label>
                                                            <select wire:loading.attr="disabled"
                                                                wire:model='selectedUser' class="form-control">
                                                                <option value="">
                                                                    Select
                                                                </option>
                                                                @foreach ($user->evaluators()->get() as $item)
                                                                <option value="{{$item->id}}">
                                                                    {{$item->name}}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                            @error('selectedUser')
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="">Roles</label><br>
                                                            @foreach ($roles as $item)
                                                            @if (in_array($item, $valuerRoles))
                                                            <input wire:loading.attr="disabled" wire:model="userRoles"
                                                                type="checkbox" value="{{$item}}"> {{ucfirst(str_replace('_', ' ',
                                                            $item))}}
                                                            @endif
                                                            @endforeach
                                                        </div>
                                                        <div class="col-md-6">
                                                            @if($project->approved == 'approved')
                                                            <button wire:loading.attr="disabled" class="btn btn-primary"
                                                                wire:click='addUser("evaluator")'>Add
                                                                <span wire:loading wire:target="addUser"
                                                                    class="spinner-border spinner-border-sm"
                                                                    role="status" aria-hidden="true"></span>
                                                            </button>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-12">
                                                            <table class="table mt-1">
                                                                <tr>
                                                                    <th>
                                                                        Name
                                                                    </th>
                                                                    <th>
                                                                        Email
                                                                    </th>
                                                                      <th>
                                                                        Phone
                                                                    </th>
                                                                    <th>
                                                                        Roles
                                                                    </th>
                                                                    <th>

                                                                    </th>
                                                                </tr>
                                                                @foreach ($this->evaluators as $evaluator)
                                                                <tr>
                                                                    <td>
                                                                        {{$evaluator->user->name}}
                                                                    </td>
                                                                    <td>
                                                                        {{$evaluator->user->email}}
                                                                    </td>
                                                                      <td>
                                                                        {{$evaluator->user->phone}}
                                                                    </td>
                                                                    <td>
                                                                        <ul>
                                                                            <ul>
                                                                                @foreach ($evaluator->roles as $key =>
                                                                                $role)
                                                                                @if (in_array($key, $valuerRoles))
                                                                                <li><b>{{$key}}: </b> {!!$role ? '<i
                                                                                        class="bx bx-check-circle text-success"></i>'
                                                                                    : '<i
                                                                                        class="bx bx-x-circle text-danger"></i>'!!}
                                                                                </li>
                                                                                @endif
                                                                                @endforeach
                                                                            </ul>
                                                                        </ul>
                                                                    </td>
                                                                    <td>
                                                                        {{--  <button class="btn btn-danger"
                                                                            wire:click='deleteUser({{$evaluator}})'>Delete</button>
                                                                        --}}
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Tasks</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 table-responsive">
                                            @if($project->approved == 'approved')
                                            <button class="btn-primary btn" wire:click='openTaskModal'>Create
                                                Task</button>
                                            @endif
                                            <table class="table">
                                                <tr>
                                                    <td>Task</td>
                                                    <td>Description</td>
                                                    <td>Scheduled Date</td>
                                                    <td>Project</td>
                                                    <td>Created By</td>
                                                    <td>Action Taken</td>
                                                    <td>Status</td>
                                                    <td></td>
                                                </tr>
                                                @foreach ($tasks as $task)
                                                <tr>
                                                    <td>{{$task->title}}</td>
                                                    <td>{{$task->description}}</td>
                                                    <td>{{\Carbon\Carbon::create($task->event_date)->format('d-m-Y h:i
                                                        a')}}</td>
                                                    <td>{{$project->title}}</td>
                                                    <td>{{$task->createdBy->name ?? ""}}</td>
                                                    <td>
                                                        {{$task->action_taken}}
                                                    </td>
                                                    <td>
                                                        {{$task->status}}
                                                    </td>
                                                    <td><i class="bx bx-pencil" wire:click='selectTask({{$task}})'
                                                            data-toggle="modal" data-target="#taskModal"></i></td>
                                                </tr>
                                                @endforeach
                                            </table>
                                            <div class="modal fade" wire:ignore.self id="taskModal" tabindex="-1"
                                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Create Task
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-3 mt-1"><b>Title:</b></div>
                                                                <div class="col-9 mt-1">
                                                                    <input type="text" class="form-control"
                                                                        wire:model='selectedTask.title'>
                                                                    @error('selectedTask.title')
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-3 mt-1"><b>Description:</b></div>
                                                                <div class="col-9 mt-1">
                                                                    <textarea wire:model='selectedTask.description'
                                                                        class="form-control"></textarea>
                                                                </div>
                                                                @if ($selectedTask->project_id ?? false)
                                                                <div class="col-3 mt-1"><b>Project:</b></div>
                                                                <div class="col-3 mt-1">{{$project->title}}</div>
                                                                <div class="col-3 mt-1"><b>Created By:</b></div>
                                                                <div class="col-3 mt-1">
                                                                    {{$selectedTask->createdBy->name}}
                                                                </div>
                                                                @endif
                                                                <div class="col-3 mt-1"><b>Scheduled Date:</b></div>
                                                                <div class="col-3 mt-1">
                                                                    <input wire:model='selectedTask.event_date'
                                                                        type="datetime-local" class="form-control">
                                                                    @error('selectedTask.event_date')
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-3 mt-1"><b>Status:</b></div>
                                                                <div class="col-3 mt-1">
                                                                    <select class="form-control"
                                                                        wire:model='selectedTask.status'>
                                                                        <option value="">--Select Status--</option>
                                                                        <option value="new">new</option>
                                                                        <option value="in-progress">In Progress</option>
                                                                        <option value="completed">Completed</option>
                                                                    </select>
                                                                    @error('selectedTask.status')
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-3 mt-1"><b>User:</b></div>
                                                                <div class="col-3 mt-1">
                                                                    <select class="form-control"
                                                                        wire:model='selectedTask.attached_user_id'>
                                                                        <option value="">--Select User--</option>
                                                                        @foreach ($users as $user)
                                                                        <option value="{{$user->id}}">{{$user->name}}
                                                                            ({{$user->email}})/option>
                                                                            @endforeach
                                                                    </select>

                                                                    @error('selectedTask.attached_user_id')
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-3 mt-1"><b>Lead:</b></div>
                                                                <div class="col-3 mt-1">
                                                                    <select class="form-control"
                                                                        wire:model='selectedTask.lead_id'>
                                                                        <option value="">--Select Lead--</option>
                                                                        @foreach ($leads as $lead)
                                                                        <option value="{{$lead->id}}">{{$lead->name}}
                                                                            ({{$lead->email}})/option>
                                                                            @endforeach
                                                                    </select>
                                                                    @error('selectedTask.lead_id')
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-3 mt-1"><b>Action Taken:</b></div>
                                                                <div class="col-9 mt-1">
                                                                    <textarea class="form-control"
                                                                        wire:model='selectedTask.action_taken'></textarea>
                                                                    @error('selectedTask.action_taken')
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button wire:loading.attr="disabled"  type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="button" wire:click='saveTask'
                                                                class="btn btn-primary">Save
                                                                changes
                                                                
                                                                 <span wire:loading wire:target="saveTask"
                                                        class="spinner-grow spinner-grow-sm" role="status"
                                                        aria-hidden="true"></span>
                                                                </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" wire:ignore.self id="addValueModal" tabindex="-1"
                                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Add Value
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-3 mt-1"><b>Add Value:</b></div>
                                                                <div class="col-9 mt-1">
                                                                    <input onkeyup="format(this)" id="valueadd" type="text" class="form-control"
                                                                      >
                                                                    @error('propertyValue')
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>


                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button  type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button wire:loading.attr="disabled"  type="button" wire:click='saveValue'
                                                                class="btn btn-primary">Save
                                                                changes
                                                                
                                                                 <span wire:loading wire:target="saveValue"
                                                        class="spinner-grow spinner-grow-sm" role="status"
                                                        aria-hidden="true"></span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" wire:ignore.self id="paymentRequestModal"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Reason
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-3 mt-1"><b>Reason:</b></div>
                                                                <div class="col-9 mt-1">
                                                                    <input type="text" class="form-control"
                                                                        wire:model='paymentRequestReason'>
                                                                    @error('paymentRequestReason')
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>


                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="button"
                                                                wire:click='savePaymentRequestAction()'
                                                                class="btn btn-primary">Save
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Price Evaluations</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            @if(Auth::user()->hasRole('administrator'))
                                            @if($project->approved == 'approved')
                                            <button class="btn-primary btn" wire:click="openAddValueModal">Add
                                                Value</button>
                                            @endif
                                            @if($project->status == "complete" && $project->evaluations->count() > 0 &&
                                            $client_satisfied)
                                            @if($project->approved == 'approved')
                                            <button class="btn-danger btn"
                                                wire:click="statusConfirmation('projectClose')">Project
                                                Close</button>
                                            @endif
                                            @endif
                                            @endif
                                            @if(!Auth::user()->hasRole('administrator') && $projectAccess &&
                                            isset($projectAccess->roles['add_value']) &&
                                            $projectAccess->roles['add_value'])
                                            @if($project->approved == 'approved')
                                            <button class="btn-primary btn" wire:click="openAddValueModal">Add
                                                Value</button>
                                            @endif
                                            @endif
                                            <table class="table">
                                                <tr>
                                                    <td>Value</td>
                                                    <td>Satisfaction</td>
                                                    <td>Review</td>
                                                </tr>
                                                @foreach ($project->evaluations as $value)
                                                <tr>
                                                    <td>${{ number_format((float)$value->value)}}</td>
                                                    <td>
                                                        @if ($value->client_satisfied !== null)
                                                        {{$value->client_satisfied == true ? "Yes" : "No"}}
                                                        @else
                                                        Not Provided
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($value->client_reviews !== null)
                                                        {{$value->client_reviews}}
                                                        @else
                                                        Not Provided
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($finalProgressReviews->count() > 0)
                    <div class="col-md-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Final Progress Review</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">

                                            <table class="table">
                                                <tr>
                                                    <td>User</td>
                                                    <td>Client Satisfied</td>
                                                    <td>Client Reviews</td>


                                                </tr>
                                                @foreach ($finalProgressReviews as $item)
                                                <tr>
                                                    <td>{{$item->user->name}}</td>
                                                    <td>
                                                        @if($item->client_satisfied == 1)
                                                        Yes
                                                        @else
                                                        No
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $item->client_reviews ?? '' }}
                                                    </td>


                                                </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($project->paymentRequest->count() > 0)
                    <div class="col-md-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Payment Request</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">

                                            <table class="table">
                                                <tr>
                                                    <td>User</td>
                                                    <td>Amount</td>
                                                    <td>Description</td>
                                                    <td>Status</td>
                                                    <td>Reason</td>
                                                    <td>Media</td>
                                                    @if(Auth::user()->hasRole('administrator'))
                                                    <td>Action</td>
                                                    @endif
                                                </tr>
                                                @foreach ($project->paymentRequest as $item)
                                                <tr>
                                                    <td>{{$item->user->name}}</td>
                                                    <td> ${{number_format($item->amount)}}</td>
                                                    <td>{{$item->description}}</td>
                                                    <td>
                                                        {{ ucfirst($item->status) }}
                                                    </td>
                                                    <td>{{$item->reason ?? ''}}</td>
                                                    <td>

                                                        <button data-toggle="modal"
                                                            data-target="#exampleModal91{{ $item->id }}"
                                                            class="btn btn-primary">View</button>
                                                        <div wire:ignore.self class="modal fade"
                                                            id="exampleModal91{{ $item->id }}" tabindex="-1"
                                                            role="dialog" aria-labelledby="exampleModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-xl" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                                            Media</h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <h3 class="display-4">Photos</h3>
                                                                            </div>
                                                                            @foreach ((array)$item->images as $image)
                                                                            @php
                                                                            $photo = $image;
                                                                            if($photo)
                                                                            if(filter_var($photo, FILTER_VALIDATE_URL)){
                                                                            $photo = explode("/", $photo);
                                                                            $photo = $photo[count($photo) -2] . '/' .
                                                                            $photo[count($photo)-1];
                                                                            }
                                                                            @endphp

                                                                            <div class="col-md-2">
                                                                                <a target="_blank"
                                                                                    href="/stream/{{$photo}}">
                                                                                    <img src="/stream/{{$photo}}"
                                                                                        width="100%" alt="logo">
                                                                                </a>
                                                                            </div>
                                                                            @endforeach
                                                                            <div class="col-md-12">
                                                                                <h3 class="display-4">Videos</h3>
                                                                            </div>
                                                                            @if ((array)$item->videos)
                                                                            @foreach ((array)$item->videos as $video)
                                                                            <div class="col-md-4">
                                                                                <video src="{{$video['file']}}"
                                                                                    width="100%" controls="true"
                                                                                    autoplay="false">
                                                                                    <source src="{{$video['file']}}">
                                                                                </video>
                                                                            </div>
                                                                            @endforeach

                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    @if(Auth::user()->hasRole('administrator'))
                                                    <td>

                                                        @if($project->status != 'complete' || $project->status !=
                                                        'closed')
                                                        @if($item->status == 'pending')
                                                        <button class="btn-success btn"
                                                            wire:click='openPaymentRequestModel({{ $item->id }}, "approved")'>Approve</button>
                                                        <button class="btn-danger btn"
                                                            wire:click='openPaymentRequestModel({{ $item->id }}, "rejected")'>Reject</button>
                                                        @endif
                                                        @if($item->status == 'rejected')
                                                        <button class="btn-success btn"
                                                            wire:click='openPaymentRequestModel({{ $item->id }}, "approved")'>Approve</button>
                                                        @endif
                                                        @endif
                                                    </td>
                                                    @endif

                                                </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($project->eventLog->count() > 0)
                    <div class="col-md-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Activity Timeline</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">

                                            <table class="table">
                                                <tr>
                                                    <td>User</td>
                                                    <td>Description</td>
                                                </tr>
                                                @foreach ($project->eventLog as $item)
                                                <tr>
                                                    <td>{{$item->user->name}}</td>
                                                    <td>{{$item->description}}</td>
                                                </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="col-md-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Notes</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <table class="table">
                                                <tr>
                                                    <td>User</td>
                                                    <td>Note</td>
                                                    <td>Date</td>
                                                </tr>
                                                @foreach ($project->notes as $value)
                                                <tr>
                                                    <td>{{$value->user->name}}</td>
                                                    <td>
                                                        {{$value->notes}}
                                                    </td>
                                                    <td>
                                                        {{\Carbon\Carbon::create($value->created_at)->format('d-m-Y h:i
                                                        a')}}
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Contracts</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @if($project->approved == 'approved')
                                            <a href="/contracts/create/{{$project->id}}"><button
                                                    class="btn btn-primary">Create New Contract</button></a>
                                            @endif
                                        </div>
                                        <div class="col-md-12">
                                            @livewire('tables.project-contract-table', ['params' => [
                                            'project_id' => $project->id
                                            ]])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="card" id="gallery">
                            <div class="card-header">
                                <h4 class="card-title">Project Gallery</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3 class="display-4">Photos</h3>
                                        </div>
                                        @foreach ((array)$project->photos as $item)
                                        @php
                                        $photo = $item;
                                        if($photo)
                                        if(filter_var($photo, FILTER_VALIDATE_URL)){
                                        $photo = explode("/", $photo);
                                        $photo = $photo[count($photo) -2] . '/' . $photo[count($photo)-1];
                                        }
                                        @endphp

                                        <div class="col-md-2">
                                            <a target="_blank" href="/stream/{{$photo}}">
                                                <img src="/stream/{{$photo}}" width="100%" alt="">
                                            </a>
                                        </div>
                                        @endforeach
                                        <div class="col-md-12">
                                            <h3 class="display-4">Videos</h3>
                                        </div>
                                        @if ((array)$project->videos)
                                        @foreach ((array)$project->videos as $item)
                                        <div class="col-md-4">
                                            <video src="{{$item['file']}}" width="100%" controls="true"
                                                autoplay="false">
                                                <source src="{{$item['file']}}">
                                            </video>
                                        </div>
                                        @endforeach

                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Progress Timeline</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="timeline">
                        @foreach ($timeLine as $item)
                        <li>
                            <a target="#">{{$item->title}}</a>
                            <a href="#" class="float-right">{{\Carbon\Carbon::create($item->created_at)->format('d-m-Y
                                H:i:s')}}</a>
                            <p>{{$item->description}}</p>
                            <div class="row">
                                @if(isset($item->photos))
                                @foreach ($item->photos as $photo)
                                <div class="col-2">
                                    <a target="_blank" href="{{$photo}}">
                                        <img src="{{$photo}}">
                                    </a>
                                </div>

                                @endforeach
                                @endif
                                @if ((array)$item->videos)
                                @foreach ((array)$item->videos as $item)
                                <div class="col-2">
                                    <video src="{{$item['file']}}" width="100%" controls="true" autoplay="false">
                                        <source src="{{$item['file']}}">
                                    </video>
                                </div>
                                @endforeach
                                @endif

                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @if(Auth::user()->user_type == 'franchise' && $finalProgress && ($project->status == 'complete'))
    <div wire:ignore.self class="modal fade" id="exampleModal11" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Progress</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-3 mt-1"><b>Satisfaction:</b></div>
                        <div class="col-9 mt-1">
                            <select class="form-control" wire:model="progress.satisfaction">
                                <option value="">Select</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            @error('progress.satisfaction')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-3 mt-1"><b>Reason:</b></div>
                        <div class="col-9 mt-1">
                            <input wire:model="progress.reason" type="text" class="form-control"
                                wire:model="selectedTask.title">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" wire:click="addProggress()">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if(Auth::user()->user_type == 'admin')
    <div wire:ignore.self class="modal fade" id="exampleModal90" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Activity Timeline</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <table class="table">
                                <tr>
                                    <td>User</td>
                                    <td>Description</td>
                                    <td>Date</td>
                                </tr>
                                @foreach ($eventLogs as $item)
                                <tr>
                                    <td>{{$item->user->name}}</td>
                                    <td>{{$item->description}}</td>
                                    <td>{{date('Y-m-d h:i A', strtotime($item->created_at))}}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
    @endif

</div>
<script>
    

    function format(input) 
    {
       
        var nStr = input.value + '';
        nStr = nStr.replace(/\,/g, "");
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        input.value = x1 + x2;
        
        if(input.id == 'valueadd') 
        {
            @this.set('propertyValue', nStr);
        }
    }
</script>
