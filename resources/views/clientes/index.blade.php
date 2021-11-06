@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="../../vendor/datatables/css/dataTables.bootstrap4.css">
    <!--<link rel="stylesheet" href="../../vendor/select2/css/select2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./vendor/select2/select2-bootstrap.css">-->
    <style type="text/css">
        div.dataTables_wrapper div.dataTables_processing {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100px;
            margin-left: -100px;
            margin-top: -26px;
            text-align: center;
            padding: 1em 0;
        }

        .border-title{
            border-bottom: 1px solid;
        }

        .line{
            margin-bottom: 1px !important;
        }
        .form-group {
            margin-bottom: 0rem;
        }

        .ck-editor__editable {
            min-height: 120px;
        }

        #panel{
            padding-top: 15px

        }

        #formulario label[tipo="error"]{
            display: none;
            font-size: 12px;
            color: #fe0000;
        }
        #formulario_envio label[tipo="error"]{
            display: none;
            font-size: 12px;
            color: #fe0000;
        }
        #formulario_estado label[tipo="error"]{
            display: none;
            font-size: 12px;
            color: #fe0000;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="../../vendor/datatables/js/jquery.dataTables.js"></script>
    <script src="../../vendor/datatables/js/dataTables.bootstrap4.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/22.0.0/classic/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script rel="stylesheet" href="../../vendor/select2/js/select2.min.js"></script>
    <script src="{{ asset('../js/clientes.js') }}"></script>

@stop

@section('title')
    <div class="page-title-heading">
        <div class="page-title-icon">
            <i class="pe-7s-lock  icon-gradient bg-strong-bliss">
            </i>
        </div>
        <div>Cliente
            <div class="page-title-subheading">Listado.
            </div>
        </div>
    </div>
    <div class="page-title-actions">
        <button title="Guardar" data-placement="bottom"
                data-toggle="modal" data-target=".modal-lead"
                class="btn-shadow mr-3 btn btn-success ">
            <i class="fa fa-plus"></i> Nuevo Cliente
        </button>
    </div>
@endsection


