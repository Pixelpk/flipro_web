<div class="app-content content">
    <div class="content-overlay"></div>
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
                                <li class="breadcrumb-item"><a href="#">Tasks</a>
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
                                <h4 class="card-title">Tasks</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    @if($user->hasRole('create-leads'))
                                    <button type="button" wire:click='openModal' class="btn btn-outline-primary mb-3"
                                        data-toggle="modal" data-target="#userCreateModal">
                                        <i class="bx bx-plus"></i> Add
                                    </button>
                                    @endif
                                    @livewire('tables.tasks-table', ['params' => [
                                        'user_id' => $user->id
                                    ]])
                                    <!--Create/Edit Modal -->
                                    <div class="modal fade text-left" id="userCreateModal" wire:ignore.self
                                        tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary">
                                                    <h5 class="modal-title white" id="myModalLabel160">Add/Update Task
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <i class="bx bx-x"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label>Title</label>
                                                        </div>
                                                        <div class="col-md-8 form-group ">
                                                            <div class="position-relative has-icon-left">
                                                                <input wire:model.deffer='title' type="text" id="fname-icon"
                                                                    class="form-control" name="fname-icon"
                                                                    placeholder="Title">
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-text"></i>
                                                                </div>
                                                            </div>
                                                            @error('title') <span class="text-danger">{{ $message
                                                                }}</span> @enderror
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Lead</label>
                                                        </div>
                                                        <div class="col-md-8 form-group ">
                                                            <div class="position-relative has-icon-left">
                                                                <select wire:model.deffer='lead_id' name="" id="" class="form-control">
                                                                    <option value="">Select Lead</option>
                                                                    @foreach ($leads as $lead)
                                                                        <option value="{{$lead->id}}">{{$lead->name}} ({{$lead->email}})</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-user"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>User</label>
                                                        </div>
                                                        <div class="col-md-8 form-group ">
                                                            <div class="position-relative has-icon-left">
                                                                <select wire:model.deffer='user_id' name="" id="" class="form-control">
                                                                    <option value="">Select User</option>
                                                                    @foreach ($users as $user)
                                                                        <option value="{{$user->id}}">{{$user->name}} ({{$user->email}})</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-user"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Project</label>
                                                        </div>
                                                        <div class="col-md-8 form-group ">
                                                            <div class="position-relative has-icon-left">
                                                                <select wire:model.deffer='project_id' name="" id="" class="form-control">
                                                                    <option value="">Select Project</option>
                                                                    @foreach ($projects as $project)
                                                                        <option value="{{$project->id}}">{{$project->title}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-building"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Description</label>
                                                        </div>
                                                        <div class="col-md-8 form-group ">
                                                            <div class="position-relative has-icon-left">
                                                                <textarea wire:model.deffer='description' type="text" id="fname-icon"
                                                                    class="form-control" name="fname-icon"
                                                                    placeholder="Description"></textarea>
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-text"></i>
                                                                </div>
                                                            </div>
                                                            @error('description') <span class="text-danger">{{ $message
                                                                }}</span> @enderror
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Date Time</label>
                                                        </div>
                                                        <div class="col-md-8 form-group ">
                                                            <div class="position-relative has-icon-left">
                                                                <input type="datetime-local" wire:model.deffer='event_date' type="text" id="fname-icon"
                                                                    class="form-control" name="fname-icon"
                                                                    placeholder="">
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-calendar"></i>
                                                                </div>
                                                            </div>
                                                            @error('event_date') <span class="text-danger">{{ $message
                                                                }}</span> @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-secondary"
                                                        data-dismiss="modal">
                                                        <i class="bx bx-x d-block d-sm-none"></i>
                                                        <span class="d-none d-sm-block">Close</span>
                                                    </button>
                                                    @if(!$model)
                                                    <button wire:loading.attr="disabled" type="button" wire:click='create'
                                                        class="btn btn-primary ml-1">
                                                       Create
                                                       <span wire:loading wire:target="create" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>

                                                    </button>
                                                    @endif
                                                    @if($model)
                                                    <button wire:loading.attr="disabled" type="button" wire:click='update'
                                                        class="btn btn-primary ml-1">
                                                        Update
                                                        <span wire:loading wire:target="update" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                    </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Delete Confirmation Modal -->
                                    <div class="modal fade text-left" id="userDeleteModal" wire:ignore.self
                                        tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary">
                                                    <h5 class="modal-title white" id="myModalLabel160">Delete Lead Confirmation
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <i class="bx bx-x"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            Are you sure you want to delete this lead?
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-secondary"
                                                        data-dismiss="modal">
                                                        <i class="bx bx-x d-block d-sm-none"></i>
                                                        <span class="d-none d-sm-block">No</span>
                                                    </button>
                                                    @if($model)
                                                    <button type="button" wire:click='delete'
                                                        class="btn btn-primary ml-1">
                                                        <i class="bx bx-check d-block d-sm-none"></i>
                                                        <span class="d-none d-sm-block">Yes</span>
                                                    </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
