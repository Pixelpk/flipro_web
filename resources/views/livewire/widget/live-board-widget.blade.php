<div class="row" x-data="{tab: 'search'}">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <button :class="{ 'primary': tab === 'search' }" x-on:click.prevent="tab = 'search'" class="btn btn-light btn-block">Search</button>
                <button :class="{ 'primary': tab === 'pending' }" x-on:click.prevent="tab = 'pending'" class="btn btn-light btn-block">Pending</button>
                <button :class="{ 'primary': tab === 'new' }" x-on:click.prevent="tab = 'new'" class="btn btn-light btn-block">New</button>
                <button :class="{ 'primary': tab === 'Inprogress' }" x-on:click.prevent="tab = 'Inprogress'" class="btn btn-light btn-block">In-progress</button>

                <button :class="{ 'primary': tab === 'complete' }" x-on:click.prevent="tab = 'complete'" class="btn btn-light btn-block">Complete</button>
                <button :class="{ 'primary': tab === 'closed' }" x-on:click.prevent="tab = 'closed'" class="btn btn-light btn-block">Closed</button>
            </div>
        </div>
    </div>

    <!-- pending -->
    @if(Auth::user()->user_type == 'admin')

    <div class="col-md-8" x-show="tab === 'search'">
        <div class="card dashboard">
            <div class="card-header">
                <h4 class="card-title">Search</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="position-relative has-icon-left mb-2">
                        <input wire:model='search'
                            type="text" id="fapplicant_name-icon"
                            class="form-control" name="fapplicant_name-id-icon"
                            placeholder="Search...">
                        <div class="form-control-position">
                            <i class="bx bx-search"></i>
                        </div>
                    </div>
                    <div id="accordion">
                        @foreach ($SearchProjects as $item)
                        <div class="card accordion">
                            <div class="card-header accordion" id="heading{{$item->id}}">
                                <h5 class="mb-0" data-toggle="collapse" data-target="#collapse{{$item->id}}" aria-expanded="true" aria-controls="collapse{{$item->id}}">
                                    <button class="btn btn-link w-100 text-left">
                                        {{$item->title}} {{ '(' .$item->status. ')' }}
                                        <i class="bx bx-caret-down float-right"></i>
                                    </button>
                                </h5>
                            </div>

                            <div id="collapse{{$item->id}}" class="collapse" aria-labelledby="heading{{$item->id}}" data-parent="#accordion">
                                <div class="card-body" style="padding: 0px;">
                                    <img class="mt-1" style="width:100%;" src="{{$item->cover_photo}}" alt="">
                                    <ul class="mt-1 mb-2">
                                        <li>
                                            <b>Applicant Name:</b> {{$item->applicant_name}}
                                        </li>
                                        <li>
                                            <b>Applicant Email:</b> {{$item->email}}
                                        </li>
                                        <li>
                                            <b>Applicant Phone:</b> {{$item->phone}}
                                        </li>
                                        <li>
                                            <b>Property State:</b> {{$item->project_state}}
                                        </li>
                                        <li>
                                            <b>Property Title:</b> {{$item->project_address}}
                                        </li>

                                        <li>
                                            <b>Property Address:</b> {{$item->title}}
                                        </li>
                                        <li>
                                            <b>Cross Collaterized:</b> {{$item->cross_collaterized ? 'Yes' : 'No'}}
                                        </li>
                                        <li>
                                            <b>Current Value:</b> ${{number_format($item->current_property_value)}}
                                        </li>
                                        <li>
                                            <b>Current Debts:</b> ${{number_format($item->property_debt)}}
                                        </li>
                                        <li>
                                            <b>Anticipated Budget:</b> ${{number_format($item->anticipated_budget)}}
                                        </li>
                                    </ul>
                                    <a href="/projects/{{$item->id}}"><button class="btn btn-primary">View</button></a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    {{$newProjects->links()}}
                </div>
            </div>
        </div>
    </div>

    {{--  pending  --}}
    <div class="col-md-8" x-show="tab === 'pending'">
        <div class="card dashboard">
            <div class="card-header">
                <h4 class="card-title">Pending</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div id="accordion">
                        @foreach ($pendingProjects as $item)
                        <div class="card accordion">
                            <div class="card-header accordion" id="heading{{$item->id}}">
                                <h5 class="mb-0" data-toggle="collapse" data-target="#collapse{{$item->id}}" aria-expanded="true" aria-controls="collapse{{$item->id}}">
                                    <button class="btn btn-link w-100 text-left">
                                        {{$item->title}}
                                        <i class="bx bx-caret-down float-right"></i>
                                    </button>
                                </h5>
                            </div>

                            <div id="collapse{{$item->id}}" class="collapse" aria-labelledby="heading{{$item->id}}" data-parent="#accordion">
                                <div class="card-body" style="padding: 0px;">
                                    <img class="mt-1" style="width:100%;" src="{{$item->cover_photo}}" alt="">
                                    <ul class="mt-1 mb-2">
                                        <li>
                                            <b>Applicant Name:</b> {{$item->applicant_name}}
                                        </li>
                                        <li>
                                            <b>Applicant Email:</b> {{$item->email}}
                                        </li>
                                        <li>
                                            <b>Applicant Phone:</b> {{$item->phone}}
                                        </li>
                                        <li>
                                            <b>Property State:</b> {{$item->project_state}}
                                        </li>
                                        <li>
                                            <b>Property Title:</b> {{$item->project_address}}
                                        </li>

                                        <li>
                                            <b>Property Address:</b> {{$item->title}}
                                        </li>
                                        <li>
                                            <b>Cross Collaterized:</b> {{$item->cross_collaterized ? 'Yes' : 'No'}}
                                        </li>
                                        <li>
                                            <b>Current Value:</b> ${{number_format($item->current_property_value)}}
                                        </li>
                                        <li>
                                            <b>Current Debts:</b> ${{number_format($item->property_debt)}}
                                        </li>
                                        <li>
                                            <b>Anticipated Budget:</b> ${{number_format($item->anticipated_budget)}}
                                        </li>
                                    </ul>
                                    <a href="/projects/{{$item->id}}"><button class="btn btn-primary">View</button></a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    {{$newProjects->links()}}
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- /pending -->

    <!-- new -->
    <div class="col-md-8" x-show="tab === 'new'">
        <div class="row">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">New</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div id="accordion">
                                @foreach ($newProjects as $item)
                                <div class="card accordion">
                                    <div class="card-header accordion" id="heading{{$item->id}}">
                                        <h5 class="mb-0" data-toggle="collapse" data-target="#collapse{{$item->id}}" aria-expanded="true" aria-controls="collapse{{$item->id}}">
                                            <button class="btn btn-link w-100 text-left">
                                                {{$item->title}}
                                                <i class="bx bx-caret-down float-right"></i>
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="collapse{{$item->id}}" class="collapse" aria-labelledby="heading{{$item->id}}" data-parent="#accordion">
                                        <div class="card-body" style="padding: 0px;">
                                            {{-- <img class="mt-1" style="width:100%;" src="{{$item->cover_photo}}" alt=""> --}}
                                            <h1 class="mt-1" style="text-align: center;font-size: 35px;"> {{$item->title}}</h1>
                                            <ul class="mt-1 mb-2">
                                                <li>
                                                    <b>Applicant Name:</b> {{$item->applicant_name}}
                                                </li>
                                                <li>
                                                    <b>Applicant Email:</b> {{$item->email}}
                                                </li>
                                                <li>
                                                    <b>Applicant Phone:</b> {{$item->phone}}
                                                </li>
                                                <li>
                                                    <b>Property State:</b> {{$item->project_state}}
                                                </li>
                                                <li>
                                                    <b>Property Address:</b> {{$item->title}}
                                                </li>
                                                <li>
                                                    <b>Property Title:</b> {{$item->project_address}}
                                                </li>

                                                <li>
                                                    <b>Cross Collaterized:</b> {{$item->cross_collaterized ? 'Yes' : 'No'}}
                                                </li>
                                                <li>
                                                    <b>Current Value:</b> ${{number_format($item->current_property_value)}}
                                                </li>
                                                <li>
                                                    <b>Current Debts:</b> ${{number_format($item->property_debt)}}
                                                </li>
                                                <li>
                                                    <b>Anticipated Budget:</b> ${{number_format($item->anticipated_budget)}}
                                                </li>
                                            </ul>
                                            <a href="/projects/{{$item->id}}"><button class="btn btn-primary">View</button></a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            {{$newProjects->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /new -->

    <!-- in-progress -->
    <div class="col-md-8" x-show="tab === 'Inprogress'">
        <div class="row">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">In-Progress</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div id="accordion">
                                @foreach ($inProgressProjects as $item)
                                <div class="card accordion">
                                    <div class="card-header accordion" id="heading{{$item->id}}">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{$item->id}}" aria-expanded="true" aria-controls="collapse{{$item->id}}">
                                                {{$item->title}}
                                            </button>
                                        </h5>
                                    </div>

                                    <div id="collapse{{$item->id}}" class="collapse" aria-labelledby="heading{{$item->id}}" data-parent="#accordion">
                                        <div class="card-body" style="padding: 0px;">
                                            <img class="mt-1" style="width:100%;" src="{{$item->cover_photo}}" alt="">
                                            <ul class="mt-1 mb-2">
                                                <li>
                                                    <b>Applicant Name:</b> {{$item->applicant_name}}
                                                </li>
                                                <li>
                                                    <b>Applicant Email:</b> {{$item->email}}
                                                </li>
                                                <li>
                                                    <b>Applicant Phone:</b> {{$item->phone}}
                                                </li>
                                                <li>
                                                    <b>Property State:</b> {{$item->project_state}}
                                                </li>
                                                <li>
                                                    <b>Property Address:</b> {{$item->title}}
                                                </li>
                                                <li>
                                                    <b>Property Address:</b> {{$item->title}}
                                                </li>
                                                <li>
                                                    <b>Property Title:</b> {{$item->project_address}}
                                                </li>
                                                <li>
                                                    <b>Cross Collaterized:</b> {{$item->cross_collaterized ? 'Yes' : 'No'}}
                                                </li>
                                                <li>
                                                    <b>Current Value:</b> ${{number_format($item->current_property_value)}}
                                                </li>
                                                <li>
                                                    <b>Current Debts:</b> ${{number_format($item->property_debt)}}
                                                </li>
                                                <li>
                                                    <b>Anticipated Budget:</b> ${{number_format($item->anticipated_budget)}}
                                                </li>
                                            </ul>
                                            <a href="/projects/{{$item->id}}"><button class="btn btn-primary">View</button></a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            {{$newProjects->links()}}
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Project Closed</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div> --}}
        </div>
    </div>
    <!-- /in-progress -->

    <!-- closed -->
    <div class="col-md-8" x-show="tab === 'closed'">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Closed</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div id="accordion">
                        @foreach ($closedProjects as $item)
                        <div class="card accordion">
                            <div class="card-header accordion" id="heading{{$item->id}}">
                                <h5 class="mb-0" data-toggle="collapse" data-target="#collapse{{$item->id}}" aria-expanded="true" aria-controls="collapse{{$item->id}}">
                                    <button class="btn btn-link w-100 text-left">
                                        {{$item->title}}
                                        <i class="bx bx-caret-down float-right"></i>
                                    </button>
                                </h5>
                            </div>

                            <div id="collapse{{$item->id}}" class="collapse" aria-labelledby="heading{{$item->id}}" data-parent="#accordion">
                                <div class="card-body" style="padding: 0px;">
                                    <img class="mt-1" style="width:100%;" src="{{$item->cover_photo}}" alt="">
                                    <ul class="mt-1 mb-2">
                                        <li>
                                            <b>Applicant Name:</b> {{$item->applicant_name}}
                                        </li>
                                        <li>
                                            <b>Applicant Email:</b> {{$item->email}}
                                        </li>
                                        <li>
                                            <b>Applicant Phone:</b> {{$item->phone}}
                                        </li>
                                        <li>
                                            <b>Property State:</b> {{$item->project_state}}
                                        </li>
                                        <li>
                                            <b>Property Address:</b> {{$item->title}}
                                        </li>
                                        <li>
                                            <b>Property Address:</b> {{$item->title}}
                                        </li>
                                        <li>
                                            <b>Property Title:</b> {{$item->project_address}}
                                        </li>
                                        <li>
                                            <b>Cross Collaterized:</b> {{$item->cross_collaterized ? 'Yes' : 'No'}}
                                        </li>
                                        <li>
                                            <b>Current Value:</b> ${{number_format($item->current_property_value)}}
                                        </li>
                                        <li>
                                            <b>Current Debts:</b> ${{number_format($item->property_debt)}}
                                        </li>
                                        <li>
                                            <b>Anticipated Budget:</b> ${{number_format($item->anticipated_budget)}}
                                        </li>
                                    </ul>
                                    <a href="/projects/{{$item->id}}"><button class="btn btn-primary">View</button></a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    {{$newProjects->links()}}
                </div>
            </div>
        </div>
    </div>
    <!-- /closed -->

    <!-- complete -->
    <div class="col-md-8" x-show="tab === 'complete'">
        <div class="row">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Complete</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div id="accordion">
                                @foreach ($completedProjects as $item)
                                <div class="card accordion">
                                    <div class="card-header accordion" id="heading{{$item->id}}">
                                        <h5 class="mb-0" data-toggle="collapse" data-target="#collapse{{$item->id}}" aria-expanded="true" aria-controls="collapse{{$item->id}}">
                                            <button class="btn btn-link w-100 text-left">
                                                {{$item->title}}
                                                <i class="bx bx-caret-down float-right"></i>
                                            </button>
                                        </h5>
                                    </div>

                                    <div id="collapse{{$item->id}}" class="collapse" aria-labelledby="heading{{$item->id}}" data-parent="#accordion">
                                        <div class="card-body" style="padding: 0px;">
                                            <img class="mt-1" style="width:100%;" src="{{$item->cover_photo}}" alt="">
                                            <ul class="mt-1 mb-2">
                                                <li>
                                                    <b>Applicant Name:</b> {{$item->applicant_name}}
                                                </li>
                                                <li>
                                                    <b>Applicant Email:</b> {{$item->email}}
                                                </li>
                                                <li>
                                                    <b>Applicant Phone:</b> {{$item->phone}}
                                                </li>
                                                <li>
                                                    <b>Property State:</b> {{$item->project_state}}
                                                </li>
                                                <li>
                                                    <b>Property Address:</b> {{$item->title}}
                                                </li>
                                                <li>
                                                    <b>Property Title:</b> {{$item->project_address}}
                                                </li>
                                                <li>
                                                    <b>Cross Collaterized:</b> {{$item->cross_collaterized ? 'Yes' : 'No'}}
                                                </li>
                                                <li>
                                                    <b>Current Value:</b> ${{number_format($item->current_property_value)}}
                                                </li>
                                                <li>
                                                    <b>Current Debts:</b> ${{number_format($item->property_debt)}}
                                                </li>
                                                <li>
                                                    <b>Anticipated Budget:</b> ${{number_format($item->anticipated_budget)}}
                                                </li>
                                            </ul>
                                            <a href="/projects/{{$item->id}}"><button class="btn btn-primary">View</button></a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            {{$newProjects->links()}}
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Re-evaluation</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                    </div>
                </div>
            </div>
        </div> --}}
        </div>
    </div>
    <!-- /complete -->
</div>


<!-- @if(Auth::user()->user_type == 'admin')
<div class="col-md-4">
    <div class="card dashboard">
        <div class="card-header">
            <h4 class="card-title">Pending</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <div id="accordion">
                    @foreach ($pendingProjects as $item)
                    <div class="card accordion">
                        <div class="card-header accordion" id="heading{{$item->id}}">
                            <h5 class="mb-0" data-toggle="collapse" data-target="#collapse{{$item->id}}" aria-expanded="true" aria-controls="collapse{{$item->id}}">
                                <button class="btn btn-link w-100 text-left">
                                    {{$item->title}}
                                    <i class="bx bx-caret-down float-right"></i>
                                </button>
                            </h5>
                        </div>

                        <div id="collapse{{$item->id}}" class="collapse" aria-labelledby="heading{{$item->id}}" data-parent="#accordion">
                            <div class="card-body" style="padding: 0px;">
                                <img class="mt-1" style="width:100%;" src="{{$item->cover_photo}}" alt="">
                                <ul class="mt-1 mb-2">
                                    <li>
                                        <b>Applicant Name:</b> {{$item->applicant_name}}
                                    </li>
                                    <li>
                                        <b>Applicant Email:</b> {{$item->email}}
                                    </li>
                                    <li>
                                        <b>Applicant Phone:</b> {{$item->phone}}
                                    </li>
                                    <li>
                                        <b>Property State:</b> {{$item->project_state}}
                                    </li>
                                    <li>
                                        <b>Property Title:</b> {{$item->project_address}}
                                    </li>

                                    <li>
                                        <b>Property Address:</b> {{$item->title}}
                                    </li>
                                    <li>
                                        <b>Cross Collaterized:</b> {{$item->cross_collaterized ? 'Yes' : 'No'}}
                                    </li>
                                    <li>
                                        <b>Current Value:</b> ${{number_format($item->current_property_value)}}
                                    </li>
                                    <li>
                                        <b>Current Debts:</b> ${{number_format($item->property_debt)}}
                                    </li>
                                    <li>
                                        <b>Anticipated Budget:</b> ${{number_format($item->anticipated_budget)}}
                                    </li>
                                </ul>
                                <a href="/projects/{{$item->id}}"><button class="btn btn-primary">View</button></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                {{$newProjects->links()}}
            </div>
        </div>
    </div>
