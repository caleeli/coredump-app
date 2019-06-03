<!doctype html>
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
            <layout>
                <template slot="north">
                    <topbar>
                        <template slot="logo">
                            <a class="navbar-brand" href="/">{{config('app.name')}}</a>
                        </template>
                        <template slot="right">
                            <avatar style="font-size: 2em"></avatar>
                        </template>
                    </topbar>
                </template>
                <template slot="west">
                    <list v-slot="{item, control}" style="width:320px"
                        :value="[{id:1,parent:0,name:'Dashboard'},{id:2,parent:1,name:'Admin'}]">
                        <a href="javascript:void(0)" @click="control.toggle()">@{{item.name}}</a>
                    </list>
                </template>
                <router-view></router-view>
            </layout>
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
