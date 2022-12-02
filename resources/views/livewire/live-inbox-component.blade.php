<div class="app-content content">
    <div class="content-area-wrapper">
        <div class="sidebar-left">
            <div class="sidebar">
                <div class="sidebar-content email-app-sidebar d-flex">
                    <!-- sidebar close icon -->
                    <span class="sidebar-close-icon">
                        <i class="bx bx-x"></i>
                    </span>
                    <!-- sidebar close icon -->
                    <div class="email-app-menu">
                        <div class="form-group form-group-compose">
                            <!-- compose button  -->
                            <button type="button" class="btn btn-primary btn-block my-2 compose-btn">
                                <i class="bx bx-plus"></i>
                                Compose
                            </button>
                        </div>
                        <div class="sidebar-menu-list">
                            <!-- sidebar menu  -->
                            <div class="list-group list-group-messages">
                                <a href="#" wire:click="setView('inbox')" wire:ignore
                                    class="list-group-item pt-0 active" id="inbox-menu">
                                    <div class="fonticon-wrap d-inline mr-25">
                                        <i class="livicon-evo"
                                            data-options="name: envelope-put.svg; size: 24px; style: lines; strokeColor:#5A8DEE; eventOn:grandparent; duration:0.85;">
                                        </i>
                                    </div>
                                    Inbox
                                </a>
                                <a href="#" wire:click="setView('sent')" wire:ignore class="list-group-item">
                                    <div class="fonticon-wrap d-inline mr-25">
                                        <i class="livicon-evo"
                                            data-options="name: paper-plane.svg; size: 24px; style: lines; strokeColor:#475f7b; eventOn:grandparent; duration:0.85;">
                                        </i>
                                    </div>
                                    Sent
                                </a>
                                <a href="#" wire:click="setView('starred')" wire:ignore class="list-group-item">
                                    <div class="fonticon-wrap d-inline mr-25">
                                        <i class="livicon-evo"
                                            data-options="name: star.svg; size: 24px; style: lines; strokeColor:#475f7b; eventOn:grandparent; duration:0.85;">
                                        </i>
                                    </div>
                                    Starred
                                </a>
                                <a href="#" wire:click="setView('trash')" wire:ignore class="list-group-item">
                                    <div class="fonticon-wrap d-inline mr-25">
                                        <i class="livicon-evo"
                                            data-options="name: trash.svg; size: 24px; style: lines; strokeColor:#475f7b; eventOn:grandparent; duration:0.85;">
                                        </i>
                                    </div>
                                    Trash
                                </a>
                            </div>
                            <!-- sidebar menu  end-->
                        </div>
                    </div>
                </div>
                <!-- User new mail right area -->
                <div class="compose-new-mail-sidebar" wire:ignore>
                    <div class="card shadow-none quill-wrapper p-0">
                        <div class="card-header">
                            <h3 class="card-title" id="emailCompose">New Message</h3>
                            <button type="button" class="close close-icon">
                                <i class="bx bx-x"></i>
                            </button>
                        </div>
                        <!-- form start -->
                        <livewire:widget.live-send-email-widget />
                        <!-- form start end-->
                    </div>
                </div>
                <!--/ User Chat profile right area -->
            </div>
        </div>
        <div class="content-right">
            <div class="content-overlay"></div>
            <div class="content-wrapper">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <!-- email app overlay -->
                    <div class="app-content-overlay"></div>
                    <div class="email-app-area">
                        <!-- Email list Area -->
                        <div class="email-app-list-wrapper">
                            <div class="email-app-list">
                                <div class="email-action">
                                    <!-- action left start here -->
                                    <div class="action-left d-flex align-items-center">
                                        <!-- select All checkbox -->
                                        {{-- <div class="checkbox checkbox-shadow checkbox-sm selectAll mr-50">
                                            <input type="checkbox" id="checkboxsmall">
                                            <label for="checkboxsmall"></label>
                                        </div> --}}
                                        <!-- delete unread dropdown -->
                                        <ul class="list-inline m-0 d-flex">
                                            <li class="list-inline-item mail-delete">
                                                <button type="button" class="btn btn-icon action-icon" wire:ignore
                                                    wire:click='removeBulk()'>
                                                    <span class="fonticon-wrap">
                                                        <i class="livicon-evo"
                                                            data-options="name: trash.svg; size: 24px; style: lines; strokeColor:#475f7b; eventOn:grandparent; duration:0.85;">
                                                        </i>
                                                    </span>
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- action left end here -->

                                    <!-- action right start here -->
                                    <div
                                        class="action-right d-flex flex-grow-1 align-items-center justify-content-around">
                                        <!-- search bar  -->
                                        <div class="email-fixed-search flex-grow-1">
                                            <div class="sidebar-toggle d-block d-lg-none">
                                                <i class="bx bx-menu"></i>
                                            </div>
                                            <fieldset class="form-group position-relative has-icon-left m-0">
                                                <input type="text" class="form-control" id="email-search"
                                                    placeholder="Search email" wire:model='searchTerm'>
                                                <div class="form-control-position">
                                                    <i class="bx bx-search"></i>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <!-- pagination and page count -->
                                        {{-- <span class="d-none d-sm-block">1-10 of 653</span>
                                        <button class="btn btn-icon email-pagination-prev d-none d-sm-block">
                                            <i class="bx bx-chevron-left"></i>
                                        </button>
                                        <button class="btn btn-icon email-pagination-next d-none d-sm-block">
                                            <i class="bx bx-chevron-right"></i>
                                        </button> --}}
                                    </div>
                                </div>
                                <!-- / action right -->

                                <!-- email user list start -->
                                <div class="email-user-list list-group" wire:ignore.self>
                                    @if ($currentView == 'inbox')
                                    <ul class="users-list-wrapper media-list">
                                        @foreach ($this->inbox as $message)
                                        <li class="media
                                        @if($message->read && $message->route == 'incomming')
                                            {{' mail-read'}}
                                        @endif
                                        ">
                                            <div class="user-action">
                                                <div class="checkbox-con mr-25">
                                                    <div class="checkbox checkbox-shadow checkbox-sm">
                                                        <input wire:click='selection({{$message}})' type="checkbox"
                                                            id="checkboxsmall3{{$message->id}}">
                                                        <label for="checkboxsmall3{{$message->id}}"></label>
                                                    </div>
                                                </div>
                                                @if ($message->starred)
                                                <span class="favorite warning">
                                                    <i class="bx bxs-star" wire:click='star({{$message}})'></i>
                                                </span>
                                                @else
                                                <span class="favorite">
                                                    <i class="bx bx-star" wire:click='star({{$message}})'></i>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="media-body" wire:click='open({{$message}})'>
                                                <div class="user-details">
                                                    <div class="mail-items">
                                                        <span
                                                            class="list-group-item-text text-truncate">{{$message->subject}}</span>
                                                    </div>
                                                    <div class="mail-meta-item">
                                                        <span class="float-right">
                                                            <span class="mail-date">{{date('d, M, Y h:i a',
                                                                strtotime($message->email_date)) ?? ''}}</span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="mail-message">
                                                    <p class="list-group-item-text mb-0 truncate">
                                                        {{strip_tags(substr($message->message, 0, 200))}} ...
                                                    </p>
                                                    <div class="mail-meta-item">
                                                        <span class="float-right d-flex align-items-center">
                                                            <i class="bx bx-paperclip mr-50"></i>
                                                            <span class="bullet bullet-success bullet-sm"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                    <div class="row">
                                        <div class="col-md-12 m-2 text-center">
                                            {{$this->inbox->links()}}
                                        </div>
                                    </div>
                                    @endif
                                    @if ($currentView == 'starred')
                                    <ul class="users-list-wrapper media-list">
                                        @foreach ($this->starred as $message)
                                        <li class="media
                                        @if($message->read && $message->route == 'incomming')
                                            {{' mail-read'}}
                                        @endif
                                        ">
                                            <div class="user-action">
                                                <div class="checkbox-con mr-25">
                                                    <div class="checkbox checkbox-shadow checkbox-sm">
                                                        <input wire:click='selection({{$message}})' type="checkbox" id="checkboxsmall3{{$message->id}}">
                                                        <label for="checkboxsmall3{{$message->id}}"></label>
                                                    </div>
                                                </div>
                                                @if ($message->starred)
                                                <span class="favorite warning">
                                                    <i class="bx bxs-star" wire:click='star({{$message}})'></i>
                                                </span>
                                                @else
                                                <span class="favorite">
                                                    <i class="bx bx-star" wire:click='star({{$message}})'></i>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="media-body" wire:click='open({{$message}})'>
                                                <div class="user-details">
                                                    <div class="mail-items">
                                                        <span
                                                            class="list-group-item-text text-truncate">{{$message->subject}}</span>
                                                    </div>
                                                    <div class="mail-meta-item">
                                                        <span class="float-right">
                                                            <span class="mail-date">{{date('d, M, Y h:i a',
                                                                strtotime($message->email_date)) ?? ''}}</span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="mail-message">
                                                    <p class="list-group-item-text mb-0 truncate">
                                                        {{strip_tags(substr($message->message, 0, 200))}} ...
                                                    </p>
                                                    <div class="mail-meta-item">
                                                        <span class="float-right d-flex align-items-center">
                                                            <i class="bx bx-paperclip mr-50"></i>
                                                            <span class="bullet bullet-success bullet-sm"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                    <div class="row">
                                        <div class="col-md-12 m-2 text-center">
                                            {{$this->starred->links()}}
                                        </div>
                                    </div>
                                    @endif
                                    @if ($currentView == 'sent')
                                    <ul class="users-list-wrapper media-list">
                                        @foreach ($this->sent as $message)
                                        <li class="media mail-read">
                                            <div class="user-action">
                                                <div class="checkbox-con mr-25">
                                                    <div class="checkbox checkbox-shadow checkbox-sm">
                                                        <input type="checkbox" wire:click='selection({{$message}})' id="checkboxsmall3{{$message->id}}">
                                                        <label for="checkboxsmall3{{$message->id}}"></label>
                                                    </div>
                                                </div>
                                                @if ($message->starred)
                                                <span class="favorite warning">
                                                    <i class="bx bxs-star" wire:click='star({{$message}})'></i>
                                                </span>
                                                @else
                                                <span class="favorite">
                                                    <i class="bx bx-star" wire:click='star({{$message}})'></i>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="media-body" wire:click='open({{$message}})'>
                                                <div class="user-details">
                                                    <div class="mail-items">
                                                        <span
                                                            class="list-group-item-text text-truncate">{{$message->subject}}</span>
                                                    </div>
                                                    <div class="mail-meta-item">
                                                        <span class="float-right">
                                                            <span class="mail-date">{{date('d, M, Y h:i a',
                                                                strtotime($message->email_date)) ?? ''}}</span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="mail-message">
                                                    <p class="list-group-item-text mb-0 truncate">
                                                        {{strip_tags(substr($message->message, 0, 200))}} ...
                                                    </p>
                                                    <div class="mail-meta-item">
                                                        <span class="float-right d-flex align-items-center">
                                                            <i class="bx bx-paperclip mr-50"></i>
                                                            <span class="bullet bullet-success bullet-sm"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                    @if ($currentView == 'trash')
                                    <ul class="users-list-wrapper media-list">
                                        @foreach ($this->trashed as $message)
                                        <li class="media
                                        @if($message->read && $message->route == 'incomming')
                                            {{' mail-read'}}
                                        @endif
                                        ">
                                            <div class="user-action">
                                                <div class="checkbox-con mr-25">
                                                    <div class="checkbox checkbox-shadow checkbox-sm">
                                                        <input wire:click='selection({{$message}})' type="checkbox" id="checkboxsmall3{{$message->id}}">
                                                        <label for="checkboxsmall3{{$message->id}}"></label>
                                                    </div>
                                                </div>
                                                @if ($message->starred)
                                                <span class="favorite warning">
                                                    <i class="bx bxs-star" wire:click='star({{$message}})'></i>
                                                </span>
                                                @else
                                                <span class="favorite">
                                                    <i class="bx bx-star" wire:click='star({{$message}})'></i>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="media-body" wire:click='open({{$message}})'>
                                                <div class="user-details">
                                                    <div class="mail-items">
                                                        <span
                                                            class="list-group-item-text text-truncate">{{$message->subject}}</span>
                                                    </div>
                                                    <div class="mail-meta-item">
                                                        <span class="float-right">
                                                            <span class="mail-date">{{date('d, M, Y h:i a',
                                                                strtotime($message->email_date)) ?? ''}}</span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="mail-message">
                                                    <p class="list-group-item-text mb-0 truncate">
                                                        {{strip_tags(substr($message->message, 0, 200))}} ...
                                                    </p>
                                                    <div class="mail-meta-item">
                                                        <span class="float-right d-flex align-items-center">
                                                            <i class="bx bx-paperclip mr-50"></i>
                                                            <span class="bullet bullet-success bullet-sm"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                    <!-- email user list end -->

                                    <!-- no result when nothing to show on list -->
                                    <div class="no-results">
                                        <i class="bx bx-error-circle font-large-2"></i>
                                        <h5>No Items Found</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ Email list Area -->
                        <!-- Detailed Email View -->
                        <div class="email-app-details {{$show}}">
                            <!-- email detail view header -->
                            <div class="email-detail-header">
                                <div class="email-header-left d-flex align-items-center mb-1">
                                    <span class="go-back mr-50" wire:ignore>
                                        <span class="fonticon-wrap d-inline">
                                            <i class="livicon-evo" wire:ignore wire:click="$set('show', '')"
                                                data-options="name: chevron-left.svg; size: 32px; style: lines; strokeColor:#475f7b; eventOn:grandparent; duration:0.85;">
                                            </i>
                                        </span>
                                    </span>
                                    <h5 class="email-detail-title font-weight-normal mb-0">
                                        {{$openMessage['subject'] ?? ''}}
                                    </h5>
                                </div>
                                <div class="email-header-right mb-1 ml-2 pl-1">
                                    <ul class="list-inline m-0">
                                        <li class="list-inline-item">
                                            <button class="btn btn-icon action-icon" wire:click='removeEmail({{$openMessage["id"]?? 0}})'>
                                                <span class="fonticon-wrap" wire:ignore>
                                                    <i class="livicon-evo"
                                                        data-options="name: trash.svg; size: 24px; style: lines; strokeColor:#475f7b; eventOn:grandparent; duration:0.85;">
                                                    </i>
                                                </span>
                                            </button>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                            <!-- email detail view header end-->
                            <div class="email-scroll-area" style="overflow: scroll !important">
                                <!-- email details  -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="collapsible email-detail-head">
                                            <div class="card collapse-header open" role="tablist">
                                                <div id="headingCollapse7"
                                                    class="card-header d-flex justify-content-between align-items-center"
                                                    data-toggle="collapse" role="tab" aria-expanded="false"
                                                    aria-controls="collapse7">

                                                    @livewire('widget.live-email-sender-media-widget', [
                                                    'user' => $user,
                                                    'email' => $openMessage['from'] ?? '',
                                                    'message' => $openMessage
                                                    ],
                                                    key($openMessage['id'] ?? uniqid()))


                                                    <div class="information d-sm-flex d-none align-items-center">
                                                        <small class="text-muted mr-50">{{date('d, M, Y h:i a',
                                                            strtotime($openMessage['email_date'] ?? '')) ?? ''}}</small>
                                                            @if ($openMessage['starred'] ?? false)
                                                                <span class="favorite warning">
                                                                    <i class="bx bxs-star mr-25"></i>
                                                                </span>
                                                                @else
                                                                <span class="favorite">
                                                                    <i class="bx bxs-star mr-25"></i>
                                                                </span>
                                                            @endif
                                                        <div class="dropdown">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="collapse7" role="tabpanel" aria-labelledby="headingCollapse7"
                                                    class="collapse show">
                                                    <div class="card-content">
                                                        <div class="card-body py-1">
                                                            {!!$openMessage['message'] ?? ''!!}
                                                        </div>
                                                        <div class="card-footer pt-0 border-top">
                                                            <label class="sidebar-label">Attached Files</label>
                                                            <ul class="list-unstyled mb-0">
                                                                @php
                                                                $attachments = $openMessage['attachment_files'] ?? [];
                                                                @endphp
                                                                @foreach ($attachments as $key => $item)
                                                                <li>
                                                                    <a href="/stream/attachment/{{$openMessage['id'] ?? ''}}/{{$key}}/{{$item['name']}}"
                                                                        target="_blank">
                                                                        {{$item['name']}}
                                                                    </a>
                                                                </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- email details  end-->
                                <div class="row px-2 mb-4" wire:ignore>
                                    <!-- quill editor for reply message -->
                                    <div class="col-12 px-0">
                                        <div class="card shadow-none border rounded">
                                            <div class="card-body quill-wrapper">
                                                <span>Reply To, {{$openMessage['name'] ?? ''}}</span>
                                                <div class="snow-container" id="detail-view-quill">
                                                    <div x-data x-ref="quillEditor" x-init="
                                                            quill = new Quill($refs.quillEditor, {theme: 'snow'});
                                                            quill.on('text-change', function () {
                                                                @this.set('replyMessage', quill.root.innerHTML)
                                                            });
                                                        ">
                                                        {!! $replyMessage !!}
                                                    </div>
                                                    <div class="d-flex justify-content-end">
                                                        <div class="detail-quill-toolbar">
                                                            <span class="ql-formats mr-50">
                                                                <button class="ql-bold"></button>
                                                                <button class="ql-italic"></button>
                                                                <button class="ql-underline"></button>
                                                                <button class="ql-link"></button>
                                                                <button class="ql-image"></button>
                                                            </span>
                                                        </div>


                                                    </div>
                                                </div>
                                                <div class="form-group mt-2">
                                                    <div class="custom-file">
                                                        <input multiple wire:model='attachments' type="file"
                                                            class="custom-file-input" id="emailAttach">
                                                        <label class="custom-file-label" for="emailAttach">Attach
                                                            file</label>
                                                    </div>
                                                </div>
                                                <button wire:loading.attr='disabled' wire:target='attachments'
                                                            wire:click='reply' class="btn btn-primary send-btn">
                                                            <i class='bx bx-send mr-25'></i>
                                                            <span class="d-none d-sm-inline"> Reply</span>
                                                        </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ Detailed Email View -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
