@php

$user = \Auth::user();

@endphp

<!-- BEGIN: Header-->
<div class="header-navbar-shadow"></div>
<nav class="header-navbar main-header-navbar navbar-expand-lg navbar navbar-with-menu navbar-static-top ">
    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <div class="navbar-collapse" id="navbar-mobile">
                <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                
                </div>
                <ul class="nav navbar-nav float-right">
                    <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i class="ficon bx bx-fullscreen"></i></a></li>
                    <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <div class="user-nav d-sm-flex d-none"><span class="user-name">{{$user->name}}</span></div><span><img class="round" src="/app-assets/images/portrait/small/avatar-s-11.jpg" alt="avatar" height="40" width="40"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="/inbox"><i class="bx bx-envelope mr-50"></i> My Inbox</a><a class="dropdown-item" href="/settings"><i class="bx bx-cog mr-50"></i> Settings</a>
                            <div class="dropdown-divider"></div><a class="dropdown-item" href="/logout"><i class="bx bx-power-off mr-50"></i> Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<!-- END: Header-->