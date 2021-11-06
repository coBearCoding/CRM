@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="../vendor/datatables/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="../../vendor/select2/select2.min.css">
@stop

@section('js')
    <script src="{{ asset('../js/permisos.js') }}"></script>
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
        <div>Administración
            <div class="page-title-subheading">Permisos
            </div>
        </div>
    </div>
@endsection

@section('content')

    <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
        <li class="nav-item">
            <a role="tab" class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="tab"
               href="#custom-tabs-one-home">
                <span>Ingreso de Permisos</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="tab"
               href="#custom-tabs-one-profile">
                <span>Listado de Permisos</span>
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
                                    <label for="txt_nombre" class="col-sm-2 col-form-label">Tipo Permiso</label>
                                    <div class="col-sm-4">
                                        <div>
                                            <div class="custom-radio custom-control custom-control-inline">
                                                <input type="radio" value="P" name="chk_tipo" id="chk_princ"
                                                       class="custom-control-input chk_tipo">
                                                <label class="custom-control-label" for="chk_princ">Principal</label>
                                            </div>
                                            <div class="custom-radio custom-control custom-control-inline">
                                                <input type="radio" value="S" name="chk_tipo" id="chk_secun"
                                                       class="custom-control-input chk_tipo">
                                                <label class="custom-control-label" for="chk_secun">Secundario</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label for="txt_nombre" class="col-sm-2 col-form-label">Nombre</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="txt_nombre" name="txt_nombre"
                                               maxlength="50" placeholder="Ingrese el nombre">
                                    </div>
                                </div>
                                <div id="div_secu" class="d-none">
                                    <div class="form-group row">
                                        <label for="cmb_nprimario"
                                               class="col-sm-2 col-form-label">Principal</label>
                                        <div class="col-sm-8">
                                            <select name="cmb_menu" id="cmb_menu"
                                                    class="cmb_menu form-control">
                                                @foreach($lstMenu as $dato)
                                                    <option value="{{$dato->id}}"> {{$dato->nombre}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txt_enlace" class="col-sm-2 col-form-label">Enlace</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="txt_enlace" name="txt_enlace" readonly
                                                   maxlength="50" placeholder="">
                                        </div>
                                    </div>
                                </div>

                                <div id="div_prin" class="d-none">
                                    <div class="form-group row">
                                        <label for="txt_prefijo" class="col-sm-2 col-form-label">Prefijo</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="txt_prefijo" name="txt_prefijo"
                                                   maxlength="50" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txt_nombre" class="col-sm-2 col-form-label">Icono</label>
                                        <div class="col-sm-8">
                                            <select name="cmb_iconos" id="cmb_iconos" style="width: 250px;"
                                                    class="cmb_iconos form-control-sm form-control" onchange="visual();">
                                                @foreach($lstIconos as $iconos)
                                                    <option data-logo="{{$iconos->nombre}}"
                                                            value="{{$iconos->nombre}}">
                                                        {{$iconos->nombre}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <div id="n_icon" class="font-icon-wrapper">
                                            <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                                                <span class="icon-wrapper-bg bg-primary"></span>
                                                <i class="icon text-primary pe-7s-help1"></i>

                                            </span>
                                                <p id="t_icon">pe-7s-help1</p>
                                            </div>
                                            <p class="text-center">Vista Previa</p>
                                        </div>
                                    </div>


                                </div>

                                <div class="form-group row">
                                    <label for="chk_estado" class="col-sm-2 col-form-label">Estado</label>
                                    <div class="col-sm-8">
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






