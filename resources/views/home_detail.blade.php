@php
    function getMonth($month){
        $mes ="";
        switch ($month) {
            case '1':
                $mes = 'ENERO';
                break;
            case '2':
                $mes = 'FEBRERO';
                break;
            case '3':
                $mes = 'MARZO';
                break;
            case '4':
                $mes = 'ABRIL';
                break;
            case '5':
                $mes = 'MAYO';
                break;
            case '6':
                $mes = 'JUNIO';
                break;
            case '7':
                $mes = 'JULIO';
                break;
            case '8':
                $mes = 'AGOSTO';
                break;
            case '9':
                $mes = 'SEPTIEMBRE';
                break;
            case '10':
                $mes = 'OCTUBRE';
                break;
            case '11':
                $mes = 'NOVIEMBRE';
                break;
            case '12':
                $mes = 'DICIEMBRE';
                break;
        }
        return $mes;
    }
@endphp

<div class="tabs-animation">

    <div class="row">

        <div class="col-lg-12 col-xl-12">
            <div class="main-card mb-3 card">
                <div class="grid-menu grid-menu-2col">
                    <div class="no-gutters row">

                        <div class="col-sm-3">
                            <div class="widget-chart widget-chart-hover">
                                <div class="icon-wrapper rounded-circle">
                                    <div class="icon-wrapper-bg bg-danger"></div>
                                    <i class="lnr-laptop-phone text-danger"></i>
                                </div>
                                <div class="widget-numbers">{{ $totalLeads }}</div>
                                <div class="widget-subheading">Total de Leads</div>
                                <div class="widget-description text-primary">
                                    <i class="fa fa-arrow-right"></i>
                                    <span class="pr-1">Total de leads ingresados</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="widget-chart widget-chart-hover">
                                <div class="icon-wrapper rounded-circle">
                                    <div class="icon-wrapper-bg bg-info"></div>
                                    <i class="lnr-graduation-hat text-info"></i>
                                </div>
                                <div class="widget-numbers">{{ $totalClientes }}</div>
                                <div class="widget-subheading">Total de Clientes</div>
                                <div class="widget-description text-info">
                                    <i class="fa fa-arrow-right"></i>
                                    <span class="pl-1">Total de clientes inscritos</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="widget-chart widget-chart-hover">
                                <div class="icon-wrapper rounded-circle">
                                    <div class="icon-wrapper-bg bg-primary"></div>
                                    <i class="lnr-cog text-primary"></i>
                                </div>
                                <div class="widget-numbers">{{ $totalCampana }}</div>
                                <div class="widget-subheading">Campañas Activas</div>
                                <div class="widget-description text-success">
                                    <br>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="widget-chart widget-chart-hover br-br">
                                <div class="icon-wrapper rounded-circle">
                                    <div class="icon-wrapper-bg bg-success"></div>
                                    <i class="lnr-screen"></i>
                                </div>
                                <div class="widget-numbers">{{ $totalFteContacto }}</div>
                                <div class="widget-subheading">Fuentes de Contacto</div>
                                <div class="widget-description text-warning">
                                  <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-12 col-xl-12">
        <div class="row">
            <div class="col-lg-12 col-xl-3">
                <select id="campana" type="select" class="custom-select" onchange="cargardashboard()">
                    <option value="0">Todas las Campañas</option>
                    @if($lstCampana)
                        @foreach($lstCampana as $campana)
                            <option @if($campana->id == session('campana')) selected
                                    @else  @endif value="{{$campana->id}}">{{$campana->nombre}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-lg-12 col-xl-3">
                <select id="nprimario" type="select" class="custom-select" onchange="cargardashboard()">
                    <option value="0">Todas las {{session('nivel1')}}</option>
                    @if($ofertaCadamicas)
                        @foreach($ofertaCadamicas as $oferta)
                            <option @if($oferta->nprimario_id == session('d_nivel1')) selected
                                    @else  @endif value="{{$oferta->nprimario_id}}">{{$oferta->nombre}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <br>
        <div class="mb-3 card">
            <div class="card-header-tab card-header">
                <div class="card-header-title">
                    <i class="header-icon lnr-rocket icon-gradient bg-tempting-azure"> </i>
                    RESUMEN POR FUENTE DE CONTACTO
                </div>
                <div class="btn-actions-pane-right">
                    <div class="nav">
                        <a href="#tab-eg-55" data-toggle="tab" class="ml-1 btn-pill btn-wide border-0 btn-transition btn btn-outline-alternate second-tab-toggle-alt active ">LEADS
                        </a>
                        <a href="#tab-eg-66" data-toggle="tab" class="border-0 btn-pill btn-wide btn-transition btn btn-outline-alternate">CLIENTES
                        </a>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade active show" id="tab-eg-55">
                    <div class="card-body">
                        <div class="widget-chart-wrapper widget-chart-wrapper-lg opacity-10 m-0">
                            <div>
                                <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                        <div class=""></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div class=""></div>
                                    </div>
                                </div>
                                <canvas id="myChart" width="667" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-eg-66">
                    <div class="card-body">
                        <div class="widget-chart-wrapper widget-chart-wrapper-lg opacity-10 m-0">
                            <div>
                                <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                        <div class=""></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div class=""></div>
                                    </div>
                                </div>
                                <canvas id="myChartCli" width="667" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-xs-12">
            <div class="main-card mb-3 card">
                <div class="card-header">Leads por {{session('nivel1')}}
                    <div class="btn-actions-pane-right text-capitalize">
                        <button class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm"
                                data-toggle="modal" data-target=".modal-oferta">Ver Detalle
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="widget-chart-wrapper widget-chart-wrapper-lg opacity-10 m-0">
                        <div>
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <canvas id="oferta_academica" width="667" height="283"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xs-12">
            <div class="main-card mb-3 card">
                <div class="card-header">Leads Por Oferta Academica - {{ getMonth(date('m')) }}
                </div>
                <div class="card-body">
                    <div class="widget-chart-wrapper widget-chart-wrapper-lg opacity-10 m-0">
                        <div>
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <canvas id="oferta_academica_mes" width="667" height="283"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-xs-12">
            <div class="main-card mb-3 card">
                <div class="card-header">Leads por estado comercial
                    <div class="btn-actions-pane-right text-capitalize">
                        <button class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm"
                                data-toggle="modal" data-target=".modal-estado">Ver Detalle
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="widget-chart-wrapper widget-chart-wrapper-lg opacity-10 m-0">
                        <div>
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <canvas id="estado_comercial" width="667" height="283"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xs-12">
            <div class="main-card mb-3 card">
                <div class="card-header">Leads por estado comercial - {{ getMonth(date('m')) }}
                </div>
                <div class="card-body">
                    <div class="widget-chart-wrapper widget-chart-wrapper-lg opacity-10 m-0">
                        <div>
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <canvas id="estado_comercial_mes" width="667" height="283"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

