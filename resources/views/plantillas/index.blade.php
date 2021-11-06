@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="../vendor/datatables/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="../../vendor/spectrum/spectrum.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('vendor/select2/select2-bootstrap.css')}}">
    <style>
        #cmb_campana{
            width: 100% !important;
        }
        iframe{
              width: auto;
              height: 950px;
            }

</style>
@stop

@section('js')
    <script src="{{ asset('js/plantillas.js') }}"></script>
    <script src="../../vendor/datatables/js/jquery.dataTables.js"></script>
    <script src="../../vendor/datatables/js/dataTables.bootstrap4.js"></script>
    <script src="../../vendor/spectrum/spectrum.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
@stop

@section('title')
    <div class="page-title-heading">
        <div class="page-title-icon">
            <i class="pe-7s-config icon-gradient bg-strong-bliss">
            </i>
        </div>
        <div>Marketing
            <div class="page-title-subheading">Plantillas
            </div>
        </div>
    </div>
@endsection

@section('content')

    <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
        <li class="nav-item">
            <a role="tab" class="nav-link active" id="create_plantilla-tab" data-toggle="tab" onclick="limpiarfrm()" 
               href="#create_plantilla" >
                <span>Ingreso de Plantillas</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link" id="list_plantilla-tab" data-toggle="tab"
               href="#list_plantilla" onclick="javascript:tblListaPlantilla();">
                <span>Listado de Plantillas</span>
            </a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane tabs-animation fade show active" id="create_plantilla" role="tabpanel">
            <div class="row">
                <div id='frm_plantilla' class="col-md-12 col-lg-12">
                <div class="col-md-12 col-lg-12">
                    <div class="main-card mb-3 card">
                        
                            <iframe src="{{url('plantillavista')}}" id='frmNuevo' ></iframe> 
                        </div>
                    </div>
                </div>
                <div id='frm_plantilla_edit' class="col-md-12 col-lg-12" style="display:none">
                <div class="col-md-12 col-lg-12">
                    <div class="main-card mb-3 card">
                            <input type='hidden' id="codigo" name="codigo">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane tabs-animation fade" id="list_plantilla" role="tabpanel">
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






