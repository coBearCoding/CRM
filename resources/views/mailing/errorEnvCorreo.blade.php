<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <meta name="author" content="Links S.A">
    <meta name="keyword" content="CRM ADMIN">


    <title>{{ config('app.name', 'CRM') }}</title>


    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no"/>
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <link href="{{ asset('../main.css') }}" rel="stylesheet">
</head>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link rel="stylesheet" href="../../vendor/toastr/toastr.min.css">

<link rel="stylesheet" href="{{ asset('/vendor/daterangepicker/daterangepicker.css') }}">
<style type="text/css">
    .app-sidebar.sidebar-text-dark .vertical-nav-menu li a.active {
        background: rgba(0, 0, 0, 0.15);
        color: rgba(0, 0, 0, 0.7);
    }

    .error {
        border: 1px solid red !important;
    }
</style>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('../assets/scripts/main.js') }} "></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="../../vendor/toastr/toastr.min.js"></script>
<script src="{{ asset('/vendor/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset('/vendor/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('../js/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/datepicker/bootstrap-datepicker.min.js')}}"></script>

<body >
    <div class="app-container app-theme-white body-tabs-shadow" style='background-color:#ffffff'>
        <div class="app-container">
            <div class="bg-animation">
                <div class="d-flex h-100 justify-content-center align-items-center">
                    <div class="mx-auto app-login-box col-md-8" >
                        <div class="app-logo-inverse mx-auto mb-3"></div>
                        <div  align="center">
                             <img src="{{ asset('images/icono.png') }}" width="140" height="140"  alt="Mi titulo de la imagen" style="margin-bottom:30px;">
                        </div>
                        <div  align="center" style="background: url('{{ asset('images/errorCorreo.jpg') }}')  center no-repeat;  height: 500px; background-size:auto 100%;"   >
                            <a  style="color:#000000; margin-top: 250px; "  href='https://ecotec.edu.ec/' class="btn-wide mb-2 mr-2 btn btn-info btn-lg">Regresar</a>

                        </div>
                        <br> <br>
                        <div  align="center">
                            
                             
                        </div>
                        <div class="text-center text-white opacity-8 mt-3">Copyright © ArchitectUI 2019</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript" src="./assets/scripts/main.d810cf0ae7f39f28f336.js"></script></body>

</html>