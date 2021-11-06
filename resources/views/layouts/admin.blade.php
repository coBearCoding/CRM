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
    <link href="{{ asset('/css/floating.css') }}" rel="stylesheet">
</head>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link rel="stylesheet" href="../../vendor/toastr/toastr.min.css">

@yield('css')
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
<script>
    window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token()]); ?>
</script>

<body>
<div  id="app">


<div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
    <div class="app-header header-shadow bg-light header-text-dark">
        <div class="app-header__logo">
            <div>
                <img src="{{asset('../images/logo_inicial.png')}}" width="60%" height="50%"/>
            </div>
            <div class="header__pane ml-auto">
                <div>
                    <button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
                            data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="app-header__mobile-menu">
            <div>
                <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                </button>
            </div>
        </div>

        <div class="app-header__menu">
                <span>
                    <button type="button"
                            class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                        <span class="btn-icon-wrapper">
                            <i class="fa fa-ellipsis-v fa-w-6"></i>
                        </span>
                    </button>
                </span>
        </div>

        @php
            $objinfoUser = Session::get('infoUser');
            $lstSede = Session::get('lstSede');
        $i=0;
        @endphp

        <div class="app-header__content">
            <div class="app-header-left">
                <div class="search-wrapper">
                    <div class="input-holder">
                        <input type="text" class="search-input" placeholder="Type to search">
                        <button style="display:none" class="search-icon"><span></span></button>
                    </div>
                    <button class="close"></button>
                </div>
                <ul class="header-megamenu nav">
                    @if(!empty($objinfoUser->empresa))
                    <li class="btn-group nav-item">
                        <a class="nav-link" data-toggle="dropdown" aria-expanded="false">
                            <i class="nav-link-icon pe-7s-culture"></i> <b>{{$objinfoUser->empresa->nombre}}</b>
                        </a>
                    </li>
                        @endif
                    <li class="dropdown nav-item">

                        @if(!empty($objinfoUser->sede))
                            @php
                                Session::put('sede_id', $objinfoUser->sede->id);
                            @endphp
                            <a aria-haspopup="true" data-toggle="dropdown" class="nav-link" aria-expanded="false">
                                <i class="nav-link-icon pe-7s-airplay"></i>
                                <select id="sede" name="sede" class="form-control" onchange="cargardashboard()">

                                        <option value="{{$objinfoUser->sede->id}}">{{$objinfoUser->sede->nombre}}</option>

                                </select>
                            </a>
                        @else
                            <a aria-haspopup="true" data-toggle="dropdown" class="nav-link" aria-expanded="false">
                                <i class="nav-link-icon pe-7s-airplay"></i>
                                <select id="sede" name="sede" class="form-control" onchange="cargardashboard()">
                                    @if(!empty($lstSede))
                                        <option value="0">Todas las sedes</option>
                                        @foreach($lstSede as $sede)
                                            @php
                                                if($i == 0){
                                                    Session::put('sede_id', $sede->id);
                                                }
                                            @endphp
                                            <option value="{{$sede->id}}">{{$sede->nombre}}</option>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                    @endif

                                </select>
                            </a>

                        @endif
                    </li>
                </ul>
            </div>
            <div class="app-header-right">
                  <notification-component user_id="{{ Auth::user()->id }}"></notification-component>

                <div class="header-btn-lg pr-0">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left">
                                <div class="btn-group">
                                    <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                       class="p-0 btn">
                                        <img width="42" class="rounded-circle"
                                             src="{{ asset('assets/images/avatars/1.png')}}" alt="">
                                        <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                    </a>

                                    <div tabindex="-1" role="menu" aria-hidden="true"
                                         class="rm-pointers dropdown-menu-lg dropdown-menu dropdown-menu-right">
                                        <div class="dropdown-menu-header">
                                            <div class="dropdown-menu-header-inner bg-info">
                                                <div class="menu-header-image opacity-2"
                                                     style="background-image: url('assets/images/dropdown-header/city3.jpg');"></div>
                                                <div class="menu-header-content text-left">
                                                    <div class="widget-content p-0">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left mr-3">
                                                                <img width="42" class="rounded-circle"
                                                                     src="{{ asset('assets/images/avatars/1.png')}}"
                                                                     alt="">
                                                            </div>
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading"> {{ Auth::user()->name}}</div>
                                                                <div class="widget-subheading opacity-8">{{ Auth::user()->roles->name }}</div>
                                                            </div>
                                                            <div class="widget-content-right mr-2">

                                                                <form id="logout-form" action="{{ route('logout') }}"
                                                                      method="POST"
                                                                      style="display: none;">
                                                                    {{ csrf_field() }}
                                                                </form>

                                                                <a href="{{ route('logout') }}"
                                                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                                                   title="Cerrar Sesión" type="button"
                                                                   class="btn-pill btn-shadow btn-shine btn btn-focus">Salir
                                                                    <i class="fa text-white fa-chevron-circle-right pr-1 pl-1"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--
                                        <div class="scroll-area-xs" style="height: 150px;">
                                            <div class="scrollbar-container ps">
                                                <ul class="nav flex-column">
                                                    <li class="nav-item-header nav-item">Activity</li>
                                                    <li class="nav-item">
                                                        <a href="javascript:void(0);" class="nav-link">Chat
                                                            <div class="ml-auto badge badge-pill badge-info">8</div>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="javascript:void(0);" class="nav-link">Recover
                                                            Password</a>
                                                    </li>
                                                    <li class="nav-item-header nav-item">My Account
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="javascript:void(0);" class="nav-link">Settings
                                                            <div class="ml-auto badge badge-success">New</div>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="javascript:void(0);" class="nav-link">Messages
                                                            <div class="ml-auto badge badge-warning">512</div>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="javascript:void(0);" class="nav-link">Logs</a>
                                                    </li>
                                                </ul>
                                                <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                                    <div class="ps__thumb-x" tabindex="0"
                                                         style="left: 0px; width: 0px;"></div>
                                                </div>
                                                <div class="ps__rail-y" style="top: 0px; right: 0px;">
                                                    <div class="ps__thumb-y" tabindex="0"
                                                         style="top: 0px; height: 0px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <ul class="nav flex-column">
                                            <li class="nav-item-divider mb-0 nav-item"></li>
                                        </ul>
                                        <div class="grid-menu grid-menu-2col">
                                            <div class="no-gutters row">
                                                <div class="col-sm-6">
                                                    <button class="btn-icon-vertical btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-warning">
                                                        <i class="pe-7s-chat icon-gradient bg-amy-crisp btn-icon-wrapper mb-2"></i>
                                                        Message Inbox
                                                    </button>
                                                </div>
                                                <div class="col-sm-6">
                                                    <button class="btn-icon-vertical btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-danger">
                                                        <i class="pe-7s-ticket icon-gradient bg-love-kiss btn-icon-wrapper mb-2"></i>
                                                        <b>Support Tickets</b>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <ul class="nav flex-column">
                                            <li class="nav-item-divider nav-item">
                                            </li>
                                            <li class="nav-item-btn text-center nav-item">
                                                <button class="btn-wide btn btn-primary btn-sm"> Open Messages</button>
                                            </li>
                                        </ul>-->
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content-left ml-3 header-user-info">
                                <div class="widget-heading">  {{ Auth::user()->name}} </div>
                                <div class="widget-subheading"> {{ Auth::user()->roles->name }} </div>
                            </div>
                            <div class="widget-content-right header-user-info ml-3">
                                <button type="button"  style="display:block;" id="centalTelefonica" onclick="centalTelefonica()" class="btn-shadow p-1 btn btn-primary btn-sm ">
                                    <i class="pe-7s-headphones "></i> Elastix
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="header-btn-lg">
                    <button type="button" style="display:none" class="hamburger hamburger--elastic open-right-drawer">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                    </button>
                </div>
            </div>
        </div>


    </div>

    <div class="app-main">
        <div class="app-sidebar sidebar-shadow bg-night-sky sidebar-text-light">
            <div class="app-header__logo">
                <div class="logo-src"></div>
                <div class="header__pane ml-auto">
                    <div>
                        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
                                data-class="closed-sidebar">
                                    <span class="hamburger-box">
                                        <span class="hamburger-inner"></span>
                                    </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="app-header__mobile-menu">
                <div>
                    <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                    </button>
                </div>
            </div>
            <div class="app-header__menu">
                        <span>
                            <button type="button"
                                    class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                                <span class="btn-icon-wrapper">
                                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                                </span>
                            </button>
                        </span>
            </div>
            <div class="scrollbar-sidebar ps ps--active-y">
                <div class="app-sidebar__inner">

                    @include('layouts.menu')

                </div>
                <div class="ps__rail-x">
                    <div class="ps__thumb-x" tabindex="0"></div>
                </div>
                <div class="ps__rail-y">
                    <div class="ps__thumb-y" tabindex="0"></div>
                </div>
            </div>
        </div>
        <div class="app-main__outer">
            <div class="app-main__inner">
                <div class="app-page-title">
                    <div class="page-title-wrapper">
                        @yield('title')
                    </div>
                    <div id="div_mensajes" class="d-none">
                        <p id="mensajes"></p>
                    </div>
                </div>

                @yield('content')

            </div>
            <div class="app-wrapper-footer">
                <div class="app-footer">
                    <div class="app-footer__inner">
                        <div class="app-footer-left">

                        </div>
                        <div class="app-footer-right">
                            Desarrollado por CodeLinks - ©Copyright 2020
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="app-drawer-wrapper">
        <div class="drawer-nav-btn">
            <button type="button" class="hamburger hamburger--elastic is-active">
                <span class="hamburger-box"><span class="hamburger-inner"></span></span>
            </button>
        </div>
        <div class="drawer-content-wrapper">
            <div class="scrollbar-container ps ps--active-y">
                <h3 class="drawer-heading">Servers Status</h3>
                <div class="drawer-section">
                    <div class="row">
                        <div class="col">
                            <div class="progress-box">
                                <h4>Server Load 1</h4>
                                <div class="circle-progress circle-progress-gradient-xl mx-auto">
                                    <canvas width="114" height="114"></canvas>
                                    <small><span class="fsize-2">51%<span></span></span></small>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="progress-box">
                                <h4>Server Load 2</h4>
                                <div class="circle-progress circle-progress-success-xl mx-auto">
                                    <canvas width="114" height="114"></canvas>
                                    <small><span class="fsize-2">16%<span></span></span></small>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="progress-box">
                                <h4>Server Load 3</h4>
                                <div class="circle-progress circle-progress-danger-xl mx-auto">
                                    <canvas width="114" height="114"></canvas>
                                    <small><span class="fsize-2">51%<span></span></span></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="mt-3" style="position: relative;">
                        <h5 class="text-center card-title">Live Statistics</h5>
                        <div id="sparkline-carousel-3" style="min-height: 120px;">
                            <div id="apexchartsojs9udu4" class="apexcharts-canvas apexchartsojs9udu4"
                                 style="width: 402px; height: 120px;">
                                <svg id="SvgjsSvg1411" width="402" height="120" xmlns="http://www.w3.org/2000/svg"
                                     version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                                     xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg"
                                     xmlns:data="ApexChartsNS" transform="translate(0, 0)"
                                     style="background: transparent;">
                                    <g id="SvgjsG1413" class="apexcharts-inner apexcharts-graphical"
                                       transform="translate(0, 0)">
                                        <defs id="SvgjsDefs1412">
                                            <clipPath id="gridRectMaskojs9udu4">
                                                <rect id="SvgjsRect1416" width="405" height="123" x="-1.5" y="-1.5"
                                                      rx="0" ry="0" fill="#ffffff" opacity="1" stroke-width="0"
                                                      stroke="none" stroke-dasharray="0"></rect>
                                            </clipPath>
                                            <clipPath id="gridRectMarkerMaskojs9udu4">
                                                <rect id="SvgjsRect1417" width="410" height="128" x="-4" y="-4" rx="0"
                                                      ry="0" fill="#ffffff" opacity="1" stroke-width="0" stroke="none"
                                                      stroke-dasharray="0"></rect>
                                            </clipPath>
                                        </defs>
                                        <rect id="SvgjsRect1415" width="0" height="120" x="0" y="0" rx="0" ry="0"
                                              fill="#b1b9c4" opacity="1" stroke-width="0" stroke-dasharray="0"
                                              class="apexcharts-xcrosshairs" filter="none" fill-opacity="0.9"></rect>
                                        <g id="SvgjsG1424" class="apexcharts-xaxis" transform="translate(0, 0)">
                                            <g id="SvgjsG1425" class="apexcharts-xaxis-texts-g"
                                               transform="translate(0, -4)"></g>
                                        </g>
                                        <g id="SvgjsG1428" class="apexcharts-grid">
                                            <line id="SvgjsLine1430" x1="0" y1="120" x2="402" y2="120"
                                                  stroke="transparent" stroke-dasharray="0"></line>
                                            <line id="SvgjsLine1429" x1="0" y1="1" x2="0" y2="120" stroke="transparent"
                                                  stroke-dasharray="0"></line>
                                        </g>
                                        <g id="SvgjsG1419" class="apexcharts-line-series apexcharts-plot-series">
                                            <g id="SvgjsG1420" class="apexcharts-series series-1"
                                               data:longestSeries="true" rel="1" data:realIndex="0">
                                                <path id="apexcharts-line-0"
                                                      d="M 8.375 54.635149023638235C 14.2375 54.635149023638235 19.2625 71.90133607399794 25.125 71.90133607399794C 30.9875 71.90133607399794 36.0125 74.36793422404932 41.875 74.36793422404932C 47.7375 74.36793422404932 52.7625 66.96813977389516 58.625 66.96813977389516C 64.4875 66.96813977389516 69.5125 5.3031860226104754 75.375 5.3031860226104754C 81.2375 5.3031860226104754 86.2625 86.70092497430628 92.125 86.70092497430628C 97.9875 86.70092497430628 103.0125 69.43473792394656 108.875 69.43473792394656C 114.7375 69.43473792394656 119.7625 96.56731757451182 125.625 96.56731757451182C 131.4875 96.56731757451182 136.5125 73.13463514902364 142.375 73.13463514902364C 148.2375 73.13463514902364 153.2625 50.935251798561154 159.125 50.935251798561154C 164.9875 50.935251798561154 170.0125 64.50154162384378 175.875 64.50154162384378C 181.7375 64.50154162384378 186.7625 44.76875642343268 192.625 44.76875642343268C 198.4875 44.76875642343268 203.5125 63.26824254881809 209.375 63.26824254881809C 215.2375 63.26824254881809 220.2625 53.401849948612536 226.125 53.401849948612536C 231.9875 53.401849948612536 237.0125 39.8355601233299 242.875 39.8355601233299C 248.7375 39.8355601233299 253.7625 81.76772867420348 259.625 81.76772867420348C 265.4875 81.76772867420348 270.5125 86.70092497430628 276.375 86.70092497430628C 282.2375 86.70092497430628 287.2625 76.83453237410072 293.125 76.83453237410072C 298.9875 76.83453237410072 304.0125 53.401849948612536 309.875 53.401849948612536C 315.7375 53.401849948612536 320.7625 76.83453237410072 326.625 76.83453237410072C 332.4875 76.83453237410072 337.5125 90.40082219938336 343.375 90.40082219938336C 349.2375 90.40082219938336 354.2625 62.03494347379239 360.125 62.03494347379239C 365.9875 62.03494347379239 371.0125 43.53545734840698 376.875 43.53545734840698C 382.7375 43.53545734840698 387.7625 57.10174717368962 393.625 57.10174717368962"
                                                      fill="none" fill-opacity="1" stroke="rgba(58,196,125,0.85)"
                                                      stroke-opacity="1" stroke-linecap="butt" stroke-width="3"
                                                      stroke-dasharray="0" class="apexcharts-line" index="0"
                                                      clip-path="url(#gridRectMaskojs9udu4)"
                                                      pathTo="M 8.375 54.635149023638235C 14.2375 54.635149023638235 19.2625 71.90133607399794 25.125 71.90133607399794C 30.9875 71.90133607399794 36.0125 74.36793422404932 41.875 74.36793422404932C 47.7375 74.36793422404932 52.7625 66.96813977389516 58.625 66.96813977389516C 64.4875 66.96813977389516 69.5125 5.3031860226104754 75.375 5.3031860226104754C 81.2375 5.3031860226104754 86.2625 86.70092497430628 92.125 86.70092497430628C 97.9875 86.70092497430628 103.0125 69.43473792394656 108.875 69.43473792394656C 114.7375 69.43473792394656 119.7625 96.56731757451182 125.625 96.56731757451182C 131.4875 96.56731757451182 136.5125 73.13463514902364 142.375 73.13463514902364C 148.2375 73.13463514902364 153.2625 50.935251798561154 159.125 50.935251798561154C 164.9875 50.935251798561154 170.0125 64.50154162384378 175.875 64.50154162384378C 181.7375 64.50154162384378 186.7625 44.76875642343268 192.625 44.76875642343268C 198.4875 44.76875642343268 203.5125 63.26824254881809 209.375 63.26824254881809C 215.2375 63.26824254881809 220.2625 53.401849948612536 226.125 53.401849948612536C 231.9875 53.401849948612536 237.0125 39.8355601233299 242.875 39.8355601233299C 248.7375 39.8355601233299 253.7625 81.76772867420348 259.625 81.76772867420348C 265.4875 81.76772867420348 270.5125 86.70092497430628 276.375 86.70092497430628C 282.2375 86.70092497430628 287.2625 76.83453237410072 293.125 76.83453237410072C 298.9875 76.83453237410072 304.0125 53.401849948612536 309.875 53.401849948612536C 315.7375 53.401849948612536 320.7625 76.83453237410072 326.625 76.83453237410072C 332.4875 76.83453237410072 337.5125 90.40082219938336 343.375 90.40082219938336C 349.2375 90.40082219938336 354.2625 62.03494347379239 360.125 62.03494347379239C 365.9875 62.03494347379239 371.0125 43.53545734840698 376.875 43.53545734840698C 382.7375 43.53545734840698 387.7625 57.10174717368962 393.625 57.10174717368962"
                                                      pathFrom="M -1 120L -1 120L 25.125 120L 41.875 120L 58.625 120L 75.375 120L 92.125 120L 108.875 120L 125.625 120L 142.375 120L 159.125 120L 175.875 120L 192.625 120L 209.375 120L 226.125 120L 242.875 120L 259.625 120L 276.375 120L 293.125 120L 309.875 120L 326.625 120L 343.375 120L 360.125 120L 376.875 120L 393.625 120"></path>
                                                <g id="SvgjsG1421" class="apexcharts-series-markers-wrap"></g>
                                                <g id="SvgjsG1422" class="apexcharts-datalabels"></g>
                                            </g>
                                        </g>
                                        <line id="SvgjsLine1431" x1="0" y1="0" x2="402" y2="0" stroke="#b6b6b6"
                                              stroke-dasharray="0" stroke-width="1"
                                              class="apexcharts-ycrosshairs"></line>
                                        <line id="SvgjsLine1432" x1="0" y1="0" x2="402" y2="0" stroke-dasharray="0"
                                              stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line>
                                        <g id="SvgjsG1433" class="apexcharts-yaxis-annotations"></g>
                                        <g id="SvgjsG1434" class="apexcharts-xaxis-annotations"></g>
                                        <g id="SvgjsG1435" class="apexcharts-point-annotations"></g>
                                    </g>
                                    <g id="SvgjsG1426" class="apexcharts-yaxis" rel="0" transform="translate(-35, 0)">
                                        <g id="SvgjsG1427" class="apexcharts-yaxis-texts-g"></g>
                                    </g>
                                </svg>
                                <div class="apexcharts-legend"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="widget-chart p-0">
                                    <div class="widget-chart-content">
                                        <div class="widget-numbers text-warning fsize-3">43</div>
                                        <div class="widget-subheading pt-1">Packages</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="widget-chart p-0">
                                    <div class="widget-chart-content">
                                        <div class="widget-numbers text-danger fsize-3">65</div>
                                        <div class="widget-subheading pt-1">Dropped</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="widget-chart p-0">
                                    <div class="widget-chart-content">
                                        <div class="widget-numbers text-success fsize-3">18</div>
                                        <div class="widget-subheading pt-1">Invalid</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <div class="text-center mt-2 d-block">
                            <button class="mr-2 border-0 btn-transition btn btn-outline-danger">Escalate Issue</button>
                            <button class="border-0 btn-transition btn btn-outline-success">Support Center</button>
                        </div>
                        <div class="resize-triggers">
                            <div class="expand-trigger">
                                <div style="width: 403px; height: 288px;"></div>
                            </div>
                            <div class="contract-trigger"></div>
                        </div>
                    </div>
                </div>
                <h3 class="drawer-heading">File Transfers</h3>
                <div class="drawer-section p-0">
                    <div class="files-box">
                        <ul class="list-group list-group-flush">
                            <li class="pt-2 pb-2 pr-2 list-group-item">
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left opacity-6 fsize-2 mr-3 text-primary center-elem">
                                            <i class="fa fa-file-alt"></i>
                                        </div>
                                        <div class="widget-content-left">
                                            <div class="widget-heading font-weight-normal">TPSReport.docx</div>
                                        </div>
                                        <div class="widget-content-right widget-content-actions">
                                            <button class="btn-icon btn-icon-only btn btn-link btn-sm">
                                                <i class="fa fa-cloud-download-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="pt-2 pb-2 pr-2 list-group-item">
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left opacity-6 fsize-2 mr-3 text-warning center-elem">
                                            <i class="fa fa-file-archive"></i>
                                        </div>
                                        <div class="widget-content-left">
                                            <div class="widget-heading font-weight-normal">Latest_photos.zip</div>
                                        </div>
                                        <div class="widget-content-right widget-content-actions">
                                            <button class="btn-icon btn-icon-only btn btn-link btn-sm">
                                                <i class="fa fa-cloud-download-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="pt-2 pb-2 pr-2 list-group-item">
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left opacity-6 fsize-2 mr-3 text-danger center-elem">
                                            <i class="fa fa-file-pdf"></i>
                                        </div>
                                        <div class="widget-content-left">
                                            <div class="widget-heading font-weight-normal">Annual Revenue.pdf</div>
                                        </div>
                                        <div class="widget-content-right widget-content-actions">
                                            <button class="btn-icon btn-icon-only btn btn-link btn-sm">
                                                <i class="fa fa-cloud-download-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="pt-2 pb-2 pr-2 list-group-item">
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left opacity-6 fsize-2 mr-3 text-success center-elem">
                                            <i class="fa fa-file-excel"></i>
                                        </div>
                                        <div class="widget-content-left">
                                            <div class="widget-heading font-weight-normal">Analytics_GrowthReport.xls
                                            </div>
                                        </div>
                                        <div class="widget-content-right widget-content-actions">
                                            <button class="btn-icon btn-icon-only btn btn-link btn-sm">
                                                <i class="fa fa-cloud-download-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <h3 class="drawer-heading">Tasks in Progress</h3>
                <div class="drawer-section p-0">
                    <div class="todo-box">
                        <ul class="todo-list-wrapper list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="todo-indicator bg-warning"></div>
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left mr-2">
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox" id="exampleCustomCheckbox1266"
                                                       class="custom-control-input">
                                                <label class="custom-control-label" for="exampleCustomCheckbox1266">&nbsp;</label>
                                            </div>
                                        </div>
                                        <div class="widget-content-left">
                                            <div class="widget-heading">Wash the car
                                                <div class="badge badge-danger ml-2">Rejected</div>
                                            </div>
                                            <div class="widget-subheading"><i>Written by Bob</i></div>
                                        </div>
                                        <div class="widget-content-right widget-content-actions">
                                            <button class="border-0 btn-transition btn btn-outline-success">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <button class="border-0 btn-transition btn btn-outline-danger">
                                                <i class="fa fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="todo-indicator bg-focus"></div>
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left mr-2">
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox" id="exampleCustomCheckbox1666"
                                                       class="custom-control-input">
                                                <label class="custom-control-label" for="exampleCustomCheckbox1666">&nbsp;</label>
                                            </div>
                                        </div>
                                        <div class="widget-content-left">
                                            <div class="widget-heading">Task with hover dropdown menu</div>
                                            <div class="widget-subheading">
                                                <div>By Johnny
                                                    <div class="badge badge-pill badge-info ml-2">NEW</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="widget-content-right widget-content-actions">
                                            <div class="d-inline-block dropdown">
                                                <button type="button" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false"
                                                        class="border-0 btn-transition btn btn-link">
                                                    <i class="fa fa-ellipsis-h"></i>
                                                </button>
                                                <div tabindex="-1" role="menu" aria-hidden="true"
                                                     class="dropdown-menu dropdown-menu-right">
                                                    <h6 tabindex="-1" class="dropdown-header">Header</h6>
                                                    <button type="button" disabled="" tabindex="-1"
                                                            class="disabled dropdown-item">Action
                                                    </button>
                                                    <button type="button" tabindex="0" class="dropdown-item">Another
                                                        Action
                                                    </button>
                                                    <div tabindex="-1" class="dropdown-divider"></div>
                                                    <button type="button" tabindex="0" class="dropdown-item">Another
                                                        Action
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="todo-indicator bg-primary"></div>
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left mr-2">
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox" id="exampleCustomCheckbox4777"
                                                       class="custom-control-input">
                                                <label class="custom-control-label" for="exampleCustomCheckbox4777">&nbsp;</label>
                                            </div>
                                        </div>
                                        <div class="widget-content-left flex2">
                                            <div class="widget-heading">Badge on the right task</div>
                                            <div class="widget-subheading">This task has show on hover actions!</div>
                                        </div>
                                        <div class="widget-content-right widget-content-actions">
                                            <button class="border-0 btn-transition btn btn-outline-success">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </div>
                                        <div class="widget-content-right ml-3">
                                            <div class="badge badge-pill badge-success">Latest Task</div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="todo-indicator bg-info"></div>
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left mr-2">
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox" id="exampleCustomCheckbox2444"
                                                       class="custom-control-input">
                                                <label class="custom-control-label" for="exampleCustomCheckbox2444">&nbsp;</label>
                                            </div>
                                        </div>
                                        <div class="widget-content-left mr-3">
                                            <div class="widget-content-left">
                                                <img width="42" class="rounded" src="assets/images/avatars/1.jpg"
                                                     alt="">
                                            </div>
                                        </div>
                                        <div class="widget-content-left">
                                            <div class="widget-heading">Go grocery shopping</div>
                                            <div class="widget-subheading">A short description ...</div>
                                        </div>
                                        <div class="widget-content-right widget-content-actions">
                                            <button class="border-0 btn-transition btn btn-sm btn-outline-success">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <button class="border-0 btn-transition btn btn-sm btn-outline-danger">
                                                <i class="fa fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="todo-indicator bg-success"></div>
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left mr-2">
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox" id="exampleCustomCheckbox3222"
                                                       class="custom-control-input">
                                                <label class="custom-control-label" for="exampleCustomCheckbox3222">&nbsp;</label>
                                            </div>
                                        </div>
                                        <div class="widget-content-left flex2">
                                            <div class="widget-heading">Development Task</div>
                                            <div class="widget-subheading">Finish React ToDo List App</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="badge badge-warning mr-2">69</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <button class="border-0 btn-transition btn btn-outline-success">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <button class="border-0 btn-transition btn btn-outline-danger">
                                                <i class="fa fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <h3 class="drawer-heading">Urgent Notifications</h3>
                <div class="drawer-section">
                    <div class="notifications-box">
                        <div class="vertical-time-simple vertical-without-time vertical-timeline vertical-timeline--one-column">
                            <div class="vertical-timeline-item dot-danger vertical-timeline-element">
                                <div>
                                    <span class="vertical-timeline-element-icon bounce-in"></span>
                                    <div class="vertical-timeline-element-content bounce-in">
                                        <h4 class="timeline-title">All Hands Meeting</h4>
                                        <span class="vertical-timeline-element-date"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="vertical-timeline-item dot-warning vertical-timeline-element">
                                <div>
                                    <span class="vertical-timeline-element-icon bounce-in"></span>
                                    <div class="vertical-timeline-element-content bounce-in">
                                        <p>Yet another one, at <span class="text-success">15:00 PM</span></p>
                                        <span class="vertical-timeline-element-date"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="vertical-timeline-item dot-success vertical-timeline-element">
                                <div>
                                    <span class="vertical-timeline-element-icon bounce-in"></span>
                                    <div class="vertical-timeline-element-content bounce-in">
                                        <h4 class="timeline-title">Build the production release
                                            <div class="badge badge-danger ml-2">NEW</div>
                                        </h4>
                                        <span class="vertical-timeline-element-date"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="vertical-timeline-item dot-primary vertical-timeline-element">
                                <div>
                                    <span class="vertical-timeline-element-icon bounce-in"></span>
                                    <div class="vertical-timeline-element-content bounce-in">
                                        <h4 class="timeline-title">Something not important
                                            <div class="avatar-wrapper mt-2 avatar-wrapper-overlap">
                                                <div class="avatar-icon-wrapper avatar-icon-sm">
                                                    <div class="avatar-icon">
                                                        <img src="assets/images/avatars/1.jpg" alt="">
                                                    </div>
                                                </div>
                                                <div class="avatar-icon-wrapper avatar-icon-sm">
                                                    <div class="avatar-icon">
                                                        <img src="assets/images/avatars/2.jpg" alt="">
                                                    </div>
                                                </div>
                                                <div class="avatar-icon-wrapper avatar-icon-sm">
                                                    <div class="avatar-icon">
                                                        <img src="assets/images/avatars/3.jpg" alt="">
                                                    </div>
                                                </div>
                                                <div class="avatar-icon-wrapper avatar-icon-sm">
                                                    <div class="avatar-icon">
                                                        <img src="assets/images/avatars/4.jpg" alt="">
                                                    </div>
                                                </div>
                                                <div class="avatar-icon-wrapper avatar-icon-sm">
                                                    <div class="avatar-icon">
                                                        <img src="assets/images/avatars/5.jpg" alt="">
                                                    </div>
                                                </div>
                                                <div class="avatar-icon-wrapper avatar-icon-sm">
                                                    <div class="avatar-icon">
                                                        <img src="assets/images/avatars/6.jpg" alt="">
                                                    </div>
                                                </div>
                                                <div class="avatar-icon-wrapper avatar-icon-sm">
                                                    <div class="avatar-icon">
                                                        <img src="assets/images/avatars/7.jpg" alt="">
                                                    </div>
                                                </div>
                                                <div class="avatar-icon-wrapper avatar-icon-sm">
                                                    <div class="avatar-icon">
                                                        <img src="assets/images/avatars/8.jpg" alt="">
                                                    </div>
                                                </div>
                                                <div class="avatar-icon-wrapper avatar-icon-sm avatar-icon-add">
                                                    <div class="avatar-icon"><i>+</i></div>
                                                </div>
                                            </div>
                                        </h4>
                                        <span class="vertical-timeline-element-date"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="vertical-timeline-item dot-info vertical-timeline-element">
                                <div>
                                    <span class="vertical-timeline-element-icon bounce-in"></span>
                                    <div class="vertical-timeline-element-content bounce-in">
                                        <h4 class="timeline-title">This dot has an info state</h4>
                                        <span class="vertical-timeline-element-date"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="vertical-timeline-item dot-dark vertical-timeline-element">
                                <div>
                                    <span class="vertical-timeline-element-icon is-hidden"></span>
                                    <div class="vertical-timeline-element-content is-hidden">
                                        <h4 class="timeline-title">This dot has a dark state</h4>
                                        <span class="vertical-timeline-element-date"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                    <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                </div>
                <div class="ps__rail-y" style="top: 0px; height: 755px; right: 0px;">
                    <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 370px;"></div>
                </div>
            </div>
        </div>
    </div>

