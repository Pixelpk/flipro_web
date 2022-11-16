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
                                <li class="breadcrumb-item"><a href="#">Contracts</a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Create</a>
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
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Project Information</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    @if(!$project)
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="">Project Title</label>
                                            <input type="text" wire:model='project_title' class="form-control">
                                            @error('project_title') <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="">Address:</label>
                                            <input type="text" wire:model='project_address' class="form-control">
                                            @error('project_address') <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    @else
                                    <div class="row">
                                        <div class="col-md-4">
                                            <b>Project Title</b> {{$project->title ?? ''}}
                                        </div>
                                        <div class="col-md-4">
                                            <b>Address</b> {{$project->project_address ?? ''}}
                                        </div>
                                    </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Contract Details</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label for="">Contract Name</label>
                                            <input type="text" wire:model='title' class="form-control">
                                            @error('title') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="row" wire:ignore>
                                        <div class="col-md-12 form-group">
                                            <label for="">Content</label>
                                            <div class="editor" id="editor" x-data x-init="
                                            ClassicEditor.create(document.getElementById('editor'))
                                            .then( function(editor){
                                                
                                                editor.model.document.on('change:data', () => {
                                                    @this.set('body', editor.getData());
                                                    @this.emit('bodyChanged', editor.getData());
                                                })
                                            })
                                            .catch( error => {
                                                console.error( error );
                                            } );
                                            "></div>
                                        </div>
                                        {{$body}}
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            @error('body') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <b>Signatory Santax:</b> [sig:name,name@mailservice.com] <br>
                                            @error('signatories') <span class="text-danger">{{$message}}</span>
                                            @enderror
                                            @error('signatories.0') <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <ul>
                                                @if (isset($signatories[0]))
                                                @foreach ($signatories[0] as $key => $item)
                                                @php
                                                $item = explode(',', str_replace('[sig:', '', str_replace(']', '',
                                                $item)))
                                                @endphp
                                                <li class="mb-1">
                                                    <h4>Signatory {{$key + 1}}</h4>
                                                    <b>Name:</b>{{$item[0]}} <br>
                                                    <b>Email:</b>{{$item[1]}}
                                                </li>
                                                @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            {{-- <button class="btn btn-primary" wire:click='create'>Create</button> --}}
                                            <button wire:loading.attr="disabled" wire:click='create'
                                                class="btn btn-primary" type="button">
                                                <span wire:loading wire:target="create"
                                                    class="spinner-grow spinner-grow-sm" role="status"
                                                    aria-hidden="true"></span>
                                                Create
                                            </button>
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
