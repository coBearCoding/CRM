@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="../vendor/datatables/css/dataTables.bootstrap4.css">
@stop

@section('js')
    <script src="{{ asset('../js/mgestion.js') }}"></script>
    <script src="../../vendor/datatables/js/jquery.dataTables.js"></script>
    <script src="../../vendor/datatables/js/dataTables.bootstrap4.js"></script>
@stop

@section('title')
    <div class="page-title-heading">
        <div class="page-title-icon">
            <i class="pe-7s-config icon-gradient bg-strong-bliss">
            </i>
        </div>
        <div>Configuración
            <div class="page-title-subheading">Medios de Gestión
            </div>
        </div>
    </div>
@endsection

@section('content')

    <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
        <li class="nav-item">
            <a role="tab" class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="tab"
               href="#custom-tabs-one-home">
                <span>Ingreso de Medios de Gestión</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="tab"
               href="#custom-tabs-one-profile">
                <span>Listado de Medios de Gestión</span>
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
                                    <label for="txt_nombre" class="col-sm-2 col-form-label">Nombre</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="txt_nombre" name="txt_nombre"
                                               maxlength="50" placeholder="Ingrese el nombre">
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






