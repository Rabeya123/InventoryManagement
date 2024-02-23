<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title','My || Dashboard')</title>

        <!-- include style section -->
        @include('layouts.style')
        <!--  page level css -->
        @stack('styles')
       <Style>
            .content-wrapper {
                min-height: 100vh;
            }
       </Style>
    </head>

    <body class="fixed-navbar">
        <div class="page-wrapper" id="app">

            <!-- include header section -->
            @include('layouts.header')

            @include('layouts.sidebar')

            <!-- include sider section -->
            <div class="content-wrapper">

                <!-- include content section -->
                @yield('content')

                <!-- include footer section -->
                @include('layouts.footer')

            </div>
        </div>

        <!-- BEGIN PAGA BACKDROPS-->
        <div class="sidenav-backdrop backdrop"></div>
        <div class="preloader-backdrop">
            <div class="page-preloader">Loading</div>
        </div>
        <!-- END PAGA BACKDROPS-->

        <!-- include style section -->
        @include('layouts.script')
        <!--  page level js -->
        @stack('scripts')

     <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
    </body>
</html>
