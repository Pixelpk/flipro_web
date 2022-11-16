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
                                <li class="breadcrumb-item"><a href="#">Campaign</a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">{{$campaign->name}}</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section id="basic-horizontal-layouts">
                <div class="d-flex match-height">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <p class="display-4">
                                            Events
                                        </p>
                                    </div>
                                    <div class="col-md-12 mb-1">
                                        <div data-toggle="modal"
                                            data-target="#createEmailModal"
                                            class="swiper-slide bordered bg-primary text-white rounded swiper-shadow py-75 px-2 d-flex align-items-center swiper-slide-active"
                                            id="email-event">
                                            <i class="bx bx-plus-circle mr-50 font-large-1"></i>
                                            <div class="swiper-text">Email
                                                <p class="mb-0 font-small-2 font-weight-normal">Send email to subscriber
                                                </p>
                                                {{-- <i class="bx bx-plus-circle"></i> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-1">
                                        <div data-toggle="modal"
                                            data-target="#createWaitModal"
                                            class="swiper-slide bordered bg-primary text-white rounded swiper-shadow py-75 px-2 d-flex align-items-center swiper-slide-active"
                                            id="wait-event">
                                            <i class="bx bx-plus-circle mr-50 font-large-1"></i>
                                            <div class="swiper-text">Wait
                                                <p class="mb-0 font-small-2 font-weight-normal">Wait before next
                                                    activity</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div data-toggle="modal"
                                            data-target="#createTagModal"
                                            class="swiper-slide bordered bg-primary text-white rounded swiper-shadow py-75 px-2 d-flex align-items-center swiper-slide-active"
                                            id="tag-event">
                                            <i class="bx bx-plus-circle mr-50 font-large-1"></i>
                                            <div class="swiper-text">Add/Remove Tags
                                                <p class="mb-0 font-small-2 font-weight-normal">Add/remove a tag from
                                                    subscriber</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">
                                            {{$campaign->name}}
                                        </h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="row">
                                                <p class="card-text col-md-4">
                                                    <b>Triggers:</b> {{$campaignTypeName}}
                                                </p>
                                                <p class="card-text col-md-4">
                                                    <b>Total leads:</b> {{$partTakerCount}}
                                                </p>
                                                <p class="card-text col-md-4">
                                                    <b>Total completed:</b> {{$this->totalCompleted}}
                                                </p>
                                                <p class="card-text mt-1 col-md-12">
                                                    <b>Campaign Information</b> <br>
                                                    {{$campaignTypeDescription}}
                                                </p>
                                            </div>
                                            <div class="row mt-1">
                                                <div class="col-md-12">
                                                    <b>Progress</b>
                                                    <div style="width: 100%;border: solid 3px #eee; height:30px;">
                                                        <div style="height:24px; background-color: rgb(76, 170, 64); width: {{$partTakerCount == 0 ? '100%' :((100 / $partTakerCount) * $this->totalCompleted)}}%;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-2" id="drop-area">
                                @foreach((collect($events))->sortBy('position') as $key => $event)
                                @if($event['event_type'] == \App\Libs\Campaigns\Events\Email::class
                                )
                                <div class="row">
                                    <div class="col-md-1 p-1">
                                        <div class="avatar mr-1 bg-primary text-white avatar-lg">
                                            <span class="avatar-content">{{$event['position']}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div id="pos-{{$event['position']}}"
                                            class="swiper-slide mt-2 bordered bg-primary text-white rounded swiper-shadow py-75 px-2 d-flex align-items-center swiper-slide-active">
                                            <i class="bx bx-envelope mr-50 font-large-1"></i>
                                            <div class="swiper-text" style="width:80%;">Email
                                                <p class="mb-0 font-small-4 font-weight-normal">
                                                    {{json_decode($event['data'])->subject}}</p>
                                                    <p>
                                                        <span class="badge badge-success badge-md"><b>Passed: {{$event['completed_count']}}</b></span>
                                                        <span class="badge badge-error badge-md"><b>Failed: {{$event['failed_count']}}</b></span>
                                                    </p>
                                            </div>
                                            <div>
                                                <a href="/email/preview?id={{$event['id']}}" target="_blank"><i class="bx bx-show"></i></a>
                                                <i class="bx bx-trash text-danger" wire:click='remove({{$key}})'></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 p-1">
                                        @if($event['position'] != collect($events)->min('position'))
                                        <div class="avatar mr-1 bg-primary text-white avatar-lg"
                                            wire:click="moveUp({{$event['position']}})">
                                            <span class="avatar-content"><i class="bx bx-caret-up"></i></span>
                                        </div>
                                        @endif
                                        @if($event['position'] != collect($events)->max('position'))
                                        <div class="avatar mr-1 bg-primary text-white avatar-lg"
                                            wire:click="moveDown({{$event['position']}})">
                                            <span class="avatar-content"><i class="bx bx-caret-down"></i></span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endif
                                @if($event['event_type'] == \App\Libs\Campaigns\Events\Wait::class)
                                <div class="row">
                                    <div class="col-md-1 p-1">
                                        <div class="avatar mr-1 bg-primary text-white avatar-lg">
                                            <span class="avatar-content">{{$event['position']}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div id="pos-{{$event['position']}}"
                                            class="swiper-slide mt-2 bordered bg-primary text-white rounded swiper-shadow py-75 px-2 d-flex align-items-center swiper-slide-active">
                                            <i class="bx bx-alarm mr-50 font-large-1"></i>
                                            <div class="swiper-text" style="width:85%;">Wait
                                                <p class="mb-0 font-small-4 font-weight-normal">Wait
                                                    {{json_decode($event['data'])->days}} before next
                                                    activity</p>
                                                    <p>
                                                        <span class="badge badge-success badge-md"><b>Passed: {{$event['completed_count']}}</b></span>
                                                        <span class="badge badge-error badge-md"><b>Failed: {{$event['failed_count']}}</b></span>
                                                    </p>
                                            </div>
                                            <div>
                                                <i class="bx bx-trash text-danger" wire:click='remove({{$key}})'></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 p-1">
                                        @if($event['position'] != collect($events)->min('position'))
                                        <div class="avatar mr-1 bg-primary text-white avatar-lg"
                                            wire:click="moveUp({{$event['position']}})">
                                            <span class="avatar-content"><i class="bx bx-caret-up"></i></span>
                                        </div>
                                        @endif
                                        @if($event['position'] != collect($events)->max('position'))
                                        <div class="avatar mr-1 bg-primary text-white avatar-lg"
                                            wire:click="moveDown({{$event['position']}})">
                                            <span class="avatar-content"><i class="bx bx-caret-down"></i></span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endif
                                @if($event['event_type'] == \App\Libs\Campaigns\Events\Tag::class)
                                <div class="row">
                                    <div class="col-md-1 p-1">
                                        <div class="avatar mr-1 bg-primary text-white avatar-lg">
                                            <span class="avatar-content">{{$event['position']}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div id="pos-{{$event['position']}}"
                                            class="swiper-slide mt-2 bordered bg-primary text-white rounded swiper-shadow py-75 px-2 d-flex align-items-center swiper-slide-active">
                                            <i class="bx bx-purchase-tag mr-50 font-large-1"></i>
                                            <div class="swiper-text" style="width:85%;">Add/Remove Tags
                                                <p class="mb-0 font-small-4 font-weight-normal">
                                                    @if(json_decode($event['data'])->addraw)
                                                    <b>Add:</b> {{json_decode($event['data'])->addraw}}
                                                    <br>
                                                    @endif
                                                    @if(json_decode($event['data'])->removeraw)
                                                    <b>Remove: </b>{{json_decode($event['data'])->removeraw}}
                                                </p>
                                                @endif
                                                <p>
                                                    <span class="badge badge-success badge-md"><b>Passed: {{$event['completed_count']}}</b></span>
                                                    <span class="badge badge-error badge-md"><b>Failed: {{$event['failed_count']}}</b></span>
                                                </p>
                                            </div>
                                            <div>
                                                <i class="bx bx-trash text-danger" wire:click='remove({{$key}})'></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 p-1">
                                        @if($event['position'] != collect($events)->min('position'))
                                        <div class="avatar mr-1 bg-primary text-white avatar-lg"
                                            wire:click="moveUp({{$event['position']}})">
                                            <span class="avatar-content"><i class="bx bx-caret-up"></i></span>
                                        </div>
                                        @endif
                                        @if($event['position'] != collect($events)->max('position'))
                                        <div class="avatar mr-1 bg-primary text-white avatar-lg"
                                            wire:click="moveDown({{$event['position']}})">
                                            <span class="avatar-content"><i class="bx bx-caret-down"></i></span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    {{-- Email event modal start --}}
    {{-- <div class="modal fade text-left" id="createEmailModal" wire:ignore.self tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel160" aria-hidden="true">
        <div class="modal-dialog modal-full modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title white" id="myModalLabel160">Create/Update Email Event
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-1">
                            <label>Subject</label>
                        </div>
                        <div class="col-md-11 form-group ">
                            <div class="position-relative has-icon-left">
                                <input wire:model='emailEvent.subject' type="text" id="fsubject-icon"
                                    class="form-control" name="fsubject-icon" placeholder="Subject">
                                <div class="form-control-position">
                                    <i class="bx bx-text"></i>
                                </div>
                            </div>
                            @error('emailEvent.subject') <span class="text-danger">{{ $message
                                }}</span> @enderror
                        </div>
                        <div class="col-md-8">
                            <label>Body</label>
                        </div>
                        <div class="col-md-8">
                            <label>Preview</label>
                        </div>
                        <div class="col-md-8 form-group" wire:ignore>
                            <div class="position-relative has-icon-left">
                                <div id="editor" style="height:500px !important" x-data x-init="
                                ClassicEditor.create(document.getElementById('editor'), {
                                    htmlSupport: {
                                        allow: [
                                            {
                                                name: /.*/,
                                                attributes: true,
                                                classes: true,
                                                styles: true
                                            }
                                        ]
                                    }
                                })
                                .then( function(editor){
                                    editor.model.document.on('change:data', () => {
                                    Livewire.emit('emailBodyChanged', editor.getData())
                                    })
                                })
                                .catch( error => {
                                    console.error( error );
                                } );
                            " wire:key="editor" x-ref="editor" wire:model.debounce.9999999ms="content">

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            {!!$emailEvent['body'] ?? ''!!}
                        </div>
                        <div class="col-md-12">
                            <h3>Shortcodes</h3>
                            <ul>
                                <li>Name: {name}</li>
                                <li>Email: {email}</li>
                                <li>Phone: {phone}</li>
                            </ul>
                        </div>
                        <div class="col-md-12 form-group">
                            @error('emailEvent.body') <span class="text-danger">{{ $message
                                }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="button" wire:click='addEmailEvent' class="btn btn-primary ml-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Add Email</span>
                    </button>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="modal fade text-left" id="createEmailModal" wire:ignore.self tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel160" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title white" id="myModalLabel160">Create/Update Email Event
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group ">
                            <label for="">Choose previous emails</label>
                            <select wire:model='templateId' class="form-control">
                                <option value="">Select Email</option>
                                @foreach($emailTemplates as $template)
                                <option value="{{$template->id}}">{{$template->name}}</option>
                                @endforeach
                            </select>
                            @if ($templateId)
                                <p class="text-right mt-1"><a target="_blank" href="/email/design?id={{$templateId}}">Edit/Preview</a></p>
                            @endif
                            <p class="text-center mt-2">
                                <b>Or create new</b>
                            </p>
                            <label for="">Subject</label>
                            <input wire:model='subject' type="text" class="form-control">
                            @error('subject') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-primary" wire:click='createEmail'>Create Email</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="button" wire:click='addEmailEvent' class="btn btn-primary ml-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Add Email</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- Email event modal end --}}
    {{-- Wait event modal start --}}
    <div class="modal fade text-left" id="createWaitModal" wire:ignore.self tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel160" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title white" id="myModalLabel160">Create/Update Email Event
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Days</label>
                        </div>
                        <div class="col-md-8 form-group ">
                            <div class="position-relative has-icon-left">
                                <input wire:model='waitEvent.days' type="text" id="fsubject-icon" class="form-control"
                                    name="fsubject-icon" placeholder="Days">
                                <div class="form-control-position">
                                    <i class="bx bx-alarm"></i>
                                </div>
                            </div>
                            @error('waitEvent.days') <span class="text-danger">{{ $message
                                }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="button" wire:click='addWaitEvent' class="btn btn-primary ml-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Add Wait Time</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- Wait event modal end --}}
    {{-- Label event modal start --}}
    <div class="modal fade text-left" id="createTagModal" wire:ignore.self tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel160" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title white" id="myModalLabel160">Add/Remove Tags
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Tags to Add</label>
                        </div>
                        <div class="col-md-8 form-group ">
                            <div class="position-relative has-icon-left">
                                <select multiple wire:model='tagEvent.add' class="form-control">
                                    @foreach ($labels as $label)
                                    <option value="{{$label->id}}">{{$label->name}}</option>
                                    @endforeach
                                </select>
                                <div class="form-control-position">
                                    <i class="bx bx-tag"></i>
                                </div>
                            </div>
                            @error('tags') <span class="text-danger">{{ $message
                            }}</span> @enderror
                        </div>
                        <div class="col-md-4">
                            <label>Tags to Remove</label>
                        </div>
                        <div class="col-md-8 form-group ">
                            <div class="position-relative has-icon-left">
                                <select multiple wire:model='tagEvent.remove' class="form-control">
                                    @foreach ($labels as $label)
                                    <option value="{{$label->id}}">{{$label->name}}</option>
                                    @endforeach
                                </select>
                                <div class="form-control-position">
                                    <i class="bx bx-tag"></i>
                                </div>
                            </div>
                            @error('tags') <span class="text-danger">{{ $message
                                }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="button" wire:click='addTagEvent' class="btn btn-primary ml-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Add Tag Event</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- Label event modal end --}}
    {{-- Email show modal start --}}
    <div class="modal fade text-left" id="showEmailModal" wire:ignore.self tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel160" aria-hidden="true">
        <div class="modal-dialog modal-full modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title white" id="myModalLabel160">Add/Remove Tags
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            {!!$emailContent!!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- Email show modal end --}}

    <style>
        .ck-editor__editable_inline {
            min-height: 400px;
        }
    </style>
</div>