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
                                <li class="breadcrumb-item"><a href="#">Projects</a>
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
                                <h4 class="card-title">Projects</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    @if($user->hasRole('create-projects'))
                                    <button type="button" wire:click='openModal' class="btn btn-outline-primary mb-3"
                                        data-toggle="modal" data-target="#createModal">
                                        <i class="bx bx-plus"></i> Add Project
                                    </button>
                                    @endif
                                    @livewire('tables.project-table', ['params' => [
                                    'user_id' => $user->id
                                    ]])
                                    <!--Create/Edit Modal -->
                                    <div class="modal fade text-left" id="createModal" wire:ignore.self tabindex="-1"
                                        role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
                                        <div class="modal-dialog modal-full modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary">
                                                    <h5 class="modal-title white" id="myModalLabel160">Create/Update
                                                        Project
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <i class="bx bx-x"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-12 mb-2">
                                                            <h1 style="font-size: 25px;"><u>Applicant Information</u>
                                                            </h1>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label>Applicant Name</label>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <div class="position-relative has-icon-left">
                                                                <input wire:model.defer='model.applicant_name'
                                                                    type="text" id="fapplicant_name-icon"
                                                                    class="form-control" name="fapplicant_name-id-icon"
                                                                    placeholder="Applicant Name">
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-note"></i>
                                                                </div>
                                                            </div>
                                                            @error('model.applicant_name') <span class="text-danger">{{ $message
                                                                }}</span> @enderror
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label>Email</label>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <div class="position-relative has-icon-left">
                                                                <input wire:model.defer='model.email' type="text"
                                                                    id="femail-icon" class="form-control"
                                                                    name="femail-id-icon" placeholder="Email Address">
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-envelope"></i>
                                                                </div>
                                                            </div>
                                                            @error('model.email') <span class="text-danger">{{ $message
                                                                }}</span> @enderror
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label>Phone</label>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <div class="position-relative has-icon-left">

                                                                <input wire:model.defer='model.phone' type="text"
                                                                    id="fphone-icon" class="form-control"
                                                                    name="fphone-id-icon" placeholder="Phone">
                                                                <div class="form-control-position six1" style="padding-left: 7px">
                                                                    {{--  <i class="bx bx-phone" style="margin: 0 7px"></i>  --}}
                                                                    <span style="color: #6b7280; margin-bootom:3px; inline-block">+61</span>
                                                                </div>
                                                            </div>
                                                            @error('model.phone') <span class="text-danger">{{ $message
                                                                }}</span> @enderror
                                                        </div>


                                                        <div class="col-md-2">
                                                            <label>Registered Owner</label>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <div class="position-relative has-icon-left">
                                                                <input wire:model.defer='model.registered_owners'
                                                                    type="text" id="fregistered_owners-icon"
                                                                    class="form-control"
                                                                    name="fregistered_owners-id-icon"
                                                                    placeholder="Registered Owner">
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-user-circle"></i>
                                                                </div>
                                                            </div>
                                                            @error('model.registered_owners') <span class="text-danger">{{ $message
                                                                }}</span> @enderror
                                                        </div>

                                                        <div class="col-12 mb-2">
                                                            <h1 style="font-size: 25px;"><u>Property's Financial
                                                                    Value</u></h1>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label>Current Value</label>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <div class="position-relative has-icon-left">
                                                                <input wire:model.defer='model.current_property_value'
                                                                    type="number" id="fcurrent_property_value-icon"
                                                                    class="form-control"
                                                                    name="fcurrent_property_value-id-icon"
                                                                    placeholder="Current Value">
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-money"></i>
                                                                </div>
                                                            </div>
                                                            @error('model.current_property_value') <span
                                                                class="text-danger">{{ $message
                                                                }}</span> @enderror
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label>Property Debts</label>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <div class="position-relative has-icon-left">
                                                                <input wire:model.defer='model.property_debt'
                                                                    type="number" id="fproperty_debt-icon"
                                                                    class="form-control" name="fproperty_debt-id-icon"
                                                                    placeholder="Property Debts">
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-money"></i>
                                                                </div>
                                                            </div>
                                                            @error('model.property_debt') <span class="text-danger">{{ $message
                                                                }}</span> @enderror
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label>Cross Collaterized</label>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <div class="position-relative has-icon-left">
                                                                <input type="radio" name="cross_collaterized" value="1"
                                                                    wire:model.defer='model.cross_collaterized'> Yes
                                                                <input type="radio" name="cross_collaterized" value="0"
                                                                    wire:model.defer='model.cross_collaterized'> No
                                                            </div>
                                                            @error('model.cross_collaterized') <span
                                                                class="text-danger">{{ $message
                                                                }}</span> @enderror
                                                        </div>
                                                        <div class="col-12 mb-2">
                                                            <h1 style="font-size: 25px;"><u>Project's Information</u>
                                                            </h1>
                                                        </div>


                                                        <div class="col-md-2">
                                                            <label>Project Address</label>
                                                        </div>
                                                        <div class="col-md-4 form-group ">
                                                            <div class="position-relative has-icon-left">
                                                                <input wire:model.defer='model.title' type="text"
                                                                    id="ftitle-icon" class="form-control"
                                                                    name="ftitle-icon" placeholder="Project Address">
                                                                <div class="form-control-position">

                                                                    <i class="bx bx-pin"></i>
                                                                </div>
                                                            </div>
                                                            @error('model.title') <span class="text-danger">{{ $message
                                                                }}</span> @enderror
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label>Area (square meters)</label>
                                                        </div>
                                                        <div class="col-md-4 form-group ">
                                                            <div class="position-relative has-icon-left">
                                                                <input wire:model.defer='model.area' type="number"
                                                                    id="ftitle-icon" class="form-control"
                                                                    name="ftitle-icon" placeholder="Area (square meters)">
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-text"></i>
                                                                </div>
                                                            </div>
                                                            @error('model.area') <span class="text-danger">{{ $message
                                                                }}</span> @enderror
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label>Anticipated Budget</label>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <div class="position-relative has-icon-left">
                                                                <input wire:model.defer='model.anticipated_budget'
                                                                    type="number" id="fanticipatedbudget-icon"
                                                                    class="form-control"
                                                                    name="fanticipatedbudget-id-icon"
                                                                    placeholder="Anticipated Budget">
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-money"></i>
                                                                </div>
                                                            </div>
                                                            @error('model.anticipated_budget') <span
                                                                class="text-danger">{{ $message
                                                                }}</span> @enderror
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label>Project Title</label>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <div class="position-relative has-icon-left">
                                                                <input wire:model.defer='model.project_address'
                                                                    type="text" id="fproject_address-icon"
                                                                    class="form-control" name="fproject_address-id-icon"
                                                                    placeholder="Project Title">
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-text"></i>
                                                                </div>
                                                            </div>
                                                            @error('model.project_address') <span class="text-danger">{{ $message
                                                                }}</span> @enderror
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label>Applicant Address</label>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <div class="position-relative has-icon-left">
                                                                <input wire:model.defer='model.applicant_address'
                                                                    type="text" id="fapplicant_address-icon"
                                                                    class="form-control"
                                                                    name="fapplicant_address-id-icon"
                                                                    placeholder="Applicant Address">
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-pin"></i>
                                                                </div>
                                                            </div>
                                                            @error('model.applicant_address') <span class="text-danger">{{ $message
                                                                }}</span> @enderror
                                                        </div>


                                                        <div class="col-md-2">
                                                            <label>Suburb, State and Postcode</label>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <div class="position-relative has-icon-left">
                                                                <input wire:model.defer='model.project_state'
                                                                    type="text" id="fproject_address-icon"
                                                                    class="form-control" name="fproject_address-id-icon"
                                                                    placeholder="Suburb, State and Postcode">
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-pin"></i>
                                                                </div>
                                                            </div>
                                                            @error('model.project_state') <span class="text-danger">{{ $message
                                                                }}</span> @enderror
                                                        </div>
                                                        {{--  <div class="col-md-2">
                                                            <label>Contractor/Supplier Details</label>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <div class="position-relative has-icon-left">
                                                                <input
                                                                    wire:model.defer='model.contractor_supplier_details'
                                                                    type="text" id="fcontractor_supplier_details-icon"
                                                                    class="form-control"
                                                                    name="fcontractor_supplier_details-id-icon"
                                                                    placeholder="Contractor/Supplier Details">
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-note"></i>
                                                                </div>
                                                            </div>
                                                            @error('model.contractor_supplier_details') <span
                                                                class="text-danger">{{ $message
                                                                }}</span> @enderror
                                                        </div>  --}}




                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>Existing queries</label>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <div class="position-relative has-icon-left">
                                                                <input type="radio" name="contractor_supplier_details" value="1"
                                                                    wire:model.defer='model.contractor_supplier_details'> Yes
                                                                <input type="radio" name="contractor_supplier_details" value="0"
                                                                    wire:model.defer='model.contractor_supplier_details'> No
                                                            </div>
                                                            @error('model.contractor_supplier_details') <span
                                                                class="text-danger">{{ $message
                                                                }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>Description</label>
                                                        </div>
                                                        <div class="col-md-12 form-group">
                                                            <div class="position-relative has-icon-left">
                                                                <textarea wire:model='model.description'
                                                                    placeholder="Description"
                                                                    class="form-control"></textarea>
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-note"></i>
                                                                </div>
                                                            </div>
                                                            @error('model.description') <span class="text-danger">{{ $message
                                                                }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h1>Images</h1>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-4 mt-1">
                                                                    {{-- <input wire:model='images' type="file"
                                                                        accept="image/apng, image/avif, image/gif, image/jpeg, image/png, image/svg+xml, image/webp"
                                                                        class="form-control" multiple> --}}
                                                                    <div x-data="{ isUploading: false, progress: 0 }"
                                                                        x-on:livewire-upload-start="isUploading = true"
                                                                        x-on:livewire-upload-finish="isUploading = false"
                                                                        x-on:livewire-upload-error="isUploading = false"
                                                                        x-on:livewire-upload-progress="progress = $event.detail.progress">
                                                                        <!-- File Input -->
                                                                        <input wire:model='images' type="file"
                                                                            accept="image/apng, image/avif, image/gif, image/jpeg, image/png, image/svg+xml, image/webp"
                                                                            class="form-control" multiple>

                                                                        <!-- Progress Bar -->
                                                                        <div x-show="isUploading">
                                                                            <progress max="100"
                                                                                x-bind:value="progress"></progress>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @if($pushImage)
                                                            <div class="row">
                                                                @foreach($pushImage as $index => $image)
                                                                <div class="col-md-2">
                                                                    <img src="{{ $image->temporaryUrl() }}">
                                                                    <i wire:click="delpushImage({{ $index }})"
                                                                        class="text-danger bx bx-trash" style="cursor:
                                                                    pointer"></i>
                                                                </div>
                                                                @endforeach
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <button wire:click="delAllImages" type="button"
                                                                        class="btn btn-primary ml-1">All Delete</button>
                                                                </div>
                                                            </div>
                                                            @endif
                                                            @error('images.*') <span class="error">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-12 mt-1">
                                                            <h1>Video</h1>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-4 mt-1">
                                                                    {{-- <input wire:model='videos' type="file" accept="video/mp4, video/webp" multiple> --}}
                                                                    <div x-data="{ isUploading: false, progress: 0 }"
                                                                        x-on:livewire-upload-start="isUploading = true"
                                                                        x-on:livewire-upload-finish="isUploading = false"
                                                                        x-on:livewire-upload-error="isUploading = false"
                                                                        x-on:livewire-upload-progress="progress = $event.detail.progress">
                                                                        <!-- File Input -->
                                                                        <input wire:model='videos' type="file"
                                                                            accept="video/mp4, video/webp" multiple>

                                                                        <!-- Progress Bar -->
                                                                        <div x-show="isUploading">
                                                                            <progress max="100"
                                                                                x-bind:value="progress"></progress>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @if($pushVideos)
                                                            <div class="row">
                                                                @foreach($pushVideos as $index => $video)
                                                                <div class="col-md-1">
                                                                    <i class="bx bx-file" style="font-size:80px;"></i>
                                                                    <i wire:click="delpushVideos({{ $index }})"
                                                                        class="text-danger bx bx-trash" style="cursor:
                                                                    pointer"></i>

                                                                </div>
                                                                @endforeach
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <button wire:click="delAllVideos()" type="button"
                                                                        class="btn btn-primary ml-1">All Delete</button>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-secondary"
                                                        wire:loading.attr='disabled' data-dismiss="modal">
                                                        <i class="bx bx-x d-block d-sm-none"></i>
                                                        <span class="d-none d-sm-block">Close</span>
                                                    </button>
                                                    @if(!isset($model->id))
                                                    {{-- <button type="button" wire:click='create'
                                                        wire:loading.attr='disabled' wire:target='videos,images'
                                                        class="btn btn-primary ml-1">

                                                      Create
                                                    <span wire:loading>please wait...</span>
                                                    </button> --}}
                                                    <button wire:loading.attr="disabled" wire:click='create'
                                                        class="btn btn-primary" type="button">

                                                        Create
                                                        <span wire:loading wire:target="create"
                                                        class="spinner-grow spinner-grow-sm" role="status"
                                                        aria-hidden="true"></span>
                                                    </button>
                                                    @endif
                                                    @if(isset($model->id))
                                                    {{-- <button type="button" wire:click='update'
                                                        wire:loading.attr='disabled' class="btn btn-primary ml-1">

                                                        Update
                                                        <span wire:loading>Please wait...</span>
                                                    </button> --}}
                                                    <button wire:loading.attr="disabled" wire:click='update'
                                                    class="btn btn-primary" type="button">

                                                    Update
                                                    <span wire:loading wire:target="update"
                                                    class="spinner-grow spinner-grow-sm" role="status"
                                                    aria-hidden="true"></span>
                                                </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Delete Confirmation Modal -->
                                    <div class="modal fade text-left" id="deleteModal" wire:ignore.self tabindex="-1"
                                        role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary">
                                                    <h5 class="modal-title white" id="myModalLabel160">Delete Segment
                                                        Confirmation
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
