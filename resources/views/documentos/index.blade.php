@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="../../vendor/datatables/css/dataTables.bootstrap4.css">
    <style type="text/css">
    	 #formulario label[tipo="error"]{
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
    <script src="{{ asset('../js/documentos.js') }}"></script>
    
@stop

@section('title')
    <div class="page-title-heading">
        <div class="page-title-icon">
            <i class="pe-7s-lock  icon-gradient bg-strong-bliss">
            </i>
        </div>
        <div>Configuración de Documentos
            <div class="page-title-subheading">Listado.
            </div>
        </div>
    </div>
    <div class="page-title-actions">
        <button title="Guardar" data-placement="bottom" 
                data-toggle="modal" data-target="#horarioModal" onclick="limpiar();"
                class="btn-shadow mr-3 btn btn-success ">
            <i class="fa fa-plus"></i> Nuevo Documento
        </button>
    </div>
@endsection


@section('content')
   <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-12 card">
                <div class="card-body">
                   <div id="div_tabla" class="table-responsive">
                    
                	</div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
<!-- Modal -->
<div class="modal fade" tabindex="-1" id="horarioModal" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Configuración de Documentos</h5>
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
                  <label for="servicio">Oferta Academica</label>                  
                  <input type="hidden" id="id" name="id">
                  <select class="form-control" id="servicio" name="servicio">
                    <option value="" selected disabled>Seleccione</option>
                    @foreach ($servicios as $element)
                      <option value="{{ $element->id }}">{{ $element->nombre }}</option>
                    @endforeach
                  </select>
                  <label tipo="error" id="servicio-error"></label>
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label for="tipo">Tipo de Documento</label>
                <select class="form-control" id="tipo" name="tipo">
                  <option value="" selected disabled>Seleccione</option>
                    @foreach ($tipos_documentos as $element)
                      <option value="{{ $element->id }}">{{ $element->nombre }}</option>
                    @endforeach
                </select>
                <label tipo="error" id="tipo-error"></label>
              </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="nombre" class="form-control-label">Nombre</label>
                    <input class="form-control" type="text"  id="nombre" name="nombre">
                    <label tipo="error" id="nombre-error"></label>
                </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label for="requerido" class="form-control-label">Es requerido</label><br>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="si" name="requerido" class="custom-control-input" checked value="S">
                    <label class="custom-control-label" for="si">SI</label>
                  </div>
                  <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="no" name="requerido" class="custom-control-input" value="N">
                    <label class="custom-control-label" for="no">NO</label>
                  </div>
              </div>
            </div>
        </div>
  
      </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="limpiar()">Cerrar</button>
                    <button type="button" class="btn btn-primary"  data-dismiss="modal" id="btn_guardar">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>







@endsection
