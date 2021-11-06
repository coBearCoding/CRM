<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ config('app.name') }}</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no"
    />
    <meta name="description" content="CRM">

    <!-- Disable tap highlight on IE -->
    <meta name="msapplication-tap-highlight" content="no">

    <link href="{{ asset('../main.css') }}" rel="stylesheet">
</head>

<body>
<div class="app-container app-theme-white body-tabs-shadow">
    <div class="app-container">
        <div class="h-100">
            <div class="h-100 no-gutters row">
                <div class="d-none d-lg-block col-lg-4">
                    <div class="slider-light">
                        <div class="slick-slider">
                            <div>
                                <div class="position-relative h-100 d-flex justify-content-center align-items-center bg-midnight-bloom "
                                     tabindex="-1">
                                    <div class="slide-img-bg">
                                        <img style="    position: absolute;    left: 0;    top: 0;    width: 100%;    height: 100%;    background-size: cover;    opacity: .4;    z-index: 10;"
                                             class="img-fluid"
                                             src="{{asset('images/fondo.jpg')}}"
                                             alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @yield('content_form')
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ asset('../assets/scripts/main.js') }}"></script>
</body>
</html>