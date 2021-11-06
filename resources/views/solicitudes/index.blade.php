@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="../../vendor/datatables/css/dataTables.bootstrap4.css">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="../../vendor/datatables/js/jquery.dataTables.js"></script>
    <script src="../../vendor/datatables/js/dataTables.bootstrap4.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/22.0.0/classic/ckeditor.js"></script>
    <script src="{{ asset('../js/solicitud.js') }}"></script>

@stop

@section('title')
    <div class="page-title-heading">
        <div class="page-title-icon">
            <i class="pe-7s-lock  icon-gradient bg-strong-bliss">
            </i>
        </div>
        <div>Solicitudes
            <div class="page-title-subheading">Listado.
            </div>
        </div>
    </div>
    {{--<div class="page-title-actions">
                <button title="Guardar" data-placement="bottom"
                        data-toggle="modal" data-target=".modal-lead"
                        class="btn-shadow mr-3 btn btn-success ">
                    <i class="fa fa-plus"></i> Nuevo Leads
                </button>
            </div>--}}
@endsection


@section('content')
   <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-12 card">
                <div class="card-body">
                   <div class="col-12">
                      <form class="needs-validation" novalidate id="form_search" action="{{route('solicitud.reporte')}}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-row pt-4">
                                <div class="col-md-5 mb-3">
                                    <label for="validationCustom01">Fecha</label>
                                    <div id="fecha"
                                         style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                        <i class="fa fa-calendar"></i>&nbsp;
                                        <span></span> <i class="fa fa-caret-down"></i>
                                    </div>
                                    <input type="hidden" id="fecha_ini" name="fecha_ini" class="form-control">
                                    <input type="hidden" id="fecha_fin" name="fecha_fin" class="form-control">
                                    <input type="hidden" id="estado_export" name="estado_export" class="form-control" value="2">

                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="estado">Estados</label>
                                    <select class="form-control" id="estado" name="estado" style="height: 38px;">
                                        {{-- <option value="-1" selected>Seleccione</option> --}}
                                        <option value="">Todos</option>
                                        @foreach($solucitudEstados as $estado)
                                            <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-1 mb-3">
                                    <button style="margin-top: 30px;" type="button" class="btn btn-success"
                                            id="busqueda" onclick="busquedaTable()">Buscar
                                    </button>
                                </div>

                                {{--<div class="col-md-2  text-right" style="margin-top: 30px;" >
                                                                                                    <button title="Exportar" data-placement="bottom"
                                                                                                            class="btn-shadow mr-3 btn btn-primary "
                                                                                                            onclick="event.preventDefault(); document.getElementById('form_search').submit();">
                                                                                                        <i class="fa fa-file-excel-o"></i> Exportar
                                                                                                    </button>
                                                                                                </div>--}}
                            </div>
                        </form>

                </div>
                    <div id="div_table">
                        <table id="tbl_solicitudes" class="table table-bordered">
                            <thead>
	                        <tr>
	                            <th>email</th>
                                <th>nombre</th>
	                            <th>apellido</th>
	                            <th>cedula</th>
	                            <th>solicitud</th>
	                            <th>estado</th>
	                            <th>Datos del Postulante</th>
	                            <th>Detalle de la Solicitud</th>
                                <th>Estado de Pago</th>
	                            <th>Fecha de Registro</th>
	                            <th>Acciones</th>
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
<div class="modal fade modal-estado" tabindex="-1" id="estadoModal" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Cambio de estado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div id="div_mensajes_modal" class="d-none">
                <p id="mensajes_modal"></p>
            </div>
            <form id="form_estado" class="form-horizontal">
                {{ csrf_field() }}
               <div class="modal-body">
               	<div class="row">
		            <div class="col">
		              <div class="form-group">
		                  <label for="estado_edit">Estado</label>
		                  <input type="hidden" id="id_solicitud" name="id_solicitud">
		                  <select class="form-control" id="estado_edit" name="estado_edit">
		                    <option value="" selected disabled>Seleccione</option>
		                    @foreach ($solucitudEstados as $element)
		                      <option value="{{ $element->id }}">{{ $element->nombre }}</option>
		                    @endforeach
		                  </select>
		              </div>
		            </div>
		        </div>
		        <div class="row">
		            <div class="col">
		                <div class="form-group">
		                    <label for="observacion_edit" class="form-control-label">Comentario</label>
		                    <textarea rows="5" maxlength="250" class="form-control" id="observacion_edit" name="observacion_edit"></textarea>
		                </div>
		            </div>
		        </div>

            <div class="row">
                <div class="col" style="display: none;">
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="informar" name="informar" value="S">
                      <label class="form-check-label" for="informar">Desea notificar el cambio de estado al postulante</label>
                    </div>
                </div>
            </div>

               </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="limpiar()">Cerrar</button>
                    <button type="button" class="btn btn-primary"  data-dismiss="modal" id="actualizarEstado">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade modal-documento" id="documentosModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg" style="max-width: 155vh;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="title_documento">Documentos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="">
      <div class="modal-body" id="documentos">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade modal-historial" id="historialModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Historial</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="">
      <div class="modal-body" id="historial">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
{{--<div class="modal fade modal-historial" id="historialModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Historial</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="">
      <div class="modal-body" id="historial">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
      </div>
    </div>
  </div>
</div>--}}


@endsection