</div>

</div>


<div class="botonesflotantes"  id="alertCall" style="display:none;">
    <div class="botonF1" id="bellNotificationCall">
        <div class="widget-content p-0">
            <div class="widget-content-wrapper p-2" style="background: #04a1f4; border-radius: 20px 20px 0px 0px;" id="callsColorTitle">
                <h4 class="widget-content-left" style="color:#fff;padding: 2px;" id="callsTitle"></h4>
                <div class="widget-content-right" id="closeToolbar"></div>
            </div>
        </div>
        <div  style="padding: 20px; position: relative">
            <div class="media">
                <div class="widget-content-left">
                    <div class="widget-heading" style="color: black;"><i style="color:#868383" class="fa fa-user"></i> <span id="nameCalls"></span></div>
                    <div class="widget-subheading" style="color: black;"><i style="color:#868383" class="fa fa-phone"></i> <span id="numberCalls"></span></div>
                </div>
                <input type="hidden" name="name_users" id="name_users">
                <input type="hidden" name="id_name_users" id="id_name_users">
                <input type="hidden" name="hora_llamada" id="hora_llamada">
                <input type="hidden" name="tabla" id="tabla">
                <input type="hidden" name="id_call" id="id_call">
                <input type="hidden" name="audio" id="audio">
                <input type="hidden" name="hora_llamada_terminada" id="hora_llamada_terminada">

                {{--<div class="align-self-center">
                                                    <i style="color:#868383" class="fa fa-phone font-size-40"></i>
                                                </div>
                                                <div class="m-l-15" style="margin-right: 15px;">

                                                    <p style="margin-bottom: -10px;" id="abc"></p>
                                                    <span class="float-item font-size-12 p-t-0" style="color:#868383" id="CronometroCalls"></span>
                                                </div>--}}

            </div>
        </div>
    </div>
