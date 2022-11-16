<div class="collapse-title media">
    <div class="media-body mt-25">
        <span class="text-primary">{{$name}}
        </span>
        <span class="d-sm-inline d-none">
            &lt;{{$email ?? ''}}&gt;
        </span>
        @if (!$lead && $email)
        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#userCreateModal" >Add To Leads</button>
        @endif

    </div>
    <div class="modal fade text-left" id="userCreateModal" wire:ignore.self tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel160" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title white" id="myModalLabel160">Add/Update Lead
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                                <input wire:model='name' type="text" id="fname-icon" class="form-control"
                                    name="fname-icon" placeholder="Name">
                                <div class="form-control-position">
                                    <i class="bx bx-user"></i>
                                </div>
                            </div>
                            @error('name') <span class="text-danger">{{ $message
                                }}</span> @enderror
                        </div>
                        <div class="col-md-4">
                            <label>Email</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <div class="position-relative has-icon-left">
                                <input wire:model='email' type="email" id="email-icon" class="form-control"
                                    name="email-id-icon" placeholder="Email">
                                <div class="form-control-position">
                                    <i class="bx bx-mail-send"></i>
                                </div>
                            </div>
                            @error('email') <span class="text-danger">{{ $message
                                }}</span> @enderror
                        </div>
                        <div class="col-md-4">
                            <label>Phone</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <div class="position-relative">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <select wire:model='phone_code' class="form-control input-group-text">
                                            <option value="">Country</option>
                                            <option value="61">+61 (Australia)
                                            </option>
                                        </select>
                                    </div>
                                    <input wire:model='phone' type="number" class="form-control" placeholder="Phone"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                            @error('phone') <span class="text-danger">{{ $message
                                }}</span> @enderror
                            @error('phone') <span class="text-danger">{{
                                $message }}</span> @enderror
                        </div>
                        <div class="col-md-4">
                            <label>Segments</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <div class="position-relative">
                                <select wire:model='selectedSegments' class="form-control" multiple>
                                    @foreach ($segments as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('selectedSegments') <span class="text-danger">{{ $message
                                }}</span> @enderror
                            @error('selectedSegments') <span class="text-danger">{{
                                $message }}</span> @enderror
                        </div>
                        <div class="col-md-4">
                            <label>Tags</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <div class="position-relative">
                                <select wire:model='selectedTags' class="form-control" multiple>
                                    @foreach ($tags as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('selectedTags') <span class="text-danger">{{ $message
                                }}</span> @enderror
                            @error('selectedTags') <span class="text-danger">{{
                                $message }}</span> @enderror
                        </div>
                        <div class="col-md-4">
                            <label>Address</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <div class="position-relative has-icon-left">
                                <input wire:model='address' type="text" id="contact-icon" class="form-control"
                                    name="contact-icon" placeholder="Address">
                                <div class="form-control-position">
                                    <i class="bx bx-pin"></i>
                                </div>
                            </div>
                            @error('address') <span class="text-danger">{{ $message
                                }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    @if(!$model)
                    <button type="button" wire:click='create' class="btn btn-primary ml-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Create</span>
                    </button>
                    @endif
                    @if($model)
                    <button type="button" wire:click='update' class="btn btn-primary ml-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Update</span>
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <style>
        .modal-backdrop {
            display: none !important;
        }
    </style>
</div>