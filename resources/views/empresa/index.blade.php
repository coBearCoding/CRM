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
    <script src="{{ asset('../js/general.js') }}"></script>
    <script src="{{ asset('../js/empresa.js') }}"></script>
    <script src="../../vendor/datatables/js/jquery.dataTables.js"></script>
    <script src="../../vendor/datatables/js/dataTables.bootstrap4.js"></script>
@stop

@section('title')
    <div class="page-title-heading">
        <div class="page-title-icon">
            <i class="pe-7s-id icon-gradient bg-strong-bliss">
            </i>
        </div>
        <div>Configuración
            <div class="page-title-subheading">Empresa
            </div>

        </div>
    </div>
    
        @endsection

        @section('content')

            <div class="tab-content">
                <div class="tab-pane tabs-animation fade show active" id="custom-tabs-one-home" role="tabpanel">

                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="main-card mb-3 card">

                                <form id="form" class="form-horizontal" action="{{route('save_empresa')}}" type="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" class="form-control" id="hide_id" name="hide_id" value="{{$info->id}}"/>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="txt_nombre" class="col-sm-2 col-form-label">Nombre</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="txt_nombre"
                                                       name="txt_nombre" value="{{$info->nombre}}"
                                                       maxlength="50" placeholder="Ingrese el nombre">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="txt_ruc" class="col-sm-2 col-form-label">Ruc</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="txt_ruc" name="txt_ruc"
                                                       value="{{$info->ruc}}"
                                                       maxlength="13" placeholder="" onkeyup="validar_ruc()">
                                                       <label tipo="error" id="txt_ruc-error"></label>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="txt_telf" class="col-sm-2 col-form-label">Teléfono</label>
                                            <div class="col-sm-4">
                                                <input type="tel" class="form-control" id="txt_telf" name="txt_telf"
                                                       value="{{$info->telefonos}}"
                                                       maxlength="10" placeholder="" onkeypress="javascript: return validaNumericos(event);">
                                            </div>
                                            <label for="txt_carpeta" class="col-sm-2 col-form-label">Carpeta</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="txt_carpeta"
                                                       name="txt_carpeta" value="{{$info->carpeta}}"
                                                       maxlength="50" placeholder="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="txt_direccion" class="col-sm-2 col-form-label">Dirección</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="txt_direccion"
                                                       name="txt_direccion" value="{{$info->direccion}}"
                                                       maxlength="50" placeholder="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="txt_email" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="txt_email" name="txt_email"
                                                       value="{{$info->email}}"
                                                       maxlength="50" placeholder="">
                                                       <label tipo="error" id="txt_email-error"></label>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="chk_estado" class="col-sm-2 col-form-label">Estado</label>
                                            <div class="col-sm-10">
                                                <div class="custom-checkbox custom-control custom-control-inline">
                                                    <input type="checkbox" id="chk_estado" name="chk_estado"
                                                           class="custom-control-input" value=""
                                                           @if($info->estado == 'A')  checked @endif>
                                                    <label class="custom-control-label" for="chk_estado">ACTIVO / INACTIVO</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-header">
                                            <ul class="nav nav-justified">
                                                <li class="nav-item"><a data-toggle="tab" href="#tab-eg7-0"
                                                                        class="active nav-link">Configuración
                                                        Mail</a></li>
                                                <li class="nav-item"><a data-toggle="tab" href="#tab-eg7-1" class="nav-link">Configuración
                                                        Socket</a></li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="tab-eg7-0" role="tabpanel">
                                                    <div class="form-group row">


                                                        <label for="txt_user_mail"
                                                               class="col-sm-2 col-form-label">Usuario</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control" id="txt_user_mail"
                                                                   name="txt_user_mail" value="{{$info->user_email}}"
                                                                   maxlength="50" placeholder="">
                                                        </div>
                                                        <label for="txt_pass_mail"
                                                               class="col-sm-2 col-form-label">Password</label>
                                                        <div class="col-sm-4">
                                                            <input type="password" class="form-control" id="txt_pass_mail"
                                                                   name="txt_pass_mail" value="{{$info->pass_email}}"
                                                                   maxlength="50" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="txt_host_mail" class="col-sm-2 col-form-label">Host</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control" id="txt_host_mail"
                                                                   name="txt_host_mail" value="{{$info->host_email}}"
                                                                   maxlength="5" placeholder="">
                                                        </div>
                                                        <label for="txt_port_mail"
                                                               class="col-sm-2 col-form-label">Puerto</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control" id="txt_port_mail"
                                                                   name="txt_port_mail" value="{{$info->puerto_email}}"
                                                                   maxlength="5" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="txt_smtp_mail" class="col-sm-2 col-form-label">SMTP</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control" id="txt_smtp_mail"
                                                                   name="txt_smtp_mail" value="{{$info->smtp_email}}"
                                                                   maxlength="50" placeholder="">
                                                        </div>
                                                        <label for="txt_envio_mail" class="col-sm-2 col-form-label">Nombre
                                                            Envío</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control" id="txt_envio_mail"
                                                                   name="txt_nombre_envio" value="{{$info->nombre_envio}}"
                                                                   maxlength="50" placeholder="">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane" id="tab-eg7-1" role="tabpanel">
                                                    <div class="form-group row">
                                                        <label for="txt_url_socket" class="col-sm-2 col-form-label">URL</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control" id="txt_url_socket"
                                                                   name="txt_url_socket" value="{{$info->url_socket}}"
                                                                   maxlength="50" placeholder="">
                                                        </div>
                                                        <label for="txt_tok_socket"
                                                               class="col-sm-2 col-form-label">Token</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control" id="txt_tok_socket"
                                                                   name="txt_tok_socket" value="{{$info->token_socket}}"
                                                                   maxlength="50" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="chk_estado" class="col-sm-2 col-form-label">Estado</label>
                                                        <div class="col-sm-10">
                                                            <div class="custom-checkbox custom-control custom-control-inline">
                                                                <input type="checkbox" id="chk_estado_ct" name="chk_estado_ct"
                                                                       @if($info->estado_socket == 'A') ? checked @endif
                                                                       class="custom-control-input">
                                                                <label class="custom-control-label" for="chk_estado_ct">INACTIVO
                                                                    /
                                                                    ACTIVO</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="page-title-actions text-right">
                                            <button title="Guardar" type="button" id="btn_guardar"
                                                    class="btn-shadow mr-3 btn btn-success ">
                                                <i class="fa fa-plus"></i> Guardar
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="mb-3 card">

                            </div>
   


                        </div>
                        <!--
                        <div class="col-md-12 col-lg-4">
                            <div class="main-card mb-3 card">
                                <div class="card-body">

                                    <br>

                                    <div class="app-header__logo">
                                        <div class="text-center">
                                            <img src="../images/logo_inicial.png">
                                        </div>
                                    </div>
                                    <br> <br>
                                    <div class="p-3">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <h5 class="pb-2">Elejir Color Header</h5>
                                                <div class="theme-settings-swatches">
                                                    <div class="swatch-holder bg-primary switch-header-cs-class"
                                                         data-class="bg-primary header-text-light"></div>
                                                    <div class="swatch-holder bg-secondary switch-header-cs-class"
                                                         data-class="bg-secondary header-text-light"></div>
                                                    <div class="swatch-holder bg-success switch-header-cs-class"
                                                         data-class="bg-success header-text-light"></div>
                                                    <div class="swatch-holder bg-info switch-header-cs-class"
                                                         data-class="bg-info header-text-light"></div>
                                                    <div class="swatch-holder bg-warning switch-header-cs-class"
                                                         data-class="bg-warning header-text-dark"></div>
                                                    <div class="swatch-holder bg-danger switch-header-cs-class"
                                                         data-class="bg-danger header-text-light"></div>
                                                    <div class="swatch-holder bg-light switch-header-cs-class active"
                                                         data-class="bg-light header-text-dark"></div>
                                                    <div class="swatch-holder bg-dark switch-header-cs-class"
                                                         data-class="bg-dark header-text-light"></div>
                                                    <div class="swatch-holder bg-focus switch-header-cs-class"
                                                         data-class="bg-focus header-text-light"></div>
                                                    <div class="swatch-holder bg-alternate switch-header-cs-class"
                                                         data-class="bg-alternate header-text-light"></div>
                                                    <div class="swatch-holder bg-vicious-stance switch-header-cs-class"
                                                         data-class="bg-vicious-stance header-text-light"></div>
                                                    <div class="swatch-holder bg-midnight-bloom switch-header-cs-class"
                                                         data-class="bg-midnight-bloom header-text-light"></div>
                                                    <div class="swatch-holder bg-night-sky switch-header-cs-class"
                                                         data-class="bg-night-sky header-text-light"></div>
                                                    <div class="swatch-holder bg-slick-carbon switch-header-cs-class"
                                                         data-class="bg-slick-carbon header-text-light"></div>
                                                    <div class="swatch-holder bg-asteroid switch-header-cs-class"
                                                         data-class="bg-asteroid header-text-light"></div>
                                                    <div class="swatch-holder bg-royal switch-header-cs-class"
                                                         data-class="bg-royal header-text-light"></div>
                                                    <div class="swatch-holder bg-warm-flame switch-header-cs-class"
                                                         data-class="bg-warm-flame header-text-dark"></div>
                                                    <div class="swatch-holder bg-night-fade switch-header-cs-class"
                                                         data-class="bg-night-fade header-text-dark"></div>
                                                    <div class="divider"></div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="p-3">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <h6 class="pb-2">Elegir Color Banner</h6>
                                                <div class="theme-settings-swatches">
                                                    <div class="swatch-holder bg-primary switch-sidebar-cs-class"
                                                         data-class="bg-primary sidebar-text-light"></div>
                                                    <div class="swatch-holder bg-secondary switch-sidebar-cs-class"
                                                         data-class="bg-secondary sidebar-text-light"></div>
                                                    <div class="swatch-holder bg-success switch-sidebar-cs-class"
                                                         data-class="bg-success sidebar-text-dark"></div>
                                                    <div class="swatch-holder bg-info switch-sidebar-cs-class"
                                                         data-class="bg-info sidebar-text-dark"></div>
                                                    <div class="swatch-holder bg-warning switch-sidebar-cs-class"
                                                         data-class="bg-warning sidebar-text-dark"></div>
                                                    <div class="swatch-holder bg-danger switch-sidebar-cs-class"
                                                         data-class="bg-danger sidebar-text-light"></div>
                                                    <div class="swatch-holder bg-light switch-sidebar-cs-class"
                                                         data-class="bg-light sidebar-text-dark"></div>
                                                    <div class="swatch-holder bg-dark switch-sidebar-cs-class"
                                                         data-class="bg-dark sidebar-text-light"></div>
                                                    <div class="swatch-holder bg-focus switch-sidebar-cs-class"
                                                         data-class="bg-focus sidebar-text-light"></div>
                                                    <div class="swatch-holder bg-alternate switch-sidebar-cs-class"
                                                         data-class="bg-alternate sidebar-text-light"></div>
                                                    <div class="swatch-holder bg-vicious-stance switch-sidebar-cs-class"
                                                         data-class="bg-vicious-stance sidebar-text-light"></div>
                                                    <div class="swatch-holder bg-midnight-bloom switch-sidebar-cs-class"
                                                         data-class="bg-midnight-bloom sidebar-text-light"></div>
                                                    <div class="swatch-holder bg-night-sky switch-sidebar-cs-class active"
                                                         data-class="bg-night-sky sidebar-text-light"></div>
                                                    <div class="swatch-holder bg-slick-carbon switch-sidebar-cs-class"
                                                         data-class="bg-slick-carbon sidebar-text-light"></div>
                                                    <div class="swatch-holder bg-asteroid switch-sidebar-cs-class"
                                                         data-class="bg-asteroid sidebar-text-light"></div>
                                                    <div class="swatch-holder bg-royal switch-sidebar-cs-class"
                                                         data-class="bg-royal sidebar-text-light"></div>
                                                    <div class="swatch-holder bg-warm-flame switch-sidebar-cs-class"
                                                         data-class="bg-warm-flame sidebar-text-dark"></div>
                                                    <div class="swatch-holder bg-night-fade switch-sidebar-cs-class"
                                                         data-class="bg-night-fade sidebar-text-dark"></div>

                                                    <div class="divider"></div>


                                                </div>
                                            </li>

                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>
                        -->
                    </div>


                </div>

            </div>
   

@stop

@section('modal')

@endsection