</div>
@endif -->

<!-- <div class="col-4 col-md-4">
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">New</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div id="accordion">
                            @foreach ($newProjects as $item)
                            <div class="card accordion">
                                <div class="card-header accordion" id="heading{{$item->id}}">
                                    <h5 class="mb-0" data-toggle="collapse" data-target="#collapse{{$item->id}}" aria-expanded="true" aria-controls="collapse{{$item->id}}">
                                        <button class="btn btn-link w-100 text-left">
                                            {{$item->title}}
                                            <i class="bx bx-caret-down float-right"></i>
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapse{{$item->id}}" class="collapse" aria-labelledby="heading{{$item->id}}" data-parent="#accordion">
                                    <div class="card-body" style="padding: 0px;">
                                        {{-- <img class="mt-1" style="width:100%;" src="{{$item->cover_photo}}" alt=""> --}}
                                        <h1 class="mt-1" style="text-align: center;font-size: 35px;"> {{$item->title}}</h1>
                                        <ul class="mt-1 mb-2">
                                            <li>
                                                <b>Applicant Name:</b> {{$item->applicant_name}}
                                            </li>
                                            <li>
                                                <b>Applicant Email:</b> {{$item->email}}
                                            </li>
                                            <li>
                                                <b>Applicant Phone:</b> {{$item->phone}}
                                            </li>
                                            <li>
                                                <b>Property State:</b> {{$item->project_state}}
                                            </li>
                                            <li>
                                                <b>Property Address:</b> {{$item->title}}
                                            </li>
                                            <li>
                                                <b>Property Title:</b> {{$item->project_address}}
                                            </li>

                                            <li>
                                                <b>Cross Collaterized:</b> {{$item->cross_collaterized ? 'Yes' : 'No'}}
                                            </li>
                                            <li>
                                                <b>Current Value:</b> ${{number_format($item->current_property_value)}}
                                            </li>
                                            <li>
                                                <b>Current Debts:</b> ${{number_format($item->property_debt)}}
                                            </li>
                                            <li>
                                                <b>Anticipated Budget:</b> ${{number_format($item->anticipated_budget)}}
                                            </li>
                                        </ul>
                                        <a href="/projects/{{$item->id}}"><button class="btn btn-primary">View</button></a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        {{$newProjects->links()}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-12">
            <div class="card dashboard">
                <div class="card-header">
                    <h4 class="card-title">Closed</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div id="accordion">
                            @foreach ($closedProjects as $item)
                            <div class="card accordion">
                                <div class="card-header accordion" id="heading{{$item->id}}">
                                    <h5 class="mb-0" data-toggle="collapse" data-target="#collapse{{$item->id}}" aria-expanded="true" aria-controls="collapse{{$item->id}}">
                                        <button class="btn btn-link w-100 text-left">
                                            {{$item->title}}
                                            <i class="bx bx-caret-down float-right"></i>
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapse{{$item->id}}" class="collapse" aria-labelledby="heading{{$item->id}}" data-parent="#accordion">
                                    <div class="card-body" style="padding: 0px;">
                                        <img class="mt-1" style="width:100%;" src="{{$item->cover_photo}}" alt="">
                                        <ul class="mt-1 mb-2">
                                            <li>
                                                <b>Applicant Name:</b> {{$item->applicant_name}}
                                            </li>
                                            <li>
                                                <b>Applicant Email:</b> {{$item->email}}
                                            </li>
                                            <li>
                                                <b>Applicant Phone:</b> {{$item->phone}}
                                            </li>
                                            <li>
                                                <b>Property State:</b> {{$item->project_state}}
                                            </li>
                                            <li>
                                                <b>Property Address:</b> {{$item->title}}
                                            </li>
                                            <li>
                                                <b>Property Address:</b> {{$item->title}}
                                            </li>
                                            <li>
                                                <b>Property Title:</b> {{$item->project_address}}
                                            </li>
                                            <li>
                                                <b>Cross Collaterized:</b> {{$item->cross_collaterized ? 'Yes' : 'No'}}
                                            </li>
                                            <li>
                                                <b>Current Value:</b> ${{number_format($item->current_property_value)}}
                                            </li>
                                            <li>
                                                <b>Current Debts:</b> ${{number_format($item->property_debt)}}
                                            </li>
                                            <li>
                                                <b>Anticipated Budget:</b> ${{number_format($item->anticipated_budget)}}
                                            </li>
                                        </ul>
                                        <a href="/projects/{{$item->id}}"><button class="btn btn-primary">View</button></a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        {{$newProjects->links()}}
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>

<div class="col-4 col-md-4">
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">In-Progress</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div id="accordion">
                            @foreach ($inProgressProjects as $item)
                            <div class="card accordion">
                                <div class="card-header accordion" id="heading{{$item->id}}">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{$item->id}}" aria-expanded="true" aria-controls="collapse{{$item->id}}">
                                            {{$item->title}}
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapse{{$item->id}}" class="collapse" aria-labelledby="heading{{$item->id}}" data-parent="#accordion">
                                    <div class="card-body" style="padding: 0px;">
                                        <img class="mt-1" style="width:100%;" src="{{$item->cover_photo}}" alt="">
                                        <ul class="mt-1 mb-2">
                                            <li>
                                                <b>Applicant Name:</b> {{$item->applicant_name}}
                                            </li>
                                            <li>
                                                <b>Applicant Email:</b> {{$item->email}}
                                            </li>
                                            <li>
                                                <b>Applicant Phone:</b> {{$item->phone}}
                                            </li>
                                            <li>
                                                <b>Property State:</b> {{$item->project_state}}
                                            </li>
                                            <li>
                                                <b>Property Address:</b> {{$item->title}}
                                            </li>
                                            <li>
                                                <b>Property Address:</b> {{$item->title}}
                                            </li>
                                            <li>
                                                <b>Property Title:</b> {{$item->project_address}}
                                            </li>
                                            <li>
                                                <b>Cross Collaterized:</b> {{$item->cross_collaterized ? 'Yes' : 'No'}}
                                            </li>
                                            <li>
                                                <b>Current Value:</b> ${{number_format($item->current_property_value)}}
                                            </li>
                                            <li>
                                                <b>Current Debts:</b> ${{number_format($item->property_debt)}}
                                            </li>
                                            <li>
                                                <b>Anticipated Budget:</b> ${{number_format($item->anticipated_budget)}}
                                            </li>
                                        </ul>
                                        <a href="/projects/{{$item->id}}"><button class="btn btn-primary">View</button></a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        {{$newProjects->links()}}
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Project Closed</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</div>

