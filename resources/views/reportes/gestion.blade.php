@extends('layouts.admin')

@section('css')

{{--<link rel="stylesheet" href="{{ asset('vendor/select2/select2-bootstrap.css')}}">--}}
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('vendor/datepicker/bootstrap-datepicker3.css')}}">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="{{ asset('../js/reporte-estado.js') }}"></script>
@stop

@section('title')
    <div class="page-title-heading">
        <div class="page-title-icon">
            <i class="pe-7s-graph icon-gradient bg-strong-bliss">
            </i>
        </div>
        <div>Reportes
            <div class="page-title-subheading">Gestión Leads/Clientes
            </div>
        </div>
    </div>
@endsection

@section('content')
    <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
        <li class="nav-item">
            <a role="tab" class="nav-link active" id="tab-0" data-toggle="tab" href="#tab-content-0" aria-selected="true">
                <span>Estado Comercial</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link" id="tab-2" data-toggle="tab" href="#tab-content-1" aria-selected="false">
                <span>Listado de Contacto</span>
            </a>
        </li>
    </ul>


    <div class="tab-content">
        <div class="tab-pane tabs-animation fade active show" id="tab-content-0" role="tabpanel">

             <div class="row">
                <div class="col-md-12">

                    <div class="card-shadow-primary border mb-3 card border-primary">
                        <form action="{{ route('reporte.tipo') }}" method="POST" target="_blank">
                            <div class="card-body">
                                @csrf
                                <div class="row">
                                    <div class="col">
                                      <div class="form-group">
                                        <label for="estado">Estado Comercial</label>
                                        <select id="estado_comercial" name="estado_comercial[]"  class="form-control"  multiple="multiple">
                                            @foreach($estado_comercial as $estado)
                                            <option value="{{ $estado->id }}">{{$estado->nombre}}</option>
                                            @endforeach
                                        </select>
                                      </div>
                                    </div>
                                    <div class="col">
                                        <div class="col-md-12 mb-3">
                                          <label for="validationCustom01">Fecha</label>
                                          <input type="hidden" name="fecha_ini" id="fecha_ini">
                                          <input type="hidden" name="fecha_fin" id="fecha_fin">
                                          <div id="fecha" style="background: #fff; cursor: pointer; padding: 6px 10px; border: 1px solid #ccc; width: 100%;border-radius: 5px;">
                                                <i class="fa fa-calendar"></i>&nbsp;
                                                <span></span> <i class="fa fa-caret-down"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                        <label for="">{{session('nivel1')}}</label><br>
                                        <select class="form-control" name="oferta_academica_r" id="oferta_academica_r">
                                            @if(count($NivelPrimarios)>1)
                                            <option value="">Todos</option>
                                            @endif
                                            @foreach ($NivelPrimarios as $oferta)
                                            <option value="{{ $oferta->nprimario->id }}" @if(count($NivelPrimarios)==1) selected @endif>{{ $oferta->nprimario->nombre }}</option>
                                            @endforeach
                                        </select>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">

                                        <label for="">Programa</label><br>
                                        <select class="form-control" name="programa_r" id="programa_r">
                                            <option value="">Todos</option>

                                        </select>
                                        </div>
                                    </div>


                                </div>
                                <div class="row">
                                     <div class="col">
                                        <div class="form-group">
                                            <label for="">Tipo de Reporte</label><br>
                                            <select id="tipo_reporte" name="tipo_reporte"  class="form-control">
                                            <option value="1" selected>Por estados de comercialización</option>
                                            <option value="2">Por fuente de contacto</option>
                                            <option value="3">Por Seguimiento</option>
                                            <option value="4">Por No Interesado</option>
                                            <option value="5">Por estados de seguimiento</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Reporte</label><br>
                                            <div class="form-check form-check-inline">
                                              <input class="form-check-input" type="radio" name="reporte" id="excel" value="excel" checked>
                                              <label class="form-check-label" for="excel">Excel</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                              <input class="form-check-input" type="radio" name="reporte" id="pdf" value="pdf">
                                              <label class="form-check-label" for="pdf">Pdf</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                          <div class="d-block text-right card-footer">
                                <button onclick="clear_data();" class="mr-2 btn btn-link btn-sm">Cancelar</button>
                                <button type="submit" id="btn_guardar" class="btn btn-success btn-lg">Generar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>




        </div>

        <div class="tab-pane tabs-animation fade" id="tab-content-1" role="tabpanel">



            <div class="row">
                <div class="col-md-12">

                    <div class="card-shadow-primary border mb-3 card border-primary">
                        <form action="{{ route('reporte.contacto') }}" method="POST" target="_blank">
                            <div class="card-body">
                                @csrf
                                <div class="row">
                                    <div class="col">
                                      <div class="form-group">
                                        <label for="estado">Estado Comercial</label>
                                        <select id="estado_comercial_lc" name="estado_comercial_lc"  class="form-control">
                                            <option value="">Todos</option>
                                            @foreach($estado_comercial as $estado)
                                            <option value="{{ $estado->id }}">{{$estado->nombre}}</option>
                                            @endforeach
                                        </select>
                                      </div>
                                    </div>
                                    <div class="col">
                                        <div class="col-md-12 mb-3">
                                          <label for="validationCustom01">Fecha</label>
                                          <input type="hidden" name="fecha_ini_lc" id="fecha_ini_lc">
                                          <input type="hidden" name="fecha_fin_lc" id="fecha_fin_lc">
                                          <div id="fecha_lc" style="background: #fff; cursor: pointer; padding: 6px 10px; border: 1px solid #ccc; width: 100%;border-radius: 5px;">
                                                <i class="fa fa-calendar"></i>&nbsp;
                                                <span></span> <i class="fa fa-caret-down"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">

                                        <label for="">Fuente de Contacto</label><br>
                                        <select class="form-control" name="fuente_contacto" id="fuente_contacto">
                                            <option value="">Todos</option>
                                            @foreach ($FuentesContactos as $element)
                                            <option value="{{ $element->id }}">{{ $element->nombre }}</option>
                                            @endforeach
                                        </select>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">

                                        <label for="">{{session('nivel1')}}</label><br>
                                        <select class="form-control" name="oferta_academica" id="oferta_academica">
                                             @if(count($NivelPrimarios)>1)
                                            <option value="">Todos</option>
                                            @endif
                                            @foreach ($NivelPrimarios as $oferta)
                                            <option value="{{ $oferta->nprimario->id }}" @if(count($NivelPrimarios)==1) selected @endif>{{ $oferta->nprimario->nombre }}</option>
                                            @endforeach
                                        </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">

                                        <label for="">{{session('nivel2')}}</label><br>
                                        <select class="form-control" name="programa" id="programa">
                                            <option value="">Todos</option>

                                        </select>
                                        </div>
                                    </div>

                                     <div class="col">
                                        <div class="form-group">
                                            <label for="">Tipo de Reporte</label><br>
                                            <select id="tipo_contacto" name="tipo_contacto"  class="form-control">
                                            <option value="1" selected>Leads</option>
                                            <option value="2">Clientes</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Reporte</label><br>
                                            <div class="form-check form-check-inline">
                                              <input class="form-check-input" type="radio" name="reporte_lc" id="excel_lc" value="excel" checked>
                                              <label class="form-check-label" for="excel">Excel</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                              <input class="form-check-input" type="radio" name="reporte_lc" id="pdf_lc" value="pdf">
                                              <label class="form-check-label" for="pdf">Pdf</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                          <div class="d-block text-right card-footer">
                                <button onclick="clear_data();" class="mr-2 btn btn-link btn-sm">Cancelar</button>
                                <button type="submit" id="btn_guardar_lc" class="btn btn-success btn-lg">Generar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



        </div>


    </div>
@stop
