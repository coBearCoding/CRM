@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" type="text/css" href="../../vendor/select2/select2.min.css">
@endsection

@section('js')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script> --}}
    <script src="{{ asset('../js/dashboard.js') }}"></script>
    <script src="../../vendor/select2/select2.min.js"></script>
@stop





@section('title')
    <div class="page-title-heading">
        <div class="page-title-icon">
            <i class="pe-7s-graph icon-gradient bg-ripe-malin"></i>
        </div>
        <div>CRM Dashboard
            <div class="page-title-subheading">Resumen de Leads/Clientes</div>
        </div>
    </div>
    <div class="page-title-actions">
        <div class="d-inline-block pr-3">
            <select id="periodo" type="select" class="custom-select" onchange="cargardashboard()">
                @if($lstPeriodo)
                <option value="0">Todos</option>
                    @foreach($lstPeriodo as $periodo)
                        <option @if($periodo->id == session('periodo')) selected
                                @else  @endif value="{{$periodo->id}}">{{$periodo->anio}}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
@endsection


@section('content')


    <div id="dashboard">

    </div>



@endsection

@section('modal')

    <!-- Modal -->
    <div class="modal fade modal-oferta" tabindex="-1" id="ofertaModal" role="dialog"
         aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Leads por Oferta Academica</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="oferta" class="col-sm-3 col-form-label">Oferta Academica</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="oferta" id="oferta">
                                <option value="" selected disabled>Seleccione</option>
                                @foreach ($ofertaCadamicas as $element)
                                    <option value="{{ $element->id }}">{{ $element->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="widget-chart-wrapper widget-chart-wrapper-lg opacity-10 m-0">
                        <div id="oferta_view">
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <canvas id="ofertaChart" width="667" height="283"></canvas>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade modal-estado" tabindex="-1" id="estadoModal" role="dialog"
         aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Leads por Estado Comercial</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="estado" class="col-sm-3 col-form-label">Oferta Academica</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="estado" id="estado">
                                <option value="" selected disabled>Seleccione</option>
                                @foreach ($ofertaCadamicas as $element)
                                    <option value="{{ $element->id }}">{{ $element->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="widget-chart-wrapper widget-chart-wrapper-lg opacity-10 m-0">
                        <div id="estado_view">
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <canvas id="estadoChart" width="667" height="283"></canvas>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

@endsection
