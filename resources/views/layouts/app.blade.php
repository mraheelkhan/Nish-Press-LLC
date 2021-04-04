<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
</head>
<body>
<div id="app">
    @auth()
        @include('layouts.partials.header')
    @endauth
    <div class="d-flex align-items-stretch">
        @auth()
        @include('layouts.partials.navbar')
        @endauth
        <div class="page-holder w-100 d-flex flex-wrap">
            <div class="container-fluid px-xl-5">
                <section class="py-5">
                    @yield('content')
                </section>
            </div>
            @auth()
            <footer class="footer bg-white shadow align-self-end py-3 px-xl-5 w-100">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-left text-primary">
                            <p class="mb-2 mb-md-0"><NishPress></NishPress> &copy; 2018-2020</p>
                        </div>
                        <div class="col-md-6 text-center text-md-right text-gray-400">
                            <p class="mb-0">Design by <a href="https://mraheelkhan.com/">Raheel</a></p>
                            <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
                        </div>
                    </div>
                </div>
            </footer>
            @endauth
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
