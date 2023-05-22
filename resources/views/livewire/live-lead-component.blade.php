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
                                <li class="breadcrumb-item"><a href="#">Leads</a>
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
                                <h4 class="card-title">Leads</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    @if ($user->hasRole('create-leads'))
                                        <button type="button" wire:click='openModal'
                                            class="btn btn-outline-primary mb-3" data-toggle="modal"
                                            data-target="#userCreateModal">
                                            <i class="bx bx-plus"></i> Add {{ $type }}
                                        </button>
                                        <button type="button" wire:click='openModalexel'
                                            class="btn btn-outline-primary mb-3" data-toggle="modal"
                                            data-target="#openModalexel">
                                            <i class="bx bx-import"></i> Excel Import {{ $type }}
                                        </button>
                                    @endif
                                    @livewire('tables.leads-table', [
                                        'params' => [
                                            'user_id' => $user->id,
                                        ],
                                    ])
                                    <!--Exel Import/ Modal -->
                                    <div class="modal fade text-left" id="openModalexel" wire:ignore.self tabindex="-1"
                                        role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary">
                                                    <h5 class="modal-title white" id="myModalLabel160">Excel import
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <i class="bx bx-x"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label>Import</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <div class="position-relative has-icon-left">
                                                                <div x-data="{ isUploading: false, progress: 0 }"
                                                                    x-on:livewire-upload-start="isUploading = true"
                                                                    x-on:livewire-upload-finish="isUploading = false"
                                                                    x-on:livewire-upload-error="isUploading = false"
                                                                    x-on:livewire-upload-progress="progress = $event.detail.progress">
                                                                    <!-- File Input -->
                                                                    <input type="file" wire:model="exelfile"
                                                                    class="form-control"
                                                                        accept=".csv,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">

                                                                    <!-- Progress Bar -->
                                                                    <div x-show="isUploading">
                                                                        <progress max="100"
                                                                            x-bind:value="progress"></progress>
                                                                    </div>
                                                                </div>
                                                                {{-- <input 
                                                            accept=".csv,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                                            wire:model='exelfile' type="file" id="import-icon"
                                                                class="form-control" name="import-icon"
                                                                placeholder="Name"> --}}
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-import"></i>
                                                                </div>
                                                            </div>
                                                            @error('exelfile')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        @error('exelfile') <span class="text-danger">{{ $message
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
                                                <button  wire:loading.attr="disabled" type="submit" wire:click='import'
                                                    class="btn btn-primary ml-1">
                                                    <i class="bx bx-check d-block d-sm-none"></i>
                                                    <span class="d-none d-sm-block">Import</span>



                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-secondary"
                                                        data-dismiss="modal">
                                                        <i class="bx bx-x d-block d-sm-none"></i>
                                                        <span class="d-none d-sm-block">Close</span>
                                                    </button>
                                                    @if (!$model)
                                                        <button wire:loading.attr="disabled" type="button"
                                                            wire:click='import' class="btn btn-primary ml-1">
                                                            <i class="bx bx-check d-block d-sm-none"></i>
                                                            <span class="d-none d-sm-block">Import</span>

                                                            <span wire:loading wire:target="import"
                                                                class="spinner-grow spinner-grow-sm" role="status"
                                                                aria-hidden="true"></span>
                                                        </button>
                                                    @endif
                                                    @if ($model)
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
                                    <!--Create/Edit Modal -->
                                    <div class="modal fade text-left" id="userCreateModal" wire:ignore.self
                                        tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary">
                                                    <h5 class="modal-title white" id="myModalLabel160">Add/Update Lead
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
                                                                <input wire:model='name' type="text"
                                                                    id="fname-icon" class="form-control"
                                                                    name="fname-icon" placeholder="Name">
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-user"></i>
                                                                </div>
                                                            </div>
                                                            @error('name')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Email</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <div class="position-relative has-icon-left">
                                                                <input wire:model='email' type="email"
                                                                    id="email-icon" class="form-control"
                                                                    name="email-id-icon" placeholder="Email">
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-mail-send"></i>
                                                                </div>
                                                            </div>
                                                            @error('email')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Phone</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <div class="position-relative">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <select wire:model='phone_code'
                                                                            class="form-control input-group-text">
                                                                            <option value="">Country</option>
                                                                            <option value="61">+61 (Australia)
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                    <input wire:model='phone' type="number"
                                                                        class="form-control" placeholder="Phone"
                                                                        aria-describedby="basic-addon1">
                                                                </div>
                                                            </div>
                                                            @error('phone')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                            @error('phone_code')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Segments</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <div class="position-relative">
                                                                <select wire:model='selectedSegments'
                                                                    class="form-control" multiple>
                                                                    @foreach ($segments as $item)
                                                                        <option value="{{ $item->id }}">
                                                                            {{ $item->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            @error('selectedSegments')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                            @error('selectedSegments')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Tags</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <div class="position-relative">
                                                                <select wire:model='selectedTags' class="form-control"
                                                                    multiple>
                                                                    @foreach ($tags as $item)
                                                                        <option value="{{ $item->id }}">
                                                                            {{ $item->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            @error('selectedTags')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                            @error('selectedTags')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Address</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <div class="position-relative has-icon-left">
                                                                <input wire:model='address' type="text"
                                                                    id="contact-icon" class="form-control"
                                                                    name="contact-icon" placeholder="Address">
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-pin"></i>
                                                                </div>
                                                            </div>
                                                            @error('address')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-secondary"
                                                        data-dismiss="modal">
                                                        <i class="bx bx-x d-block d-sm-none"></i>
                                                        <span class="d-none d-sm-block">Close</span>
                                                    </button>
                                                    @if (!$model)
                                                        <button type="button" wire:click='create'
                                                            class="btn btn-primary ml-1">
                                                            <i class="bx bx-check d-block d-sm-none"></i>
                                                            <span class="d-none d-sm-block">Create</span>
                                                        </button>
                                                    @endif
                                                    @if ($model)
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
                                    <div class="modal fade text-left" id="userDeleteModal" wire:ignore.self
                                        tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary">
                                                    <h5 class="modal-title white" id="myModalLabel160">Delete Lead
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
                                                    @if ($model)
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
