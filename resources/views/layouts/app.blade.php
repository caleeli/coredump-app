<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{config('app.name')}}</title>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Styles -->
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <div id="app" class="flex-center position-ref full-height">
            @yield('content')
        </div>
        @foreach (config('plugins.javascript_before') as $javascript)
        <script src="{{ $javascript }}?{{filemtime(public_path($javascript))}}" defer></script>
        @endforeach
        <script src="{{ mix('js/app.js') }}" defer></script>
        @foreach (config('plugins.javascript') as $javascript)
        <script src="{{ $javascript }}?{{filemtime(public_path($javascript))}}" defer></script>
        @endforeach
    </body>
</html>
