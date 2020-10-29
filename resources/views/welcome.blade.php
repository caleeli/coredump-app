<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{config('app.name')}}</title>


        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
                font-family: 'logo', 'Nunito', sans-serif;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            @font-face {
                font-family: 'logo';
                src: url(/fonts/caserita.ttf?3b59d44a3d364049ab07ea32f0ab31b0) format("truetype");
            }
            @keyframes banner {
                from {
                    width: 100px;
                }

                to {
                    width: 300px;
                }
            }
            div {
                animation-duration: 0.1s;
                animation-name: changewidth;
                animation-iteration-count: infinite;
                animation-direction: alternate;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">{{__('Home')}}</a>
                    @else
                        <a href="{{ route('login') }}">{{__('Login')}}</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">{{__('Register')}}</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    {{config('app.name')}}
                </div>

                <div class="links">
                    <a href="/api/documentation">Docs</a>
                    <a href="https://github.com/caleeli/coredump-app.git">GitHub</a>
                </div>
            </div>
        </div>
    </body>
</html>
