<!doctype html>
<html lang="{{ app()->getLocale() }}" class="has-navbar-fixed-top">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @auth
        <meta name="api-token" content="{{ auth()->user()->api_token }}">
        <script>
            window.Global = <?php echo json_encode([
                'user' => auth()->user(),
                'convs' => auth()->user()->threads->pluck('id')->toArray()
            ]); ?>
        </script>
    @else 
    <script>
         window.Global = [];
    </script>
    @endauth

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    <style>
        
    </style>
</head>
<body>
    <div id="app">

        @include('shared/navbar')
        
        @include('shared/alerts')

        @yield('c-content')

        <div class="container">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ mix('/js/app.js') }}"></script>
    @stack('inline-scripts')
</body>
</html>