<div class="col-md-4 col-4">
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Complete</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div id="accordion">
                            @foreach ($completedProjects as $item)
                            <div class="card accordion">
                                <div class="card-header accordion" id="heading{{$item->id}}">
                                    <h5 class="mb-0" data-toggle="collapse" data-target="#collapse{{$item->id}}" aria-expanded="true" aria-controls="collapse{{$item->id}}">
                                        <button class="btn btn-link w-100 text-left">
                                            {{$item->title}}
                                            <i class="bx bx-caret-down float-right"></i>
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapse{{$item->id}}" class="collapse" aria-labelledby="heading{{$item->id}}" data-parent="#accordion">
                                    <div class="card-body" style="padding: 0px;">
                                        <img class="mt-1" style="width:100%;" src="{{$item->cover_photo}}" alt="">
                                        <ul class="mt-1 mb-2">
                                            <li>
                                                <b>Applicant Name:</b> {{$item->applicant_name}}
                                            </li>
                                            <li>
                                                <b>Applicant Email:</b> {{$item->email}}
                                            </li>
                                            <li>
                                                <b>Applicant Phone:</b> {{$item->phone}}
                                            </li>
                                            <li>
                                                <b>Property State:</b> {{$item->project_state}}
                                            </li>
                                            <li>
                                                <b>Property Address:</b> {{$item->title}}
                                            </li>
                                            <li>
                                                <b>Property Title:</b> {{$item->project_address}}
                                            </li>
                                            <li>
                                                <b>Cross Collaterized:</b> {{$item->cross_collaterized ? 'Yes' : 'No'}}
                                            </li>
                                            <li>
                                                <b>Current Value:</b> ${{number_format($item->current_property_value)}}
                                            </li>
                                            <li>
                                                <b>Current Debts:</b> ${{number_format($item->property_debt)}}
                                            </li>
                                            <li>
                                                <b>Anticipated Budget:</b> ${{number_format($item->anticipated_budget)}}
                                            </li>
                                        </ul>
                                        <a href="/projects/{{$item->id}}"><button class="btn btn-primary">View</button></a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        {{$newProjects->links()}}
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Re-evaluation</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</div> -->
