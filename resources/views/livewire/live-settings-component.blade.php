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
                                <li class="breadcrumb-item"><a href="#">Settings</a>
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
                                <h4 class="card-title">Incomming Mail Server Settings</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2 mt-1">
                                            <label for="">Name</label>
                                        </div>
                                        <div class="col-md-4 mt-1">
                                            <input wire:model='userSmtps.sender_name' type="text" class="form-control" placeholder="e.g. name@example.com">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 mt-1">
                                            <label for="">Username</label>
                                        </div>
                                        <div class="col-md-4 mt-1">
                                            <input wire:model='userSmtps.username' type="text" class="form-control" placeholder="e.g. name@example.com">
                                        </div>
                                        <div class="col-md-2 mt-1">
                                            <label for="">Password</label>
                                        </div>
                                        <div class="col-md-4 mt-1">
                                            <input wire:model='userSmtps.password' type="password" class="form-control">
                                        </div>
                                        <div class="col-md-2 mt-1">
                                            <label for="">Incomming Server Address</label>
                                        </div>
                                        <div class="col-md-4 mt-1">
                                            <input wire:model='userSmtps.incomming_server' type="text" class="form-control" placeholder="e.g. mail.example.com">
                                        </div>
                                        <div class="col-md-2 mt-1">
                                            <label for="">Incomming Port</label>
                                        </div>
                                        <div class="col-md-4 mt-1">
                                            <input wire:model='userSmtps.incomming_port' type="text" class="form-control" placeholder="e.g. 110">
                                        </div>
                                        <div class="col-md-2 mt-1">
                                            <label for="">Authentication Type</label>
                                        </div>
                                        <div class="col-md-4 mt-1">
                                            <select wire:model='userSmtps.authentication_type' class="form-control">
                                                <option value="imap">Imap</option>
                                                <option value="pop3">POP3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 mt-1">
                                            <label for="">Outgoing Server Address</label>
                                        </div>
                                        <div class="col-md-4 mt-1">
                                            <input wire:model='userSmtps.outgoing_server' type="text" class="form-control" placeholder="e.g. mail.example.com">
                                        </div>
                                        <div class="col-md-2 mt-1">
                                            <label for="">Outgoing Port</label>
                                        </div>
                                        <div class="col-md-4 mt-1">
                                            <input wire:model='userSmtps.outgoing_port' type="text" class="form-control" placeholder="e.g. 25">
                                        </div>
                                        <div class="col-md-2 mt-1">
                                            <label for="">Security</label>
                                        </div>
                                        <div class="col-md-4 mt-1">
                                            <select wire:model='userSmtps.auth' name="" id="" class="form-control">
                                                <option value="none">None</option>
                                                <option value="ssl">SSL</option>
                                                <option value="tls">TLS</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12 text-right">
                                            <button wire:click='saveEmailSettings' class="btn btn-primary">Save</button>
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