</div>



@yield('modal')


@yield('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
{{-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('../assets/scripts/main.js') }} "></script>
<script src="../../vendor/toastr/toastr.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{ asset('/vendor/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset('/vendor/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('../js/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/datepicker/bootstrap-datepicker.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<input type="hidden" name="xurl_socket" id="xurl_socket" value="{{ $userInfo->empresa->url_socket ?? '' }}">
<input type="hidden" name="nameUser" id="nameUser" value="{{ $userInfo->user->name ?? '' }}">
<input type="hidden" name="extUser" id="extUser" value="{{ $userInfo->extension ?? '' }}">
@yield('js')

@if(!empty($userInfo->empresa->url_socket))
    <script src="{{ $userInfo->empresa->url_socket }}/socket.io/socket.io.js"></script>
    <script src="/js/sockets.js"></script>
@endif
<script type="text/javascript">
    function llamada(telf,nombre,id){
     $.ajax({
            type: 'POST',
            url: '/leads/llamada',
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                'telefono':telf,
                'tipo_contacto_id':id
            },
            beforeSend: function () {
                $('#div_mensajes').removeClass('d-none');
                $('#div_mensajes').addClass('text-center');
                $('#mensajes').html('<img src="../images/load.gif" width="5%" height="5%" />');
            },
            success: function (data) {
                console.log(data);
                var d = JSON.parse(data);
                if (d['msg']=='error') {
                  return  toastr.error(d['data']);
                }
                $('#div_mensajes').removeClass('d-none text-center');
                if(d['codigo']==1){
                    toastr.success('Lamando a '+nombre+'...');
                }else{
                    toastr.error(d['mensaje']);
                }
            },
            error: function (xhr) { // if error occured
                toastr.error('Error: ' + xhr.statusText + xhr.responseText);
            },
            complete: function () {
                $('#div_mensajes').addClass('d-none');
            },
            dataType: 'html'
        });
}

function centalTelefonica(telf,nombre,id){
     $.ajax({
            type: 'POST',
            url: '/leads/llamada/conectar',
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                'telefono':telf,
                'tipo_contacto_id':id
            },
            beforeSend: function () {
                $('#div_mensajes').removeClass('d-none');
                $('#div_mensajes').addClass('text-center');
                $('#mensajes').html('<img src="../images/load.gif" width="5%" height="5%" />');
            },
            success: function (data) {
                console.log(data);
                var d = JSON.parse(data);
                if (d['msg']=='success') {
                    toastr.success(d['data']);
                }else{
                    toastr.error(d['data']);

                }
                $('#div_mensajes').removeClass('d-none text-center');
            },
            error: function (xhr) { // if error occured
                toastr.error('Error: ' + xhr.statusText + xhr.responseText);
            },
            complete: function () {
                $('#div_mensajes').addClass('d-none');
            },
            dataType: 'html'
        });
}
</script>
</body>

<!-- Scripts -->


