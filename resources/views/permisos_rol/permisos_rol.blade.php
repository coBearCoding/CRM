@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="../vendor/datatables/css/dataTables.bootstrap4.css">
@stop

@section('js')
    <script src="{{ asset('../js/permisosrol.js') }}"></script>
    <script src="../../vendor/datatables/js/jquery.dataTables.js"></script>
    <script src="../../vendor/datatables/js/dataTables.bootstrap4.js"></script>
@stop

@section('title')
    <div class="page-title-heading">
        <div class="page-title-icon">
            <i class="pe-7s-box2 icon-gradient bg-strong-bliss">
            </i>
        </div>
        <div>Configuración
            <div class="page-title-subheading">Permisos por Rol.
            </div>
        </div>
    </div>
@endsection

@section('content')

    <div class="tab-content">
        <div class="tab-pane tabs-animation fade show active" id="custom-tabs-one-home" role="tabpanel">
            <div class="row">
                <div class="col-md-12">

                    <div class="main-card mb-3 card element-block-example">
                        <form id="form" class="form-horizontal">
                            {{ csrf_field() }}
                            <input type="hidden" class="form-control" id="hide_id" name="hide_id"/>
                            <div class="card-body">

                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label for="txt_nombre" class="col-sm-2 col-form-label">Seleccione Rol</label>
                                        <div class="col-sm-10">
                                            <select id="rol" name="rol" type="select" class="custom-select" onchange="view_table();">
                                                <option value="0">....</option>
                                                @foreach($lstRoles as $rol)
                                                    <option @if($rol->id == Auth::user()->rol_id) selected
                                                            @else  @endif value="{{$rol->id}}">{{$rol->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                </div>

                                <div id="div_table">

                                </div>

                            </div>
                            <div class="d-block text-right card-footer">
                                <button type="button" onclick="location.reload();" class="mr-2 btn btn-link btn-sm">CANCELAR</button>
                                <button type="button" id="btn_guardar" class="btn btn-success btn-lg">GUARDAR</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop






