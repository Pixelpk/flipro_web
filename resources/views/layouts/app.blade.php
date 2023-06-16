<!DOCTYPE html>
<!--
Template Name: Frest HTML Admin Template
Author: :Pixinvent
Website: http://www.pixinvent.com/
Contact: hello@pixinvent.com
Follow: www.twitter.com/pixinvents
Like: www.facebook.com/pixinvents
Purchase: https://1.envato.market/pixinvent_portfolio
Renew Support: https://1.envato.market/pixinvent_portfolio
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.

-->
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description"
        content="Frest admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Frest admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>Flipro - CRM</title>

    <link rel="apple-touch-icon" href="/app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="/app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700"
        rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/ui/prism.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/editors/quill/quill.snow.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/themes/semi-dark-layout.css">


    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
    <!-- END: Custom CSS-->
    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/pages/app-email.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- END: Page CSS-->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
    <link rel="stylesheet" href="/app.css">
    @livewireStyles
    <style>
        p {
            width: 100% !important
        }
    </style>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body autocomplete="off"
    class="vertical-layout vertical-menu-modern boxicon-layout no-card-shadow content-left-sidebar email-application navbar-sticky footer-static  "
    data-open="click" data-menu="vertical-menu-modern" data-col="content-left-sidebar">

    @include('layouts.menu')
    @include('layouts.nav')
    {{$slot}}
    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->

    <!-- END: Footer-->

    @livewireScripts
    <!-- BEGIN: Vendor JS-->
    <script src="/app-assets/vendors/js/vendors.min.js"></script>
    <script src="/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.js"></script>
    <script src="/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js"></script>
    <script src="/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js"></script>
    <script src="/app-assets/vendors/js/forms/select/select2.full.min.js"></script>

    <!-- BEGIN Vendor JS-->
    <!-- BEGIN: Page Vendor JS-->
    <script src="/app-assets/vendors/js/ui/prism.min.js"></script>

    <script src="/app-assets/vendors/js/editors/quill/quill.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="/app-assets/js/core/app-menu.js"></script>
    <script src="/app-assets/js/core/app.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="/assets/js/ckeditor/src/ckeditor.js"></script>
    <link href='/assets/js/fullcalendar/lib/main.css' rel='stylesheet' />
    <script src='/assets/js/fullcalendar/lib/main.js'></script>
    <link href='/assets/js/fullcalendar-scheduler/lib/main.css' rel='stylesheet' />
    <script src='/assets/js/fullcalendar-scheduler/lib/main.js'></script>
    <script src="/app-assets/js/scripts/pages/app-email.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js"
        integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        {{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
        <script src="/app-assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
    <!-- END: Page JS-->
    <script>
        $(document).ready(function() {
        $('.select2').select2();
    });
    </script>


    <script>
        window.addEventListener('toggleModal', event => {
            $("#" + event.detail.id).modal(event.detail.action)
        })
        window.addEventListener('alert', event => {
            swal({
                title: event.detail.title,
                text: event.detail.text,
                type: event.detail.type,
            })
        })
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            axios.get('/events')
            .then((res) => {
                var events = [];

                res.data.data.forEach((item, index) => {
                    events.push({
                        title: item.title,
                        start: item.event_date,
                        description: item.description,
                        // url: "{{url('/events/')}}/" + item.id
                    })
                })
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                  initialView: 'dayGridMonth',
                  events: events,
                  eventClick:  function(event, jsEvent, view) {
                    var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                    $('#modalTitlecus').html(event.event.title);
                    $('#modalDatecus').html(new Date(event.event.start).toLocaleDateString("en-US", options));
                    $('#modalBodycus').html(event.event.extendedProps.description);
                    $('#calendarModal').modal();
                },
                eventRender: function(info) {
                    var tooltip = new Tooltip(info.el, {
                    title: info.event.extendedProps.description,
                    placement: 'top',
                    trigger: 'hover',
                    container: 'body'
                    });
                }

                });
                calendar.render();

            })
      })
    </script>
    <script>
        window.addEventListener('confirmation', event => {
            swal({
                title: event.detail.message,
                text: "Are you sure you want to continue",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
            }).then((isConfirmed) => {
                if (isConfirmed['dismiss']) {
                    console.log(isConfirmed['dismiss']);

                }else{
                     Livewire.emit(event.detail.function);
                }
            })
        });

    </script>

    <style>
        .fc-license-message {
            display: none !important;
        }
        
    </style>
    <div id="calendarModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="modalTitlecus" class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                </div>
                <div id="modalBodycus" class="modal-body"> </div>
                <div id="modalDatecus" class="modal-body"> </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
        </div>

</body>
<!-- END: Body-->

</html>
