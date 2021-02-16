<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Motelo</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

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
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Motelo
                </div>
                <h2>
                    Authors: Nguyen Ngoc Dat (Datnn)
                </h2>
                <div class="links">
                    <a href="https://www.facebook.com/dat.nguyenngoc.792/">Facebook</a>
                    <a href="https://github.com/DinnieJ">Github</a>
                    <a href="https://www.linkedin.com/in/nguy%E1%BB%85n-ng%E1%BB%8Dc-%C4%91%E1%BA%A1t-453725181/">Linkedin</a>
                    <a href="https://9gag.com/u/tom_morrellul">9GAG</a>
                </div>
                <br/>
                <h2>Collaborators</h2>
                <div class="links">
                    <a href="#">Bui Trung Hieu</a>
                    <a href="#">Do Duc Duy</a>
                </div>
            </div>
        </div>
    </body>
</html>
