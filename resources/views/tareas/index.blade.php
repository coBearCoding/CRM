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
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="../../vendor/datatables/js/jquery.dataTables.js"></script>
    <script src="../../vendor/datatables/js/dataTables.bootstrap4.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/22.0.0/classic/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script rel="stylesheet" href="../../vendor/select2/js/select2.min.js"></script>
    <script src="{{ asset('../js/tareas.js') }}"></script>
    
@stop

@section('title')
    <div class="page-title-heading">
        <div class="page-title-icon">
            <i class="pe-7s-lock  icon-gradient bg-strong-bliss">
            </i>
        </div>
        <div>Tareas
            <div class="page-title-subheading">Listado.
            </div>
        </div>
    </div>
    <div class="page-title-actions">
        <button title="Guardar" data-placement="bottom" 
                data-toggle="modal" data-target=".modal-lead" 
                class="btn-shadow mr-3 btn btn-success ">
            <i class="fa fa-plus"></i> Nueva Tarea
        </button>
    </div>
@endsection


@section('content')
   <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-12 card">
                <div class="card-body">
                    <div id="div_table">
                        <table id="tbl_tarea" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Detalle</th>
                                    <th>Fecha de Inicio</th>
                                    <th>Fecha de Vencimiento</th>
                                    <th>Importancia</th>
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
            <form id="formulario" class="form-horizontal">
                {{ csrf_field() }}
                <div class="modal-body">
                    


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="limpiar()">Cerrar</button>
                    <button type="button" class="btn btn-primary"  data-dismiss="modal" id="btn_enviar">Enviar</button>
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
            <form id="formulario" class="form-horizontal">
                {{ csrf_field() }}
                <div class="modal-body">
                    


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="limpiar()">Cerrar</button>
                    <button type="button" class="btn btn-primary"  data-dismiss="modal" id="btn_enviar">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
