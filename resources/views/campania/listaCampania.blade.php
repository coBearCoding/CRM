@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="../vendor/datatables/css/dataTables.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="../../vendor/spectrum/spectrum.min.css">

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('vendor/select2/select2-bootstrap.css')}}">
<link rel="stylesheet" href="{{ asset('vendor/datepicker/bootstrap-datepicker3.css')}}">

<style>
.cmb_campana{
    width: 100% !important;
}
</style>
@stop

@section('js')

<script src="../../vendor/datatables/js/jquery.dataTables.js"></script>
<script src="../../vendor/datatables/js/dataTables.bootstrap4.js"></script>
<script src="../../vendor/spectrum/spectrum.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<script type="text/javascript" src="{{ asset('js/campania.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/sweetalert2.min.js')}}"></script>
@stop





@section('title')
    <div class="page-title-heading">
        <div class="page-title-icon">
            <i class="pe-7s-rocket icon-gradient bg-ripe-malin"></i>
        </div>
        <div>Marketing
            <div class="page-title-subheading">Campaña</div>
        </div>
    </div>
@endsection


@section('content')

        <ul class="tabs-animated-shadow tabs-animated nav" id='tabsCampana'>
            <li class="nav-item">
                <a role="tab" class="nav-link active" id="tab_Formulario" data-toggle="tab" href="#formCampanaTab" onclick="javascript:formularioCampana();">
                    <span class="nav-text">Formulario Campaña</span>
                </a>
            </li>
            <li class="nav-item">
                <a role="tab" class="nav-link " id="tab-c1-0" data-toggle="tab" href="#tblBusqueda" onclick="javascript:tblListaCampania();">
                    <span class="nav-text">Lista Campaña</span>
                </a>
            </li>
            
            
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="formCampanaTab" role="tabpanel">

                <div class="row">
                    <div class="col-md-12">
                        <div class="main-card mb-12 card">
                            <div class="card-body">
                            <div id='mensajes' style="float:center;display:none"><img src="../images/load.gif" width="5%" height="5%" /></div>
                                <div id="formularioCampana">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane " id="tblBusqueda" role="tabpanel">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-card mb-12 card">
                            <div class="card-body">
                                <div id="tblCampana">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            
        </div>
@endsection
@section('modal')

<div class="modal fade" id="modalPrograma" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Programa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <div class="vertical-time-simple vertical-without-time vertical-timeline vertical-timeline--animate vertical-timeline--one-column">

                <div id="campana_programa"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

@endsection


