@extends('layouts.admin')
@section('css') 
 
<link rel="stylesheet" href="{{ asset('vendor/select2/select2-bootstrap.css')}}">

<style>
.cmb_importar{
    width: 100% !important;
}
</style>
@endsection
@section('js') 

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>            
<script src="../../vendor/select2/select2.min.js"></script>
<script type="text/javascript" src="{{ asset('js/importar.js')}}"></script>


 <!-- Include all compiled plugins (below), or include individual files as needed -->

<script>
    $(document).ready(function () {
        $('.dropdown-toggle').dropdown();
    });
</script>
@endsection
@section('title')
    <div class="page-title-heading">
        <div class="page-title-icon">
            <i class="pe-7s-graph icon-gradient bg-ripe-malin"></i>
        </div>
        <div>Importar
            <div class="page-title-subheading">Importar Leads y Clientes!</div> 
        </div>
    </div>
@endsection


@section('content')
<div class="d-inline-block dropdown" style="float:right">
    


    <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow dropdown-toggle btn btn-success">
        <span class="btn-icon-wrapper pr-2 opacity-7">
            <i class="fa fa-business-time fa-w-20"></i>
        </span>
        Plantillas
    </button>
    <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right" style="">
        <ul class="nav flex-column">
            <li class="nav-item">     
                <a class="nav-link" href="{{ route('downLeads') }}" target="_blank">
                    <i class="nav-link-icon lnr-book"></i>
                    <span> Plantilla de Leads</span>
                                                               
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('downClientes') }}" target="_blank" >
                    <i class="nav-link-icon lnr-book"></i>
                    <span> Plantilla de Clientes</span>
                                                               
                </a>
            </li>
                                                        
        </ul>
    </div>
</div>
        <ul class="tabs-animated-shadow tabs-animated nav" id='tabsCampana'>
            <li class="nav-item">
                <a role="tab" class="nav-link active" id="tab-c1-0" data-toggle="tab" href="#importar" >
                    <span class="nav-text">Importar</span>
                </a>
            </li>
        </ul>
                                            
        <div class="tab-content">

            <div class="tab-pane active" id="importar" role="tabpanel">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-card mb-12 card">
                            <div class="card-body">
                                <div id="mensaje_error"></div>
                                <form name="importar" id="importar" method="POST" action="{{route('importarDatos')}}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                    <div class="position-relative row form-group">
                                        <label for="exampleEmail" class="col-sm-3 col-form-label">Opción : </label>
                                        <div class="col-sm-9 position-relative form-group">
                                            <div class="custom-radio custom-control custom-control-inline">
                                                <input type="radio" id="lead" name="opcion" class="custom-control-input" checked value="L" onclick="javascript:esconderDiv(this.value);resetearFormulario();">
                                                <label class="custom-control-label" for="lead">Leads</label>
                                            </div>
                                            <div class="custom-radio custom-control custom-control-inline">
                                                <input type="radio" id="cliente" name="opcion" class="custom-control-input" value="C" onclick="javascript:esconderDiv(this.value);resetearFormulario();" >
                                                <label class="custom-control-label" for="cliente" >Clientes</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="opcionLead">
                                        <div class="position-relative row form-group">
                                            <label for="exampleEmail" class="col-sm-3 col-form-label">Fuente de Contacto </label>
                                            <div class="col-sm-9">
                                                <select id="fte_contacto" name="fte_contacto" class="cmb_importar"  >
                                                <option value="">SELECCIONE..</option>
                                                @foreach($cmbFteContacto as $row)
                                                    <option value="{{$row->id}}">{{$row->nombre}}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div> 
                                    </div>
                                    <!--<div class="position-relative row form-group">
                                            <label for="exampleEmail" class="col-sm-3 col-form-label">Colegio  / Universidad / tecnológico  </label>
                                            <div class="col-sm-9">
                                                <select id="procedencia" name="procedencia" class="cmb_importar ">
                                                    <option value="">SELECCIONE..</option>
                                                @foreach($cmbProcedencia as $row)
                                                    <option value="{{$row->id}}">{{$row->nombre}}</option>
                                                @endforeach
                                                </select>      

                                            </div>
                                    </div>-->
                                    <div class="position-relative row form-group">
                                            <label for="exampleEmail" class="col-sm-3 col-form-label">Sede  </label>
                                            <div class="col-sm-9">
                                                <select id="sedes" name="sedes" class="cmb_importar " onchange="javascript: cargaCampana(this.value); opcionAsesor();">
                                                    <option value="">SELECCIONE..</option>
                                                    <option value="T">TODO</option>
                                                @foreach($cmbSede as $row)
                                                    <option value="{{$row->id}}">{{$row->nombre}}</option>
                                                @endforeach
                                                </select>      

                                            </div>
                                    </div>
                                    <div class="position-relative row form-group">
                                            <label for="exampleEmail" class="col-sm-3 col-form-label">Nombre de Campaña </label>
                                            <div class="col-sm-9">
                                                <div id="div_nom_campana">
                                                    <select id="nom_campana" name="nom_campana" class="cmb_importar" >
                                                        <option value="">SELECCIONE..</option>
                                                    </select>
                                                </div>
                                                
                                            </div>
                                    </div>
                                    
                                       
                                        <div class="position-relative row form-group">
                                            <label for="exampleEmail" class="col-sm-3 col-form-label">{{session('nivel2')}}  </label>
                                            <div class="col-sm-9">
                                                <div id="div_nivel2">
                                                    <select id="nivel2" class="cmb_importar" name="nivel2" >
                                                    <option value="">SELECCIONE..</option>
                                                    </select> 
                                                </div>
                                            </div>
                                        </div>
                                       <!-- <div class="position-relative row form-group">
                                            <label  for="lbl_asesor" class="col-sm-3  col-form-label">Asesor : </label><br><br>
                                                <div class="col-sm-9">  
                                                
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="asesorT" name="asesor" class="custom-control-input" checked value="T" onclick="javascript:opcionAsesor()">
                                                        <label class="custom-control-label" for="asesorT">Gestores</label>
                                                    </div>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="asesorG" name="asesor" class="custom-control-input" value="V" onclick="javascript:opcionAsesor()">
                                                        <label class="custom-control-label" for="asesorG" >Vendedor</label>
                                                    </div>
                                                </div> 
                                        </div> 
                                        <div class="position-relative row form-group">
                                            <label for="exampleEmail" class="col-sm-3 col-form-label">Vendedor </label>
                                            <div class="col-sm-9">
                                                <select id="cod_vendedor" name="cod_vendedor" class="cmb_importar ">
                                                    <option value="">SELECCIONE..</option>
                                                </select>      

                                            </div>
                                        </div>
                                        -->

                                        <div class="position-relative row form-group">
                                            <label for="importar" class="col-sm-3 col-form-label">Importar el Archivo</label>
                                            <div class="col-sm-9">
                                            <br>
                                                <input name="archivo" id="archivo" type="file" class="form-control-file">
                                                <small class="form-text text-muted">
                                                </small>
                                            </div>
                                        </div>
                                        <div id="espera" style="text-align: center;display:none" >
                                            <img src="../images/load.gif" width="40%" style="height:60px" />
                                        </div>
                                    <div class="d-block text-right card-footer">
                                        <button type="button" class="mr-2 btn btn-link btn-sm" onclick="javascript:resetearFormulario()">CANCELAR</button>
                                        <a onclick="javascript:importarDatos()" id="btn_guardar" style="color:#FFFFFF" class="btn btn-success btn-lg">GUARDAR</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
          
        </div>

@endsection