@section('content')
   <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-12 card">
                <div class="card-body">
                    <div>
                        <form class="needs-validation" novalidate id="form_search">
                            {{ csrf_field() }}
                          <div class="form-row">
                            <div class="col-md-4 mb-3">
                              <label for="validationCustom01">Fecha</label>
                              <input type="hidden" name="fecha_ini" id="fecha_ini">
                              <input type="hidden" name="fecha_fin" id="fecha_fin">
                              <div id="fecha" style="background: #fff; cursor: pointer; padding: 7px 10px; border: 1px solid #ccc; width: 100%;border-radius: 5px;">
                                    <i class="fa fa-calendar"></i>&nbsp;
                                    <span></span> <i class="fa fa-caret-down"></i>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                              <label for="validationCustom02">Estado Comercial</label>
                                <select class="form-control" id="estado_search" name="estado_search">
                                    <option value="">Todos</option>
                                    @foreach ($estado_comercial as $element)
                                    <option value="{{ $element->id }}">{{ $element->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                  <label for="fuente_search">Fuente de Contacto</label>
                                    <select class="form-control" id="fuente_search" name="fuente_search">
                                        <option value="">Todos</option>
                                         @foreach ($fuente_contactos as $fuente)
                                        <option value="{{ $fuente->id }}">{{ $fuente->nombre }}</option>
                                        @endforeach
                                    </select>
                            </div>

                            <div class="col-md-2 mb-3">
                              <button style="margin-top: 30px;" type="button" class="btn btn-success" onclick="busqueda_search()">Buscar</button>
                            </div>
                          </div>
                        </form>
                    </div>
                    <div id="div_table">
                        <table id="tbl_clientes" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>created_at</th>
                                    <th>Correo</th>
                                    <th>Nombre</th>
                                    <th>Datos Personales</th>
                                    <th>Datos Clientes</th>
                                    <th>Asesor</th>
                                    <th>Estado Comercial</th>
                                    <th>Fuente de Contacto</th>
                                    <th>Registrado por</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')

<!-- Modal -->
<div class="modal fade modal-lead" tabindex="-1" id="leadModal" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Nuevo Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div id="div_mensajes_modal" class="d-none">
                <p id="mensajes_modal"></p>
            </div>
            <form id="formulario" class="form-horizontal">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="nombre" class="col-form-label">Nombres:</label>
                               <input type="hidden" name="contacto_id" id="contacto_id" class="form-control">
                               <input type="hidden" name="tipo_id" id="tipo_id" value="2" class="form-control">
                               <input type="text" name="nombre" id="nombre" class="form-control">
                                <label tipo="error" id="nombre-error"></label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="cedula" class="col-form-label">Cédula:</label>
                                <input type="text" name="cedula" id="cedula" class="form-control">
                                <label tipo="error" id="cedula-error"></label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="genero" class="col-form-label">Genero:</label><br>
                                <div class="custom-control custom-radio custom-control-inline">
                                  <input type="radio" id="Masculino" value="Masculino" name="genero" class="custom-control-input">
                                  <label class="custom-control-label" for="Masculino">Masculino</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                  <input type="radio" id="Femenino" value="Femenino" name="genero" class="custom-control-input">
                                  <label class="custom-control-label" for="Femenino">Femenino</label>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="campana" class="col-form-label">Nombre de la Campaña:</label>
                                <select id="campana" name="campana" class="form-control">
                                    <option value="" selected disabled>Seleccione...</option>
                                    @foreach ($campanas as $campana)
                                        <option value="{{ $campana->id }}">{{ $campana->nombre }}</option>
                                    @endforeach
                                </select>
                                <label tipo="error" id="campana-error"></label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{--<div class="col">
                            <div class="form-group">
                                <label for="oferta_academica" class="col-form-label">Oferta Académica:</label>
                                <select id="oferta_academica" name="oferta_academica" class="form-control">
                                    <option value="">Seleccione</option>
                                    @foreach ($nivel_primario as $oferta)
                                        <option value="{{ $oferta->id }}">{{ $oferta->nombre }}</option>
                                    @endforeach
                                </select>
                                <label tipo="error" id="oferta_academica-error"></label>
                            </div>
                        </div>--}}
                        <div class="col">
                            <div class="form-group">
                                <label for="programa" class="col-form-label">{{session('nivel2')}}:</label>
                                 <select id="programa" name="programa" class="form-control"></select>
                                <label tipo="error" id="programa-error"></label>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="otros" class="col-form-label">Otros {{session('nivel2')}} :</label>
                                <input type="text" name="otros" id="otros" class="form-control">
                                <label tipo="error" id="otros-error"></label>
                            </div>
                        </div>
                    </div>

                     <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="email" class="col-form-label">Email:</label>
                                <input type="email" name="email" id="email" class="form-control" >
                                <label tipo="error" id="email-error"></label>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="telefono" class="col-form-label">Teléfonos:</label>
                                <input type="text" name="telefono" id="telefono" class="form-control" >
                                <label tipo="error" id="telefono-error"></label>
                            </div>
                        </div>

                    </div>

                     <div class="row">

                        <div class="col">
                            <div class="form-group">
                                <label for="direccion" class="col-form-label">Dirección:</label>
                                <input type="text" name="direccion" id="direccion" class="form-control">
                                <label tipo="error" id="direccion-error"></label>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="procedencia" class="col-form-label">Colegio / Universidad / Tecnológico:</label>
                                 <select  id="procedencia" name="procedencia" class="form-control" >
                                    <option value="">Seleccione</option>
                                    @foreach ($procedencias as $element)
                                    <option value="{{ $element->id }}">{{ $element->nombre }}</option>
                                    @endforeach
                                </select>
                                <label tipo="error" id="procedencia-error"></label>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col">
                            <div class="form-group">
                                <label for="tipo" class="col-form-label">Tipo de Estudiante:</label>
                                <select  id="tipo_estudiante" name="tipo_estudiante" class="form-control" >
                                    <option value="">Seleccione</option>
                                    @foreach ($tipo_estudiante as $element)
                                    <option value="{{ $element->id }}">{{ $element->nombre }}</option>
                                    @endforeach
                                </select>
                                <label tipo="error" id="tipo-error"></label>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="fuente" class="col-form-label">Fuente de Contacto:</label>
                                <select class="form-control" id="fuente" name="fuente">
                                    <option value="">Seleccione</option>
                                    @foreach ($fuente_contactos as $fuente)
                                    <option value="{{ $fuente->id }}">{{ $fuente->nombre }}</option>
                                    @endforeach
                                </select>
                                <label tipo="error" id="fuente-error"></label>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col">
                            <div class="form-group">
                                <label for="medio" class="col-form-label">Medio de Gestión:</label>
                                <select class="form-control" id="medio" name="medio">
                                    <option value="">Seleccione</option>
                                    @foreach ($medio_gestion as $element)
                                    <option value="{{ $element->id }}">{{ $element->nombre }}</option>
                                    @endforeach
                                </select>
                                <label tipo="error" id="medio-error"></label>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="vendedor" class="col-form-label">Asesor:</label>
                                <select class="form-control" id="vendedor" name="vendedor">
                                    <option value="">Seleccione</option>
                                </select>
                                <label tipo="error" id="vendedor-error"></label>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col">
                            <div class="form-group" id="">
                                <label for="observacion" class="col-form-label">Observación:</label>
                                <textarea id="observacion" name="observacion" class="form-control" rows="5"></textarea>
                                <label tipo="error" id="observacion-error"></label>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="limpiar()">Cerrar</button>
                    <button type="button" class="btn btn-primary"  data-dismiss="modal" id="btn_enviar">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade modal-seguimiento" tabindex="-1" id="seguimientoModal" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Seguimiento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="formulario_seguimiento" class="form-horizontal">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="seguimiento_modal" class="col-form-label">Estado Comercial del Seguimiento:</label>
                                <input type="hidden" name="seguimiento_tipo_contacto_id" id="seguimiento_tipo_contacto_id">
                                <select id="seguimiento_modal" name="seguimiento_modal" class="form-control">
                                    <option value="">Seleccione</option>
                                    @foreach ($estado_comercial_seguimientos as $seguimiento)
                                        <option value="{{ $seguimiento->id }}">{{ $seguimiento->nombre }}</option>
                                    @endforeach
                                </select>
                                <label tipo="error" id="seguimiento_modal-error"></label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="medio_gestion_seguimiento" class="col-form-label">Medio de Gestión:</label>
                                <select id="medio_gestion_seguimiento" name="medio_gestion_seguimiento" class="form-control">
                                    <option value="">Seleccione</option>
                                    @foreach ($medio_gestion as $medio)
                                        <option value="{{ $medio->id }}">{{ $medio->nombre }}</option>
                                    @endforeach
                                </select>
                                <label tipo="error" id="medio_gestion_seguimiento-error"></label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="observacion_seguimiento" class="col-form-label">Observaciones:</label>
                                <textarea class="form-control" rows="5" id="observacion_seguimiento" name="observacion_seguimiento"></textarea>
                                <label tipo="error" id="observacion_seguimiento-error"></label>
                            </div>
                        </div>
                    </div>




                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="limpiar()">Cerrar</button>
                    <button type="button" class="btn btn-primary"  data-dismiss="modal" id="btn_seguimiento">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade modal-estado" tabindex="-1" id="estadoModal" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Estado Comercial</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="formulario_estado" class="form-horizontal">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="estado_comercial_modal" class="col-form-label">Estado Comercial:</label>
                                <input type="hidden" name="estado_tipo_contacto_id" id="estado_tipo_contacto_id">
                                <select id="estado_comercial_modal" name="estado_comercial_modal" class="form-control">
                                    <option value="">Seleccione</option>
                                    @foreach ($estado_comercial as $estado)
                                        <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                    @endforeach
                                </select>
                                <label tipo="error" id="estado_comercial_modal-error"></label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="observacion_estado" class="col-form-label">Observaciones:</label>
                                <textarea class="form-control" rows="5" id="observacion_estado" name="observacion_estado"></textarea>
                                <label tipo="error" id="observacion_estado-error"></label>
                            </div>
                        </div>
                    </div>




                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="limpiar()">Cerrar</button>
                    <button type="button" class="btn btn-primary"  data-dismiss="modal" id="btn_estado_comercial">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade modal-envio" tabindex="-1" id="envioModal" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Envio Transacional Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="formulario_envio" class="form-horizontal">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row">
                                <input type="hidden" name="transaccional_tipo_contacto_id" id="transaccional_tipo_contacto_id">
                        {{--<div class="col">
                                                                            <div class="form-group">
                                                                                <label for="plantilla" class="col-form-label">Plantilla:</label>
                                                                                <select id="plantilla" name="plantilla" class="form-control" onchange="setEmail(this)">
                                                                                    <option value="">Seleccione</option>
                                                                                    @foreach ($Mailings as $email)
                                                                                        <option data-html="{{ $email->cont_plantilla }}" data-asunto="{{ $email->nombre }}" value="{{ $email->id }}">{{ $email->nombre }}</option>
                                                                                        @endforeach
                                                                                </select>
                                                                                <label tipo="error" id="plantilla-error"></label>
                                                                            </div>
                                                                        </div>--}}
                        <div class="col">
                            <div class="form-group">
                                <label for="para" class="col-form-label">Para:</label>
                                <input type="text" name="para" id="para" class="form-control">
                                <label tipo="error" id="para-error"></label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="cc" class="col-form-label">CC:</label>
                                <input type="text" name="cc" id="cc" class="form-control" value="{{ Auth::user()->email }}">
                                <label tipo="error" id="cc-error"></label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="cco" class="col-form-label">CCO:</label>
                                <input type="text" name="cco" id="cco" class="form-control" value="">
                                <label tipo="error" id="cco-error"></label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="asunto" class="col-form-label">Asunto:</label>
                                <input type="text" id="asunto" name="asunto" class="form-control">
                                <label tipo="error" id="asunto-error"></label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="adjunto" class="col-form-label">Adjunto:</label>
                                <input type="file" name="adjunto" id="adjunto" class="form-control">
                                <label tipo="error" id="adjunto-error"></label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group" id="panel">
                                <textarea id="txt_plantilla" name="txt_plantilla" rows="8"></textarea>
                                <label tipo="error" id="adjunto-error"></label>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="limpiar()">Cerrar</button>
                    <button type="button" class="btn btn-primary"  data-dismiss="modal" id="btn_enviar_mail">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade modal-seguimiento-show" tabindex="-1" id="seguimientoModal" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="seguimiento_title">Seguimiento del Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="resultado-seguimiento">
            </div>

        </div>
    </div>
</div>
@endsection
