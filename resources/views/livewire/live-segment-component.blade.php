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
                                <li class="breadcrumb-item"><a href="#">Segments</a>
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
                                <h4 class="card-title">Segments</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    @if($user->hasRole('create-segments'))
                                    <button type="button" wire:click='openModal' class="btn btn-outline-primary mb-3"
                                        data-toggle="modal" data-target="#createModal">
                                        <i class="bx bx-plus"></i> Add Segment
                                    </button>
                                    @endif
                                    @livewire('tables.segments-table', ['params' => [
                                        'user_id' => $user->id
                                    ]])
                                    <!--Create/Edit Modal -->
                                    <div class="modal fade text-left" id="createModal" wire:ignore.self
                                        tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary">
                                                    <h5 class="modal-title white" id="myModalLabel160">Create/Update Segment
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <i class="bx bx-x"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label>Name</label>
                                                        </div>
                                                        <div class="col-md-8 form-group ">
                                                            <div class="position-relative has-icon-left">
                                                                <input wire:model='name' type="text" id="fname-icon"
                                                                    class="form-control" name="fname-icon"
                                                                    placeholder="Name">
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-user"></i>
                                                                </div>
                                                            </div>
                                                            @error('name') <span class="text-danger">{{ $message
                                                                }}</span> @enderror
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Description</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <div class="position-relative has-icon-left">
                                                                <input wire:model='description' type="text" id="fname-icon"
                                                                    class="form-control" name="fname-id-icon"
                                                                    placeholder="Description">
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-text"></i>
                                                                </div>
                                                            </div>
                                                            @error('description') <span class="text-danger">{{ $message
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
                                                    <button type="button" wire:click='create'
                                                        class="btn btn-primary ml-1">
                                                        <i class="bx bx-check d-block d-sm-none"></i>
                                                        <span class="d-none d-sm-block">Create</span>
                                                    </button>
                                                    @endif
                                                    @if($model)
                                                    <button type="button" wire:click='update'
                                                        class="btn btn-primary ml-1">
                                                        <i class="bx bx-check d-block d-sm-none"></i>
                                                        <span class="d-none d-sm-block">Update</span>
                                                    </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Delete Confirmation Modal -->
                                    <div class="modal fade text-left" id="deleteModal" wire:ignore.self
                                        tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary">
                                                    <h5 class="modal-title white" id="myModalLabel160">Delete Segment Confirmation
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <i class="bx bx-x"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            Are you sure you want to delete this segment?
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