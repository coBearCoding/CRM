@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="../../vendor/datatables/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('vendor/datepicker/bootstrap-datepicker3.css')}}">

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
        .ck-editor__editable {

            min-height: 150px;
        }
        .ck-rounded-corners .ck.ck-balloon-panel, .ck.ck-balloon-panel.ck-rounded-corners {
            z-index: 10055 !important;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="../../vendor/datatables/js/jquery.dataTables.js"></script>
    <script src="../../vendor/datatables/js/dataTables.bootstrap4.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/22.0.0/classic/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="{{ asset('../js/leads.js') }}?{{rand()}}"></script>
    <script>
        $(document).ready(function(){
            if ($("#oferta_search").val()!='') {
                $("#oferta_search").trigger('change');
            }
            $("#fch_prox_contacto").datepicker();
        })
    </script>

@stop

@section('title')
    <div class="page-title-heading">
        <div class="page-title-icon">
            <i class="pe-7s-lock  icon-gradient bg-strong-bliss">
            </i>
        </div>
        <div>Leads
            <div class="page-title-subheading">Listado.
            </div>
        </div>
    </div>
    <div class="page-title-actions">
        <button title="Guardar" data-placement="bottom"
                data-toggle="modal" data-target=".modal-lead"
                class="btn-shadow mr-3 btn btn-success " onclick="limpiar()">
            <i class="fa fa-plus"></i> Nuevo Leads
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
                            <div class="col-md-3 mb-3">


                                <label for="validationCustomUsername">Fecha</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupPrepend"><input data-toggle='tooltip' data-placement='top' 
                                        title='seleccionar la fecha de seguimiento' type="checkbox" id="fecha_seguimiento" name="fecha_seguimiento"></span>
                                  </div>
                                    <input type="hidden" name="fecha_ini" id="fecha_ini">
                                    <input type="hidden" name="fecha_fin" id="fecha_fin">
                                    <div id="fecha" style="background: #fff; cursor: pointer; padding: 7px 10px; border: 1px solid #ccc; border-radius: 5px;">
                                            <i class="fa fa-calendar"></i>&nbsp;
                                            <span></span> <i class="fa fa-caret-down"></i>
                                        </div>
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

                              <div class="col-md-3 mb-3">
                                  <label for="oferta_search">Asesor</label>
                                  <select class="form-control" id="asesor_search" name="asesor_search">
                                      @if(Auth::user()->roles->id != 3)
                                          <option value="">Todos</option>
                                      @endif

                                        @for ($i = 0; $i < count($ofertaUsersAll) ; $i++)
                                            @if (Auth::user()->roles->id == 3) {{-- ASESOR COMERCIAL --}}
                                                @if (Auth::user()->id == $ofertaUsersAll[$i]['id'])
                                                    <option value="{{ $ofertaUsersAll[$i]['id'] }}" @if(Auth::user()->id == $ofertaUsersAll[$i]['id'] ) selected @endif>{{ $ofertaUsersAll[$i]['name']  }}</option>  
                                                @endif
                                            @else
                                                <option value="{{ $ofertaUsersAll[$i]['id'] }}" @if(Auth::user()->id == $ofertaUsersAll[$i]['id'] ) selected @endif>{{ $ofertaUsersAll[$i]['name']  }}</option>  
                                            @endif
                                        @endfor

                                  </select>
                              </div>

                          </div>
                          <div class="form-row">

                                <div class="col-md-3 mb-3">
                                  <label for="oferta_search">{{session('nivel1')}}</label>
                                    <select class="form-control" id="oferta_search" name="oferta_search">
                                        @if(count($ofertaAcademicaAll)>1)
                                        <option value="">Todos</option>
                                         @endif
                                         @foreach ($ofertaAcademicaAll as $oferta)
                                        <option value="{{ $oferta->nprimario->id }}" @if(count($ofertaAcademicaAll)==1) selected @endif>{{ $oferta->nprimario->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="col-md-3 mb-3">
                                  <label for="campain">Campañas</label>
                                    <select class="form-control" id="campain_search" name="campain_search">
                                        <option value="">Todos</option>
                                         {{--@foreach ($campanas as $campain)
                                              <option value="{{ $campain->id }}">{{ $campain->nombre }}</option>
                                              @endforeach--}}
                                    </select>
                                </div>

                                <div class="col-md-3 mb-3">
                                  <label for="programa">{{session('nivel2')}}</label>
                                    <select class="form-control" id="programa_search" name="programa_search">
                                        <option value="">Todos</option>
                                    </select>
                                </div>

                                  <div class="col-md-2 mb-3">
                                      <button style="margin-top: 30px;" type="button" class="btn-pill btn-shadow btn-wide fsize-1 btn btn-primary btn-lg" onclick="busqueda_search()">Buscar</button>
                                  </div>

                          </div>
                        </form>
                    </div>
                    <div id="div_table">
                        <table id="tbl_leads" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>created_at</th>
                                    <th>Correo</th>
                                    <th>Nombre</th>
                                    <th>Datos Personales</th>
                                    <th>Datos Leads</th>
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
                <h5 class="modal-title" id="exampleModalLongTitle">Nuevo Leads</h5>
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
                               <input type="hidden" name="tipo_id" id="tipo_id" value="1" class="form-control">
                               <input type="hidden" name="vendedor_hide" id="vendedor_hide" value="1" class="form-control">
                               <input type="hidden" name="programa_hide" id="programa_hide" value="1" class="form-control">
                               <input type="hidden" name="editar" id="editar" value="SI" class="form-control">
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
                        <div class="col">
                            <div class="form-group">
                                <label for="programa" class="col-form-label">{{session('nivel2')}}:</label>
                                 <select id="programa" name="programa" class="form-control"></select>
                                <label tipo="error" id="programa-error"></label>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="otros" class="col-form-label">Otros {{session('nivel2')}}:</label>
                                <select name="otros" id="otros" class="form-control">
                                    <option value="" selected disabled>seleccione</option>
                                    @foreach($otrosProgramas as $otro)
                                    <option value="{{ $otro->id }}">{{ $otro->nombre }}</option>
                                    @endforeach
                                </select>
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
                                 {{-- <select  id="procedencia" name="procedencia" class="form-control" >
                                    <option value="">Seleccione</option>
                                    @foreach ($procedencias as $element)
                                    <option value="{{ $element->id }}">{{ $element->nombre }}</option>
                                    @endforeach
                                </select> --}}
                                <input type="text" id="procedencia" name="procedencia" class="form-control">
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
<div class="modal fade modal-contacto" tabindex="-1" id="contactoModal" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Datos de Contacto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="formulario_contacto" class="form-horizontal">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="nombre_edit" class="col-form-label">Nombres:</label>
                                <input type="hidden" name="contacto_id_edit" id="contacto_id_edit">
                                <input type="text" name="nombre_edit" id="nombre_edit" class="form-control">
                                <label tipo="error" id="nombre_edit-error"></label>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="cedula_edit" class="col-form-label">Cédula:</label>
                                <input type="text" name="cedula_edit" id="cedula_edit" class="form-control">
                                <label tipo="error" id="cedula_edit-error"></label>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="correo_edit" class="col-form-label">Correo:</label>
                                <input type="email" name="correo_edit" id="correo_edit" class="form-control">
                                <label tipo="error" id="correo_edit-error"></label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="genero_edit" class="col-form-label">Genero:</label><br>
                                <div class="custom-control custom-radio custom-control-inline">
                                  <input type="radio" id="Masculino_edit" value="Masculino" name="genero_edit" class="custom-control-input">
                                  <label class="custom-control-label" for="Masculino_edit">Masculino</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                  <input type="radio" id="Femenino_edit" value="Femenino" name="genero_edit" class="custom-control-input">
                                  <label class="custom-control-label" for="Femenino_edit">Femenino</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="direccion_edit" class="col-form-label">Dirección:</label>
                                <input type="text" name="direccion_edit" id="direccion_edit" class="form-control">
                                <label tipo="error" id="direccion_edit-error"></label>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="telefono_edit" class="col-form-label">Teléfonos:</label>
                                <input type="text" name="telefono_edit" id="telefono_edit" class="form-control" >
                                <label tipo="error" id="telefono_edit-error"></label>
                            </div>
                        </div>

                        
                    </div>

                    <div class="row">

                        <div class="col">
                            <div class="form-group">
                                <label for="procedencia_edit" class="col-form-label">Colegio / Universidad / Tecnológico:</label>
                                 {{-- <select  id="procedencia_edit" name="procedencia_edit" class="form-control" >
                                    <option value="">Seleccione</option>
                                    @foreach ($procedencias as $element)
                                    <option value="{{ $element->id }}">{{ $element->nombre }}</option>
                                    @endforeach
                                </select> --}}
                                <input type="text" id="procedencia_edit" name="procedencia_edit" class="form-control">
                                <label tipo="error" id="procedencia_edit-error"></label>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="tipo_estudiante_edit" class="col-form-label">Tipo de Estudiante:</label>
                                <select  id="tipo_estudiante_edit" name="tipo_estudiante_edit" class="form-control" >
                                    <option value="">Seleccione</option>
                                    @foreach ($tipo_estudiante as $element)
                                    <option value="{{ $element->id }}">{{ $element->nombre }}</option>
                                    @endforeach
                                </select>
                                <label tipo="error" id="tipo_estudiante_edit-error"></label>
                            </div>
                        </div>
                        
                    </div>




                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="limpiar()">Cerrar</button>
                    <button type="button" class="btn btn-primary"  data-dismiss="modal" id="btn_editar">Editar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade modal-estado" tabindex="-1" id="estadoModal" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
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
                                <input type="hidden" name="estado_contacto_historico_id" id="estado_contacto_historico_id">
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

                    <div id="desinteres" style="display: none">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="desinteres_modal" class="col-form-label">Motivos de Desinterés:</label>
                                    <input type="hidden" name="desinteres_nombre" id="desinteres_nombre">
                                    <select id="desinteres_modal" name="desinteres_modal" class="form-control">
                                        <option value="">Seleccione</option>
                                        @foreach ($MotivoDesinteres as $estado)
                                            <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <label tipo="error" id="desinteres_modal-error"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="seguimiento" style="display: none">
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
                                    <label for="fch_prox_contacto" class="col-form-label">Fecha de Próximo Contacto:</label>
                                    <input type="text" name="fch_prox_contacto" id="fch_prox_contacto" class="form-control" placeholder="aaaa-mm-dd" data-date-format='yyyy-mm-dd'>
                                    <label tipo="error" id="fch_prox_contacto-error"></label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="hora" class="col-form-label">Hora de Próximo Contacto:</label>
                                    <input type="time" id="hora" name="hora" min="00:00" max="23:59" value="{{ date('H:i') }}" class="form-control">
                                </div>
                                
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
<div class="modal fade modal-pregunta" tabindex="-1" id="estadoPregunta" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Preguntas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="formulario_preguntas" class="form-horizontal">
                {{ csrf_field() }}
                <div class="modal-body">
            <input type="hidden" name="pregunta_tipo_contacto_id" id="pregunta_tipo_contacto_id">
            <input type="hidden" name="pregunta_nivel_primario_id" id="pregunta_nivel_primario_id">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="tipo_encuesta" class="col-form-label">Tipo de encuesta</label>
                        <select class="form-control" id="tipo_encuesta" name="tipo_encuesta" >
                            <option value="">Seleccione</option>
                            @foreach($TipoEncuesta as $pre)
                            <option value="{{$pre->id}}">{{$pre->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
                <div id="preguntas"></div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="limpiar()">Cerrar</button>
                    <button type="button" class="btn btn-primary"  data-dismiss="modal" id="btn_preguntas">Enviar</button>
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
                <h5 class="modal-title" id="exampleModalLongTitle">Envio Transacional Leads</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="formulario_envio" class="form-horizontal">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="plantilla" class="col-form-label">Plantilla: </label>
                                <select id="plantilla" name="plantilla" class="form-control"  style="width: 100%" onchange="setEmail(this)">
                                    <option value="">Seleccione</option>
                                    @php
                                        $mailsTemplates = Helper::getTemplates();
                                    @endphp
                                    @foreach ($mailsTemplates['templates'] as $email)
                                    @if ($email['isActive'] === true)
                                        <option data-html="{{ $email['htmlContent'] }}" data-asunto="{{ $email['subject'] }}" value="{{ $email['id'] }}">{{ $email['name'] }}</option>
                                    @endif
                                    @endforeach
                                </select>
                                <label tipo="error" id="plantilla-error"></label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="para" class="col-form-label">Para:</label>
                                <input type="hidden" name="transaccional_tipo_contacto_id" id="transaccional_tipo_contacto_id">
                                <input type="hidden" name="nombre_lead" id="nombre_lead">
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
                            <div class="form-group" style="padding-top: 40px;">
                                <label for="adjunto" class="col-form-label">Plantilla Admisiones:</label>
                                <input type="checkbox" id="grado_template" name="grado_template">
                                <label tipo="error" id="adjunto-error"></label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            {{--<div class="form-group" id="panel">
                                <textarea id="txt_plantilla" name="txt_plantilla" rows="8"></textarea>
                                <label tipo="error" id="adjunto-error"></label>
                            </div>--}}
                            <div id="texto_plantilla" style="height: 250px;max-height: 100%;overflow: auto;padding-top: 25px;display:none"></div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="limpiar()">Cerrar</button>
                    <a href="#" id="view_template" class="btn btn-info" target="_blank" style="color:white">Ver plantilla</a>
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
                <h5 class="modal-title" id="seguimiento_title">Seguimiento del Leads</h5>
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
