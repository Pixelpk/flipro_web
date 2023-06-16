<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- login page start -->
            <section id="auth-login" class="row flexbox-container">
                <div class="col-xl-8 col-11">
                    <div class="card bg-authentication mb-0">
                        <div class="row m-0">
                            <!-- left section-login -->
                            <div class="col-md-6 col-12 px-0">
                                <div class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
                                    <!-- <div class="card-header pb-1">
                                        <div class="card-title">
                                            <h4 class="text-center mb-2">Welcome Back!</h4>
                                        </div>
                                    </div> -->
                                    <div class="card-content">
                                        <div class="card-body">
                                            @if (session()->has('message'))
                                            <div class="alert alert-danger">
                                                {{ session('message') }}
                                            </div>
                                            @endif
                                            <div class="form-group mb-50">
                                                <label class="text-bold-600" for="exampleInputEmail1">Email address</label>
                                                <input wire:model='email' type="email" class="form-control" id="exampleInputEmail1" placeholder="Email address"></div>
                                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                            <div class="form-group">
                                                <label class="text-bold-600" for="exampleInputPassword1">Password</label>
                                                <input wire:model='password' type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="form-group d-flex flex-md-row flex-column justify-content-between align-items-center">
                                                <div class="text-left">
                                                    <div class="checkbox checkbox-sm">
                                                        <input wire:model="remember" type="checkbox" class="form-check-input" id="exampleCheck1">
                                                        <label class="checkboxsmall" for="exampleCheck1"><small>Remember Me
                                                                </small></label>
                                                    </div>
                                                </div>
                                                <div class="text-right"><a href="{{ route('forgot.password') }}" class="card-link"><small>Forgot Password?</small></a></div>
                                            </div>
                                            <button wire:target='login'  wire:loading.attr="disabled" type="submit" wire:click='login' class="btn btn-primary glow w-100 position-relative">Login<i id="icon-arrow" class="bx bx-loader bx-spin" wire:loading wire:target='login'></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- right section image -->
                            <div class="col-md-6 d-md-block d-none text-center p-3" style="background-color: #165C98;">
                                <div class="card-content d-md-block d-none text-center align-self-center p-3">
                                    <img class="img-fluid" src="/app-assets/images/pages/login.png" alt="branding logo">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- login page ends -->

        </div>
    </div>
</div>