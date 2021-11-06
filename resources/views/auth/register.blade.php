@extends('layouts.admin')


@section('css')
    <link rel="stylesheet" href="../vendor/datatables/css/dataTables.bootstrap4.css">
    <style type="text/css">
        #form label[tipo="error"]{
            display: none;
            font-size: 12px;
            color: #fe0000;
        }
    </style>
@stop

@section('js')
    <script>
        var nivelprimario = '<?php echo session('nivel1');?>';
    </script>
    <script src="{{ asset('../js/general.js') }}"></script>
    <script src="{{ asset('../js/usuarios.js') }}"></script>
    <script src="../../vendor/datatables/js/jquery.dataTables.js"></script>
    <script src="../../vendor/datatables/js/dataTables.bootstrap4.js"></script>


@stop

@section('title')
    <div class="page-title-heading">
        <div class="page-title-icon">
            <i class="pe-7s-lock  icon-gradient bg-strong-bliss">
            </i>
        </div>
        <div>Configuración
            <div class="page-title-subheading">Listado de Usuario.
            </div>
        </div>
    </div>

@endsection

@section('content')

    <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
        <li class="nav-item">
            <a role="tab" class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="tab"
               href="#custom-tabs-one-home">
                <span>Ingreso de Usuarios</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="tab"
               href="#custom-tabs-one-profile">
                <span>Listado de Usuarios</span>
            </a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane tabs-animation fade show active" id="custom-tabs-one-home" role="tabpanel">
            <div  class="card">
                <div class="row">
                    <div class="col-lg-8 col-md-12">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <form class="form-horizontal" id="form" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" class="form-control" id="hide_id" name="hide_id"/>
                                    <div class="form-group row">
                                        <label for="txt_nombre" class="col-sm-2 col-form-label">Nombre</label>
                                        <div class="col-sm-10">
                                            <div class="input-group mb-3">
                                                <input  maxlength="80" type="text" name="name" id="name"
                                                       class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                       value="{{ old('name') }}"
                                                       placeholder="Ingrese nombres y apellidos" autofocus>
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-user"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txt_nombre" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <div class="input-group mb-3">
                                                <input maxlength="80" type="email" name="email" id="email"
                                                       class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                                       value="{{ old('email') }}"
                                                       placeholder="Ingrese email">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-envelope"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <label tipo="error" id="email-error"></label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="txt_descripcion" class="col-sm-2 col-form-label">Sede</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="idsede" name="idsede">
                                                <option value="">Seleccione sede</option>
                                                @foreach ($lstSede as $sede)
                                                    <option value="{{$sede->id}}">{{$sede->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="txt_descripcion" class="col-sm-2 col-form-label">Rol</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="idrol" name="idrol">
                                                <option value="">Seleccione un rol</option>
                                                @foreach ($lstRoles as $rol)
                                                    <option value="{{$rol->id}}">{{$rol->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="txt_descripcion" class="col-sm-2 col-form-label">Empresa
                                            </label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="idempresa" name="idempresa" readonly>
                                                @if(!empty($lstEntidades))
                                                    @foreach ($lstEntidades as $ent)
                                                        <option value="{{$ent->id}}">{{$ent->nombre}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="txt_descripcion" class="col-sm-2 col-form-label">Teléfono
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="text" name="telefono" id="telefono"
                                                   class="form-control"
                                                   value="{{ old('name') }}"
                                                    maxlength="9" placeholder="042000000" onkeypress="javascript: return validaNumericos(event);" >
                                        </div>
                                        <label for="txt_descripcion" class="col-sm-2 col-form-label">Celular
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="text" name="celular" id="celular"
                                                   class="form-control"
                                                   value="{{ old('name') }}"
                                                   maxlength="10" placeholder="0000000000" onkeypress="javascript: return validaNumericos(event);">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="txt_nombre" class="col-sm-2 col-form-label">Contraseña</label>
                                        <div class="col-sm-10">
                                            <div class="input-group mb-3">
                                                <input type="password" name="password" id="password"
                                                       class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                                       placeholder="Ingrese contraseña">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-lock"></span>
                                                    </div>
                                                </div>
                                                @if ($errors->has('password'))
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                             <label tipo="error" id="password-error"></label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="txt_nombre" class="col-sm-2 col-form-label">Confirmar contraseña</label>
                                        <div class="col-sm-10">
                                            <div class="input-group mb-3">
                                                <input type="password" name="password_confirmation" id="password_confirmation"
                                                       class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                                                       placeholder="Ingrese confirmación de contraseña">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-lock"></span>
                                                    </div>
                                                </div>
                                                @if ($errors->has('password_confirmation'))
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                            <label tipo="error" id="password_confirmation-error"></label>
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


                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4">
                        <div class="main-card mb-3 card">
                            <div class="card-header">Configuración CallCenter</div>
                            <div class="card-body">
                                <form class="">
                                    <div class="position-relative form-group">
                                        <label for="exampleEmail" class="">Extención</label>
                                        <input name="extencion" id="extencion" placeholder="" type="number"
                                               class="form-control">
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="examplePassword" class="">Llamada</label>
                                        <input name="llamada" id="llamada" placeholder=""
                                               type="text" class="form-control">
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="exampleSelectMulti" class="">{{session('nivel1')}}              </label>

                                        <ul class="todo-list-wrapper list-group list-group-flush">
                                            @if(!empty($lstNivelPri))
                                                @foreach ($lstNivelPri as $ent)
                                            <li class="list-group-item">
                                                <div class="todo-indicator bg-warning"></div>
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-wrapper">
                                                        <div class="widget-content-left mr-2">
                                                            <div class="custom-checkbox custom-control">
                                                                <input type="checkbox" id="np_{{$ent->id}}" value="{{$ent->id}}"
                                                                       class="custom-control-input np_cod">
                                                                <label class="custom-control-label"
                                                                       for="np_{{$ent->id}}">&nbsp;</label>
                                                            </div>
                                                        </div>
                                                        <div class="widget-content-left">
                                                            <div class="widget-heading">{{$ent->nombre}}
                                                            </div>
                                                        </div>
                                                        <div class="widget-content-right mr-2" title="ASESOR">
                                                            <div class="custom-checkbox custom-control">
                                                                <input type="checkbox" id="vend_{{$ent->id}}" value="{{$ent->id}}" disabled
                                                                       class="custom-control-input vend_cod">
                                                                <label class="custom-control-label"
                                                                       for="vend_{{$ent->id}}">&nbsp;</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-12">
                        <div class="d-block text-right card-footer">
                            <button title="Cancelar" data-placement="bottom" id="btn_cancelar"
                                    class="mr-2 btn btn-link btn-sm">
                                Cancelar
                            </button>
                            <button title="Guardar" data-placement="bottom" id="btn_guardar"
                                    class="btn-shadow mr-3 btn btn-success ">
                                <i class="fa fa-plus"></i> Guardar
                            </button>
                        </div>
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


