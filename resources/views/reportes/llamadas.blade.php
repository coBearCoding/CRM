@extends('layouts.admin')

@section('css')

{{--<link rel="stylesheet" href="{{ asset('vendor/select2/select2-bootstrap.css')}}">--}}
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('vendor/datepicker/bootstrap-datepicker3.css')}}">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="{{ asset('../js/llamadas.js') }}"></script>
@stop

@section('title')
    <div class="page-title-heading">
        <div class="page-title-icon">
            <i class="pe-7s-graph icon-gradient bg-strong-bliss">
            </i>
        </div>
        <div>Reportes
            <div class="page-title-subheading">Llamadas
            </div>
        </div>
    </div>
@endsection

@section('content')
    <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
        <li class="nav-item">
            <a role="tab" class="nav-link active" id="tab-0" data-toggle="tab" href="#tab-content-0" aria-selected="true">
                <span>Filtro de llamadas</span>
            </a>
        </li>
        
    </ul>


    <div class="tab-content">
        <div class="tab-pane tabs-animation fade active show" id="tab-content-0" role="tabpanel">

             <div class="row">
                <div class="col-md-12">

                    <div class="card-shadow-primary border mb-3 card border-primary">
                        <form action="{{ route('reporte.llamadas_reporte') }}" method="POST" target="_blank">
                            <div class="card-body">
                                @csrf
                                <div class="row">
                                    <div class="col">
                                      <div class="form-group">
                                        <label for="sedes">Sede</label>
                                        <select id="sedes" name="sedes"  class="form-control">
                                        	<option value="-1">Todos</option>
                                             @foreach($sede as $sedes)
                                            <option value="{{ $sedes->id }}">{{$sedes->nombre}}</option>
                                            @endforeach
                                        </select>
                                      </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                        <label for="estado">Estados</label>
                                        <select id="estado" name="estado"  class="form-control">
                                        	<option value="-1">Todos</option>
                                            <option value="Success" title="Filtra las llamadas con estado terminadas">Exitosas</option>
                                            <option value="Abandoned" title="Filtra las llamadas con estado abandonadas o fallidas">Fallidas</option>
											
                                        </select>
                                      </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                      <div class="form-group">
                                        <label for="nivel">Nivel Primario</label>
                                        <select id="nivel" name="nivel"  class="form-control">
                                        	<option value="-1">Todos</option>
                                        	
                                            
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
                                            <label for="">Asesor</label><br>
                                            <select id="asesor" name="asesor"  class="form-control">
                                            <option value="-1">Todos</option>
                                            
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Reporte</label><br>
                                            <div class="form-check form-check-inline">
                                              <input class="form-check-input" type="radio" name="reporte" id="excel" value="excel" checked="true">
                                              <label class="form-check-label" for="excel">Excel</label>
                                            </div>
                                            <!--<div class="form-check form-check-inline">
                                              <input class="form-check-input" type="radio" name="reporte" id="pdf" value="pdf">
                                              <label class="form-check-label" for="pdf">Pdf</label>
                                            </div>-->
                                        </div>
                                    </div>
                                </div>

                              
                            </div>
                          <div class="d-block text-right card-footer">
                                <button onclick="clear_data();" class="mr-2 btn btn-link btn-sm">Cancelar</button>
                                <button type="submit" id="btn_generar" class="btn btn-success btn-lg">Generar</button>
                            </div>
                        </form>           
                    </div>
                </div>
            </div>
            



        </div>

        

  
    </div>
@stop