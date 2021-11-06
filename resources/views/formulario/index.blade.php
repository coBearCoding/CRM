@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="../vendor/datatables/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="../../vendor/select2/select2.min.css">
@stop




@section('title')
    <div class="page-title-heading">
        <div class="page-title-icon">
            <i class="pe-7s-config icon-gradient bg-strong-bliss">
            </i>
        </div>
        <div>Marketing
            <div class="page-title-subheading">Formularios
            </div>
        </div>
    </div>
@endsection

@section('content')



    <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
        <li class="nav-item">
            <a role="tab" class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="tab"
               href="#custom-tabs-one-home">
                <span>Ingreso de Formularios</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="tab"
               href="#custom-tabs-one-profile">
                <span>Listado de Formularios</span>
            </a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane tabs-animation fade show active" id="custom-tabs-one-home" role="tabpanel">

            <div class="row">

                <div class="col-md-12 col-lg-4">
                    <div class="main-card mb-3 card">

                        <div class="card-header"><i class="header-icon lnr-license icon-gradient bg-plum-plate"> </i>DATOS
                            <div class="btn-actions-pane-right">
                                <div role="group" class="btn-group-sm nav btn-group">
                                    <a data-toggle="tab" href="#tab-eg1-0" class="btn-shadow btn btn-secondary active">General</a>
                                    <a data-toggle="tab" href="#tab-eg1-1"
                                       class="btn-shadow btn btn-primary">Fuentes</a>
                                    <a data-toggle="tab" href="#tab-eg1-2"
                                       class="btn-shadow btn btn-primary">Código</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab-eg1-0" role="tabpanel">

                                    <div class="position-relative form-group">
                                        <label for="exampleEmail" class="">Nombre</label>
                                        <input name="hide_id" id="hide_id"
                                               type="hidden" class="form-control">
                                        <input name="nombre" id="nombre"
                                               type="text" class="form-control">
                                    </div>

                                    <div class="position-relative form-group">
                                        <label for="exampleEmail" class="">Campañas</label>
                                        <select name="cmb_campana" id="cmb_campana"
                                                class="cmb_campana form-control">
                                            <option value="0"> Seleccione Campaña</option>
                                            @foreach($lstDatos as $dato)
                                                <option value="{{$dato->id}}"> {{$dato->nombre}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="position-relative form-group">
                                        <label for="exampleEmail" class="">{{session('nivel2')}}</label>
                                        <div id="div_nivel2"></div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab-eg1-1" role="tabpanel">


                                    <div class="vertical-time-simple vertical-without-time vertical-timeline vertical-timeline--animate vertical-timeline--one-column">

                                        @foreach($lstFuentes as $fuente)
                                            <div class="vertical-timeline-item vertical-timeline-element">
                                                <div>
                                                    <span class="vertical-timeline-element-icon bounce-in"></span>
                                                    <div class="vertical-timeline-element-content bounce-in">
                                                        <h4 class="timeline-title">{{$fuente->id}}
                                                            - {{$fuente->nombre}}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                                <div class="tab-pane" id="tab-eg1-2" role="tabpanel">
                                    <div class="vertical-time-simple vertical-without-time vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                                        <div class="vertical-timeline-item vertical-timeline-element">
                                            <div>
                                                <span class="vertical-timeline-element-icon bounce-in"></span>
                                                <div class="vertical-timeline-element-content bounce-in">
                                                    <h4 class="timeline-title" title="OBLIGATORIO">Nombres y Apellidos(*): <b> nombre  </b></h4>
                                                    <h4 class="timeline-title" title="OBLIGATORIO">Email(*): <b>  correo </b></h4>
                                                    <h4 class="timeline-title" title="OBLIGATORIO">Telefono(*): <b>  telefono </b></h4>
                                                    <h4 class="timeline-title" title="OBLIGATORIO">{{ session('nivel2') }}(*): <b> prog_id </b></h4>
                                                    <h4 class="timeline-title" title="OBLIGATORIO">Campaña (*):  <b> campana_id</b>  </h4>
                                                    <h4 class="timeline-title" title="NO ES OBLIGATORIO">Formulario : <b> form_id </b></h4>
                                                    <h4 class="timeline-title" title="(No es obligatorio en caso de indicarse campo plataform)">Fuente de Contacto: <b> fte_contacto </b></h4>
                                                    <h4 class="timeline-title" title="(Se asigna fb/ig en caso de no enviar fuente de contacto)">Plataforma fb/ig: <b> plataform </b> </h4>
                                                   
                                                    <h4 class="timeline-title"></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-8 col-md-12">

                    <div class="main-card mb-3 card">
                        <div class="card-header">
                            <i class="header-icon lnr-laptop-phone icon-gradient bg-plum-plate"> </i>CONSTRUCTOR
                            <div class="btn-actions-pane-right actions-icon-btn">
                                <button class="btn-icon btn-icon-only btn btn-link" id="getJS" name="getJS"
                                        title="Vista Previa">
                                    <i class="fa fa-eye btn-icon-wrapper"></i>
                                </button>


                            </div>
                            <div style="float: right">Lenguaje: <select id="setLanguage">

                                    <option selected value="es-ES">Español (ES)</option>
                                    <option value="en-US">English (US)</option>


                                </select></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">

                                <div class="text-left col-sm-6 d-none">
                                    <p class="formbuilder-title">jQuery formBuilder -
                                        <button class="editForm" id="form_render">Render</button>
                                    </p>
                                </div>
                            </div>
                            <div class="build-wrap" id="build-wrap"></div>
                            <form class="render-wrap d-none"></form>
                        </div>
                        <div id="formbuilder-options"></div>
                    </div>

                </div>

            </div>
        </div>
        <div class="tab-pane tabs-animation fade" id="custom-tabs-one-profile" role="tabpanel">
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




@section('js')

    <script>
        var car= '<?php echo $paramUrl['valor'] ?>';
    </script>
    <script src="{{ asset('../js/formulario.js') }}"></script>
    <script src="../../vendor/datatables/js/jquery.dataTables.js"></script>
    <script src="../../vendor/datatables/js/dataTables.bootstrap4.js"></script>
    <script src="../../vendor/select2/select2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>


    <script src="../../vendor/forms/form-builder.min.js"></script>
    <script src="../../vendor/forms/form-render.min.js"></script>
    <script src="../../vendor/forms/demo.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.1/jquery.rateyo.min.js"></script>

@stop

