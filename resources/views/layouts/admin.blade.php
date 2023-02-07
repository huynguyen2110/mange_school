<!DOCTYPE html>

<html lang="en">
<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quản lí trường học</title>
{{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">--}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- CoreUI CSS -->
    <link href="https://unpkg.com/@coreui/coreui@3.4/dist/css/coreui.min.css" rel="stylesheet"/>
    <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet"/>

    <script>
        window.Laravel = {!! json_encode(
            [
                'csrfToken' => csrf_token(),
                'baseUrl' => url('/'),
            ],
            JSON_UNESCAPED_UNICODE,
        ) !!};
    </script>
</head>
<body class="c-app">
<div id="app" >
    <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
        <div class="c-sidebar-brand d-lg-down-none">

        </div>
        @include('include.admin.sidebar')
        <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent"
                data-class="c-sidebar-minimized"></button>
    </div>
    <div class="c-wrapper c-fixed-components">

        <header class="c-header c-header-light c-header-fixed c-header-with-subheader">
            <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar"
                    data-class="c-sidebar-show">
                <i class="fas fa-fw fa-bars"></i>
            </button>
            <a class="c-header-brand d-lg-none" href="#">
                <svg width="118" height="46" alt="CoreUI Logo">
                    <use xlink:href="assets/brand/coreui.svg#full"></use>
                </svg>
            </a>
            <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar"
                    data-class="c-sidebar-lg-show" responsive="true">
                <i class="fas fa-fw fa-bars"></i>
            </button>

            @include('include.admin.header')
        </header>
        <div class="c-body">
            <main class="c-main">
                <div class="container-fluid">
                    <div class="fade-in">
                        @yield('content')
                    </div>
                    @if (session()->get('Message.flash'))
                        <notyf :data="{{ json_encode(session()->get('Message.flash')[0]) }}"></notyf>
                    @endif
                    @php
                        session()->forget('Message.flash');
                    @endphp
                </div>
                <form id="logoutform" action="" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </main>
            @include('include.admin.footer')
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
{{--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/perfect-scrollbar.min.js"></script>
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/@coreui/coreui@3.4/dist/js/coreui.min.js"></script>

</body>
</html>
