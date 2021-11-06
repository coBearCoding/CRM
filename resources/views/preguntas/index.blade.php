@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="../vendor/datatables/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="../../vendor/select2/select2.min.css">
@stop

@section('js')
    <script src="{{ asset('../js/preguntas_enc.js') }}"></script>
    <script src="../../vendor/datatables/js/jquery.dataTables.js"></script>
    <script src="../../vendor/datatables/js/dataTables.bootstrap4.js"></script>
    <script src="../../vendor/select2/select2.min.js"></script>
@stop

@section('title')
    <div class="page-title-heading">
        <div class="page-title-icon">
            <i class="pe-7s-config icon-gradient bg-strong-bliss">
            </i>
        </div>
        <div>Configuración
            <div class="page-title-subheading">Preguntas de Encuestas
            </div>
        </div>
    </div>
@endsection

@section('content')

    <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
        <li class="nav-item">
            <a role="tab" class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="tab"
               href="#custom-tabs-one-home">
                <span>Ingreso de Preguntas de Encuestas</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="tab"
               href="#custom-tabs-one-profile">
                <span>Listado de Preguntas de Encuestas</span>
            </a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane tabs-animation fade show active" id="custom-tabs-one-home" role="tabpanel">
            <div class="row">
                <div class="col-md-12">

                    <div class="main-card mb-3 card element-block-example">
                        <form id="form" class="form-horizontal">
                            {{ csrf_field() }}
                            <input type="hidden" class="form-control" id="hide_id" name="hide_id"/>
                            <div class="card-body">

                                <div class="form-group row">
                                    <label for="nombre" class="col-sm-2 control-label">{{session('nivel1')}} </label>
                                    <div class="col-sm-8">
                                        <select id="sl_nivelprimario" name="sl_nivelprimario" class="form-control">
                                            <option value="">SELECCIONE</option>
                                            @foreach($nivel_primario as $dato)
                                                <option value="{{$dato->id}}"> {{$dato->nombre}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="nombre" class="col-sm-2 control-label">Grupo Pregunta </label>
                                    <div class="col-sm-8">
                                        <select id="sl_grupo" name="sl_grupo" class="form-control">
                                            <option value="">SELECCIONE</option>
                                            @foreach($lstDatos as $dato)
                                                <option value="{{$dato->id}}"> {{$dato->nombre}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="cedula" class="col-sm-2 col-form-label">Pregunta</label>
                                    <div class="col-sm-8">
                                        <textarea id="texto_pregunta" type="text" class="form-control"
                                                  placeholder=" " maxlength="150" rows="2"></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 control-label">Tipo Respuesta</label>
                                    <div class="col-sm-8">
                                        <select id="sl_subgrupo" name="sl_subgrupo" class="form-control" onchange="validar_respuesta()">
                                            <option data-opcion="S" value="">Selecione Tipo</option>
                                            <option data-opcion="S" value="TEXT">TEXT</option>
                                            <option data-opcion="S" value="TEXTAREA">TEXTAREA</option>
                                            <option data-opcion="M" value="COMBO">COMBO</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="div_multiple" class="d-none">
                                    <div class="form-group row">
                                        <label for="num_respuesta" class="col-sm-2 control-label">Respuestas</label>
                                        <div class="col-sm-8">
                                            <input id="num_respuestas_resp" class="form-control d-none">
                                            <input type="number" min="1" id="num_respuesta"
                                                   onchange="ver_respuesta()"
                                                   class="form-control" value="1"
                                                   style="width: 200px;" placeholder="Cantidad de Respuestas">
                                        </div>
                                    </div>
                                    <div id="div_respuesta">
                                        <div class="form-group row div_respuesta" id="div_respuesta_1">
                                            <label id="lbl_respuesta_1" class="col-sm-2 control-label">Respuesta N°
                                                1</label>
                                            <div class="col-sm-8">
                                                <input id="cmb_respuesta_1" class="form-control cmb_respuesta">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="chk_estado" class="col-sm-2 col-form-label">Estado</label>
                                    <div class="col-sm-10">
                                        <div class="custom-checkbox custom-control custom-control-inline">
                                            <input type="checkbox" id="chk_estado" name="chk_estado"
                                                   class="custom-control-input" checked>
                                            <label class="custom-control-label" for="chk_estado">ACTIVO / INACTIVO</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block text-right card-footer">
                                <button type="button" onclick="clear_data();" class="mr-2 btn btn-link btn-sm">CANCELAR</button>
                                <button type="button" id="btn_guardar" class="btn btn-success btn-lg">GUARDAR</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane tabs-animation fade" id="custom-tabs-one-profile" role="tabpanel">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-12 card">
                        <div class="card-body">
                            <div id="div_table">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop






