@php

$user = \Auth::user();

@endphp

<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true" style="background-color: #165C98">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="/">
                    <div class="brand-logo">
                        <svg  width="150" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 817.1 232.21"><defs><style>.cls-1{fill:#fff;}.cls-2{fill:#61a2d9;}</style></defs><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><g id="Group_218" data-name="Group 218"><g id="Group_213" data-name="Group 213"><path id="Path_853" data-name="Path 853" class="cls-1" d="M2.89,35.34H111.33v33.3H46.94V95.7h55V127h-55v63.32h-44Z"/><path id="Path_854" data-name="Path 854" class="cls-1" d="M135,35.34h43.87V152.15h51v38.16H135Z"/><path id="Path_855" data-name="Path 855" class="cls-1" d="M247,35.34h44v155H247Z"/><path id="Path_856" data-name="Path 856" class="cls-1" d="M481,187.67V32.7h73.1a97.75,97.75,0,0,1,31.08,3.81,33.49,33.49,0,0,1,17.33,14.11,45.6,45.6,0,0,1,6.58,25.1,46.67,46.67,0,0,1-3.83,22.33c-3.36,6.23-9.56,16.51-16.08,18.13a27.26,27.26,0,0,1,18.13,19.44,162.88,162.88,0,0,1,5.41,36.4,30.65,30.65,0,0,0,2.32,15.65h-44l-3-35.22A17.66,17.66,0,0,0,553,135.07c-4-.27-20.06-.66-24.06-.66h-3.88v53.28Zm44.06-87.36h19.33a62.88,62.88,0,0,0,12.17-2.25A12,12,0,0,0,564,92.91a16.31,16.31,0,0,0,2.89-9.56,15.92,15.92,0,0,0-4.56-12.22,25.58,25.58,0,0,0-17.1-4.26H525.12Z"/><path id="Path_857" data-name="Path 857" class="cls-1" d="M395.68,0H320.19V193h60.05V144h15.44a72,72,0,1,0,0-144Zm13.6,77.36A17.39,17.39,0,0,1,391.89,94.7H380.21V52.2h11.67a17.38,17.38,0,0,1,17.39,17.33Z"/><path id="Path_859" data-name="Path 859" class="cls-1" d="M699.43,32.7a77.59,77.59,0,1,0,73.44,81.54c.07-1.34.1-2.69.1-4A75.63,75.63,0,0,0,699.43,32.7Zm0,119.09c-16.66,0-30.15-18.62-30.15-41.6s13.49-41.6,30.15-41.6,30.19,18.62,30.19,41.6-13.49,41.61-30.19,41.61Z"/></g><path id="Path_858" data-name="Path 858" class="cls-2" d="M390.31,21.16H344V193H355.1V128.14h35.2a53.49,53.49,0,1,0,1.36-107c-.45,0-.91,0-1.36,0Zm0,95.9h-35.2V32.25h35.2a42.41,42.41,0,1,1,0,84.81Z"/><g id="Group_214" data-name="Group 214"><path id="Path_828" data-name="Path 828" class="cls-1" d="M0,231.79V210.06H11.21a16.33,16.33,0,0,1,4.77.53,5.07,5.07,0,0,1,2.66,2,6.15,6.15,0,0,1-1.55,8.57l-.34.22a8.39,8.39,0,0,1-2.36.87,4.59,4.59,0,0,1,2.82,2,8.36,8.36,0,0,1,.94,1.35l3.26,6.31h-7.6l-3.6-6.66A5.11,5.11,0,0,0,9,223.51,2.8,2.8,0,0,0,7.35,223h-.6v8.84Zm6.76-12.95H9.6a10.39,10.39,0,0,0,1.74-.3,1.81,1.81,0,0,0,1.09-.68,2.08,2.08,0,0,0,.42-1.26,2,2,0,0,0-.67-1.62,4,4,0,0,0-2.51-.57h-3Z"/><path id="Path_829" data-name="Path 829" class="cls-1" d="M28.42,210h18v4.65H35.16v3.47H45.59v4.44H35.16v4.3H46.78v4.93H28.42Z"/><path id="Path_830" data-name="Path 830" class="cls-1" d="M55.31,210H61.6l8.19,12V210h6.35v21.73H69.79l-8.15-12v12H55.31Z"/><path id="Path_831" data-name="Path 831" class="cls-1" d="M84.62,220.92a10.32,10.32,0,0,1,9.22-11.3,9.84,9.84,0,0,1,2,0,11.35,11.35,0,0,1,8.37,2.92,11,11,0,0,1,2.94,8.17,13.46,13.46,0,0,1-1.29,6.27,9.1,9.1,0,0,1-3.71,3.79,12.24,12.24,0,0,1-6.08,1.36A14,14,0,0,1,90,231a9.17,9.17,0,0,1-3.91-3.72A12.31,12.31,0,0,1,84.62,220.92Zm6.73,0a7.29,7.29,0,0,0,1.23,4.73,4.63,4.63,0,0,0,6.55.15l.14-.15a8,8,0,0,0,1.19-5.06,6.77,6.77,0,0,0-1.24-4.49,4.23,4.23,0,0,0-3.37-1.42,4.09,4.09,0,0,0-3.26,1.45,7.33,7.33,0,0,0-1.24,4.81Z"/><path id="Path_832" data-name="Path 832" class="cls-1" d="M112.23,210h7l4.91,15.64L129,210h6.82l-8.08,21.73h-7.29Z"/><path id="Path_833" data-name="Path 833" class="cls-1" d="M154.55,228.19H147l-1.06,3.6H139l8.19-21.73h7.34l8.18,21.73h-7Zm-1.4-4.71-2.4-7.82-2.37,7.82Z"/><path id="Path_834" data-name="Path 834" class="cls-1" d="M166.07,210h20.45v5.38h-6.86v16.39h-6.75V215.4h-6.86Z"/><path id="Path_835" data-name="Path 835" class="cls-1" d="M194.4,210h18v4.65h-11.3v3.47h10.43v4.44H201.13v4.3h11.61v4.93H194.39Z"/><path id="Path_836" data-name="Path 836" class="cls-1" d="M236.31,210h6.29l8.19,12V210h6.35v21.73h-6.35l-8.15-12v12h-6.33Z"/><path id="Path_837" data-name="Path 837" class="cls-1" d="M265.62,220.92a10.32,10.32,0,0,1,9.22-11.3,9.74,9.74,0,0,1,2,0,11.36,11.36,0,0,1,8.38,2.92,11,11,0,0,1,2.94,8.17,13.46,13.46,0,0,1-1.29,6.27,9.1,9.1,0,0,1-3.71,3.79,12.24,12.24,0,0,1-6.08,1.36A14,14,0,0,1,271,231a9.23,9.23,0,0,1-3.91-3.72A12.31,12.31,0,0,1,265.62,220.92Zm6.73,0a7.23,7.23,0,0,0,1.23,4.73,4.63,4.63,0,0,0,6.55.15l.14-.15a8,8,0,0,0,1.18-5.06,6.76,6.76,0,0,0-1.23-4.49,4.23,4.23,0,0,0-3.37-1.42,4.12,4.12,0,0,0-3.27,1.45,7.32,7.32,0,0,0-1.23,4.81Z"/><path id="Path_838" data-name="Path 838" class="cls-1" d="M293.91,210h6.39l2.29,12.17L306,210h6.37l3.37,12.17L318,210h6.36l-4.8,21.73H313L309.14,218l-3.8,13.71h-6.6Z"/><path id="Path_839" data-name="Path 839" class="cls-1" d="M346.41,210h11.15a7.61,7.61,0,0,1,5.48,1.73,6.5,6.5,0,0,1,1.82,4.95,6.7,6.7,0,0,1-2,5.15,8.6,8.6,0,0,1-6.09,1.86h-3.68v8.08h-6.76Zm6.77,9.28h1.65a4.26,4.26,0,0,0,2.73-.68,2.2,2.2,0,0,0,.79-1.74,2.41,2.41,0,0,0-.68-1.74,3.59,3.59,0,0,0-2.61-.72h-1.91Z"/><path id="Path_840" data-name="Path 840" class="cls-1" d="M384.08,228.19h-7.64l-1.06,3.6h-6.84l8.19-21.73h7.34l8.18,21.73h-7Zm-1.4-4.71-2.4-7.82-2.37,7.82Z"/><path id="Path_841" data-name="Path 841" class="cls-1" d="M394.43,210h7.48l4.39,7.34,4.39-7.34h7.43l-8.47,12.65v9.12h-6.74v-9.12Z"/><path id="Path_842" data-name="Path 842" class="cls-1" d="M437.93,210h6.39l2.29,12.17L450,210h6.36l3.38,12.17L462,210h6.36l-4.8,21.73H457L453.17,218l-3.8,13.71h-6.6Z"/><path id="Path_843" data-name="Path 843" class="cls-1" d="M475.48,210h6.73v7.61h7.35V210h6.76v21.73h-6.76V223h-7.35v8.81h-6.73Z"/><path id="Path_844" data-name="Path 844" class="cls-1" d="M505.61,210h18v4.65h-11.3v3.47h10.43v4.44H512.34v4.3H524v4.93H505.61Z"/><path id="Path_845" data-name="Path 845" class="cls-1" d="M532.54,210h6.28l8.19,12V210h6.35v21.73H547l-8.15-12v12h-6.33Z"/><path id="Path_846" data-name="Path 846" class="cls-1" d="M575.51,210H583l4.39,7.34,4.39-7.34h7.44l-8.47,12.65v9.12H584v-9.12Z"/><path id="Path_847" data-name="Path 847" class="cls-1" d="M603.56,220.92a10.3,10.3,0,0,1,9.2-11.3,9.93,9.93,0,0,1,2,0,11.35,11.35,0,0,1,8.37,2.92,11,11,0,0,1,2.94,8.17,13.46,13.46,0,0,1-1.29,6.27,9.15,9.15,0,0,1-3.71,3.79,12.24,12.24,0,0,1-6.08,1.36,14,14,0,0,1-6.09-1.17,9.2,9.2,0,0,1-3.92-3.72A12.31,12.31,0,0,1,603.56,220.92Zm6.73,0a7.28,7.28,0,0,0,1.22,4.73,4.63,4.63,0,0,0,6.55.14l.14-.14a8.11,8.11,0,0,0,1.19-5.06,6.77,6.77,0,0,0-1.24-4.49,4.23,4.23,0,0,0-3.37-1.42,4.11,4.11,0,0,0-3.27,1.45,7.25,7.25,0,0,0-1.22,4.81Z"/><path id="Path_848" data-name="Path 848" class="cls-1" d="M648.77,210h6.71v13a10.79,10.79,0,0,1-.6,3.65,7.88,7.88,0,0,1-1.89,3,7.43,7.43,0,0,1-2.69,1.79,13.18,13.18,0,0,1-4.7.73,28.9,28.9,0,0,1-3.48-.22,9.08,9.08,0,0,1-3.14-.87,7.77,7.77,0,0,1-2.31-1.88,6.83,6.83,0,0,1-1.43-2.51,12.8,12.8,0,0,1-.63-3.68V210h6.71v13.29a3.81,3.81,0,0,0,1,2.78,4.27,4.27,0,0,0,5.47,0,3.8,3.8,0,0,0,1-2.8Z"/><path id="Path_849" data-name="Path 849" class="cls-1" d="M678.65,224.58l6.39-.4a5,5,0,0,0,.87,2.38,3.57,3.57,0,0,0,3,1.33,3.27,3.27,0,0,0,2.21-.68,1.93,1.93,0,0,0,.37-2.72,1.85,1.85,0,0,0-.37-.37,8.8,8.8,0,0,0-3.47-1.26,14.64,14.64,0,0,1-6.31-2.6,5.34,5.34,0,0,1-1.9-4.21,5.69,5.69,0,0,1,1-3.17,6.42,6.42,0,0,1,2.93-2.34,13.35,13.35,0,0,1,5.35-.87,10.92,10.92,0,0,1,6.36,1.55,6.7,6.7,0,0,1,2.61,4.94l-6.34.38a3,3,0,0,0-3.11-2.83l-.19,0a2.7,2.7,0,0,0-1.74.49,1.55,1.55,0,0,0-.59,1.21,1.22,1.22,0,0,0,.5.94,5.47,5.47,0,0,0,2.26.8,28.64,28.64,0,0,1,6.32,1.92,6.71,6.71,0,0,1,2.78,2.42,6.18,6.18,0,0,1,.87,3.22,6.88,6.88,0,0,1-1.17,3.86,7.27,7.27,0,0,1-3.24,2.69,13.1,13.1,0,0,1-5.22.87,10.83,10.83,0,0,1-7.69-2.14A8.41,8.41,0,0,1,678.65,224.58Z"/><path id="Path_850" data-name="Path 850" class="cls-1" d="M706.64,210h18v4.65h-11.3v3.47H723.8v4.44H713.37v4.3H725v4.93H706.62Z"/><path id="Path_851" data-name="Path 851" class="cls-1" d="M733.49,210h6.73v16.41h10.5v5.36H733.49Z"/><path id="Path_852" data-name="Path 852" class="cls-1" d="M758.64,210h6.73v16.41h10.5v5.36H758.64Z"/></g></g><path class="cls-1" d="M817.1,46.2a21.76,21.76,0,0,1-43.51,0c0-11.75,9.68-21.18,21.82-21.18S817.1,34.45,817.1,46.2Zm-38.1,0c0,9.42,7,16.91,16.53,16.91,9.31,0,16.15-7.49,16.15-16.78s-6.84-17-16.27-17S779,36.9,779,46.2Zm13,11.1h-4.91V36.12a42.81,42.81,0,0,1,8.14-.64c4,0,5.8.64,7.36,1.55a5.86,5.86,0,0,1,2.06,4.64c0,2.33-1.81,4.14-4.38,4.91v.26c2.06.78,3.22,2.33,3.86,5.16.66,3.23,1,4.53,1.56,5.3h-5.3c-.64-.77-1-2.71-1.68-5.16-.38-2.33-1.67-3.36-4.38-3.36h-2.33Zm.13-12h2.32c2.71,0,4.91-.9,4.91-3.09,0-1.94-1.42-3.24-4.52-3.24a11.62,11.62,0,0,0-2.71.26Z"/></g></g></svg>
                    </div>

                </a></li>
            <li class="nav-item mt-1 mb-1 nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="bx bx-x d-block d-xl-none font-medium-4 primary"></i><i class="toggle-icon bx font-medium-4 d-none d-xl-block primary" data-ticon="bx-disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content mt-2">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="">
            <li class=" nav-item mt-1 mb-1"><a href="/"><i class="bx bx-home-alt"></i><span class="menu-title" data-i18n="">Dashboard</span></a>
            </li>
            <li class=" nav-item mt-1 mb-1"><a href="/tasks"><i class="bx bx-calendar"></i><span class="menu-title" data-i18n="">Tasks</span></a>
            </li>
            <li class=" nav-item mt-1 mb-1"><a href="#"><i class="bx bx-user-circle"></i><span class="menu-title" data-i18n="Starter kit">Leads</span></a>
                <ul class="menu-content">
                    @if($user->hasRole("view-leads"))
                    <li class="{{Request::path() == 'leads' ? 'active' : ''}}"><a href="/leads"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="1 column">Leads </span></a>
                    </li>
                    @endif
                    @if($user->hasRole("view-segments"))
                    <li class="{{Request::path() == 'segments' ? 'active' : ''}}"><a href="/segments"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="1 column">Segments </span></a>
                    </li>
                    @endif
                    @if($user->hasRole("view-tags"))
                    <li class="{{Request::path() == 'tags' ? 'active' : ''}}"><a href="/tags"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="1 column">Tags </span></a>
                    </li>
                    @endif
                </ul>
            </li>
            <li class=" nav-item mt-1 mb-1"><a href="#"><i class="bx bx-envelope"></i><span class="menu-title" data-i18n="Starter kit">Emails</span></a>
                <ul class="menu-content">
                    @if($user->hasRole("view-inbox"))
                    <li class="{{Request::path() == 'inbox' ? 'active' : ''}}"><a href="/inbox"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="1 column">Inbox </span></a>
                    </li>
                    @endif
                    @if($user->hasRole("view-campaigns"))
                    <li class="{{Request::path() == 'campaigns' ? 'active' : ''}}"><a href="/campaigns"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="1 column">Campaigns </span></a>
                    </li>
                    @endif
                </ul>
            </li>
            <li class=" nav-item mt-1 mb-1"><a href="#"><i class="bx bx-building"></i><span class="menu-title" data-i18n="Starter kit">Projects</span></a>
                <ul class="menu-content">
                    @if($user->hasRole("view-projects"))
                    <li class="{{Request::path() == 'projects' ? 'active' : ''}}"><a href="/projects"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="1 column">Projects </span></a>
                    </li>
                    @endif
                    @if($user->hasRole("view-contracts"))
                    <li class="{{Request::path() == 'contracts/project' ? 'active' : ''}}"><a href="/contracts/project"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="1 column">Contracts </span></a>
                    </li>
                    @endif
                </ul>
            </li>
            <li class=" nav-item mt-1 mb-1"><a href="#"><i class="bx bx-user-circle"></i><span class="menu-title" data-i18n="Starter kit">Users</span></a>
                <ul class="menu-content">
                    @if($user->hasRole("view-admin"))
                    <li class="{{Request::path() == 'users/admin' ? 'active' : ''}}"><a href="/users/admin"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="1 column">Administrators </span></a>
                    </li>
                    @endif
                    @if($user->hasRole("view-franchise"))
                    <li class="{{Request::path() == 'users/franchise' ? 'active' : ''}}"><a href="/users/franchise"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="2 columns">Franchises</span></a>
                    </li>
                    @endif
                    @if($user->hasRole("view-evaluator"))
                    <li class="{{Request::path() == 'users/evaluator' ? 'active' : ''}}"><a href="/users/evaluator"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Fixed navbar">Evaluators</span></a>
                    </li>
                    @endif
                    @if($user->hasRole('view-home-owner'))
                    <li class="{{Request::path() == 'users/home-owner' ? 'active' : ''}}"><a href="/users/home-owner"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Fixed layout">Home Owners</span></a>
                    </li>
                    @endif
                    @if($user->hasRole('view-builder'))
                    <li class="{{Request::path() == 'users/builder' ? 'active' : ''}}"><a href="/users/builder"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Static layout">Builders</span></a>
                    </li>
                    @endif
                </ul>
            </li>
            <li class=" nav-item mt-1 mb-1"><a href="#"><i class="bx bx-file"></i><span class="menu-title" data-i18n="Starter kit">Contracts</span></a>
                <ul class="menu-content">
                    @if($user->hasRole("view-admin"))
                    <li class="{{Request::path() == 'contracts/create/0' ? 'active' : ''}}"><a href="/contracts/create/0"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="1 column">Add </span></a>
                    </li>
                    <li class="{{Request::path() == 'contracts/wp' ? 'active' : ''}}"><a href="/contracts/wp"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="1 column">List </span></a>
                    </li>
                    @endif

                </ul>
            </li>
        </ul>
    </div>
</div>
<!-- END: Main Menu-->
