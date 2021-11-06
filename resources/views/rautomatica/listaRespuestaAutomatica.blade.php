@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="../vendor/datatables/css/dataTables.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="../../vendor/spectrum/spectrum.min.css">

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('vendor/select2/select2-bootstrap.css')}}">
<link href="{{ asset('vendor/smartwizard/smart_wizard.css')}}" rel="stylesheet" type="text/css" />

<style>
.cmb_nivel2_multiple{
    width: 100% !important;
}
#niv_arch{
   width: 100% !important;
}
</style>

@stop

@section('js')

<script type="text/javascript" src="{{ asset('js/rautomatico.js')}}"></script>
<script src="../../vendor/datatables/js/jquery.dataTables.js"></script>
<script src="../../vendor/datatables/js/dataTables.bootstrap4.js"></script>
<script src="../../vendor/spectrum/spectrum.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<script src="{{ asset('vendor/smartwizard/jquery.smartWizard-2.0.min.js')}}" type="text/javascript"></script>

@stop




@section('title')
    <div class="page-title-heading">
        <div class="page-title-icon">
            <i class="pe-7s-rocket icon-gradient bg-ripe-malin"></i>
        </div>
        <div>Marketing
            <div class="page-title-subheading">Respuesta Automática</div>
        </div>
    </div>
@endsection


@section('content')

        <ul class="tabs-animated-shadow tabs-animated nav" id='tabsRespAuto'>
            <li class="nav-item">
                <a role="tab" class="nav-link active" id="tab_Formulario" data-toggle="tab" href="#respAutoTab" onclick="resetearFormulario(); ">
                    <span class="nav-text">Formulario Respuesta Automática</span>
                </a>
            </li>
            <li class="nav-item">
                <a role="tab" class="nav-link " id="tab-c1-0" data-toggle="tab" href="#tblBusqueda" onclick="javascript:tblListRespAuto();">
                    <span class="nav-text">Lista Respuesta Automática</span>
                </a>
            </li>
            
            
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="respAutoTab" role="tabpanel">
                <div id="respAutomatica"></div>
              <!--  <div class="row"> 
                   <div class="col-md-12">
                        <div class="main-card mb-12 card">
                            <div class="card-body">
                            <div id='mensajes' style="float:center;display:none"><img src="../images/load.gif" width="5%" height="5%" /></div>
                               
                                 
                               
                            </div>
                        </div>
                   </div>
             </div> -->
            </div>






            <div class="tab-pane " id="tblBusqueda" role="tabpanel">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-card mb-12 card">
                            <div class="card-body">
                                <div id="tblRespAuto">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            
        </div>

@stop


