@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="../vendor/datatables/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="../../vendor/select2/select2.min.css">
@stop

@section('js')
    <script src="{{ asset('../js/metas.js') }}"></script>
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
        <div>Gestión
            <div class="page-title-subheading">Metas
            </div>
        </div>
    </div>
@endsection

@section('content')

    <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
        <li class="nav-item">
            <a role="tab" class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="tab"
               href="#custom-tabs-one-home">
                <span>Ingreso de Metas</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="tab"
               href="#custom-tabs-one-profile">
                <span>Listado de Metas</span>
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
                            <input type="hidden" class="form-control" id="codigo_id" name="codigo_id"/>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="nombre" name="nombre"
                                               maxlength="50" placeholder="Ingrese el nombre">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="sede_id"
                                           class="col-sm-2 col-form-label">Sede</label>
                                    <div class="col-sm-4">
                                        <select name="sede_id" id="sede_id" class="cmb_nprimario form-control">
                                            @foreach($lstSede as $dato)
                                                <option value="{{$dato->id}}"> {{$dato->nombre}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label for="sede_id" style="text-align:right"
                                           class="col-sm-2 col-form-label">{{session('nivel1')}}</label>
                                    <div class="col-sm-4">
                                        <select name="nivel1_id" id="nivel1_id" class="cmb_nprimario form-control">
                                            @foreach($lstNivel1 as $dato)
                                                <option value="{{$dato->id}}"> {{$dato->nombre}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="exampleEmail" class="col-sm-2 col-form-label">Detalle : </label>
                                    <div class="col-sm-10">
                                    <textarea class="form-control autosize-input" id="detalle"
                                              name="detalle"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="exampleEmail" class="col-sm-2 col-form-label">Fecha Inicio : </label>
                                    <div class="col-sm-4">
                                        <input type="date" id="fch_inicio" name="fch_inicio" class="form-control"
                                               data-date-format='yyyy-mm-dd'/>
                                    </div>

                                    <label style="text-align:right" for="exampleEmail" class="col-sm-2 col-form-label">Fecha
                                        Finalización : </label>
                                    <div class="col-sm-4">
                                        <input name="fch_fin" id="fch_fin" type="date" class="form-control"
                                               data-date-format='yyyy-mm-dd'>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="exampleEmail" class="col-sm-2 col-form-label">Alcance N° Leads </label>
                                    <div class="col-sm-4">
                                        <input type="number" id="num_lead" name="num_lead" class="form-control"
                                               data-date-format='yyyy-mm-dd'/>
                                    </div>

                                    <label style="text-align:right" for="exampleEmail" class="col-sm-2 col-form-label">Alcance N° Clientes</label>
                                    <div class="col-sm-4">
                                        <input name="num_cliente" id="num_cliente" type="number" class="form-control"
                                               data-date-format='yyyy-mm-dd'>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="lbl_estado" class="col-sm-2  col-form-label">Estado : </label><br>
                                    <div class="col-sm-4">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="estadoSi" name="estado"
                                                   class="custom-control-input" checked value="A">
                                            <label class="custom-control-label" for="estadoSi">Activo</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="estadoNO" name="estado"
                                                   class="custom-control-input" value="I">
                                            <label class="custom-control-label" for="estadoNO">Inactivo</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-block text-right card-footer">
                                <button onclick="clear_data();" class="mr-2 btn btn-link btn-sm">CANCELAR</button>
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


