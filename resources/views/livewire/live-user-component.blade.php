<div class="app-content content">
    @php
        if($type == 'home-owner') {
            $type = 'home-owner';
        }
    @endphp
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <?php
            $text = ($type == 'evaluator') ? 'Valuer' : str_replace('-', ' ', ($type == 'franchise') ? 'Partner' : $type);
            if($type == 'builder')
            $text  = 'Agents/Trades'
            ?>
            <div class="content-header-left col-12 mb-2 mt-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h5 class="content-header-title float-left pr-1 mb-0">Home</h5>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item"><a href="/"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Users</a>
                                </li>
                                <li class="breadcrumb-item active"><a href="#">{{$text}}</a>
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
                               
                                <h4 class="card-title">{{$text}}s</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <button type="button" wire:click='openModal' class="btn btn-outline-primary mb-3" data-toggle="modal" data-target="#userCreateModal">
                                        <i class="bx bx-plus"></i> Add {{$text == 'franchise' ? 'Partner' : ucfirst($text)}}
                                    </button>
                                    @livewire('tables.users-table', ['params' => [
                                        'usertype' => $type
                                    ]])
                                    <!--primary theme Modal -->
                                    <div class="modal fade text-left" id="userCreateModal" wire:ignore.self tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary">
                                                    <h5 class="modal-title white" id="myModalLabel160">{{ $text }}</h5>
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
                                                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Email</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <div class="position-relative has-icon-left">
                                                                <input autocomplete="new-email"wire:model='email' type="email" id="email-icon" class="form-control"
                                                                    name="email-id-icon" placeholder="Email">
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-mail-send"></i>
                                                                </div>
                                                            </div>
                                                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Phone</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <div class="position-relative">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <select style="width: 99px;" wire:model='phone_code' class="form-control input-group-text">
                                                                            <option value="">Country</option>
                                                                            @foreach(config('countrycode') as $index => $item)
                                                                            <option value="{{ $index }}">{{ $item }}
                                                                            </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <input id="phone" onkeyup="formatPhoneNumber(this)" type="text" class="form-control" placeholder="Phone" aria-describedby="basic-addon1">
                                                                </div>
                                                            </div>
                                                            @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                                                            @error('phone_code') <span class="text-danger">{{ $message }}</span> @enderror
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
                                                            @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Password</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <div class="position-relative has-icon-left">
                                                                <input autocomplete="new-password" wire:model='password' type="password" id="pass-icon" class="form-control"
                                                                    name="contact-icon" placeholder="Password">
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-lock"></i>
                                                                </div>
                                                            </div>
                                                            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<script>
    window.addEventListener('phone-updated', event => {
       
        document.getElementById("phone").value =  event.detail.newPhone.replace(/(\d{3})(\d{3})(\d{3})/, '$1 $2 $3'); 
    })
    function formatPhoneNumber(input) {
        // Remove all non-digit characters from the input value
        var phoneNumber = input.value.replace(/\D/g, '');

        // Check if the phone number exceeds the limit
        if (phoneNumber.length > 9) {
            // Truncate the phone number to the limit
            phoneNumber = phoneNumber.substr(0, 10);
        }

        // Format the phone number as per the Australian format
        var formattedPhoneNumber = phoneNumber.replace(/(\d{3})(\d{3})(\d{3})/, '$1 $2 $3');

        // Set the formatted phone number back to the input value
        input.value = formattedPhoneNumber;
        @this.set('phone', formattedPhoneNumber);
    }
</script>