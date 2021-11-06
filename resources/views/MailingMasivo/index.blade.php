@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="{{ asset('../js/mailing.js') }}?{{rand()}}"></script>
@stop
<style>.select2-selection__rendered {
    line-height: 31px !important;
}
.select2-container .select2-selection--single {
    height: 35px !important;
}
.select2-selection__arrow {
    height: 34px !important;
}</style>
@section('title')
    <div class="page-title-heading">
        <div class="page-title-icon">
            <i class="pe-7s-mail icon-gradient bg-strong-bliss">
            </i>
        </div>
        <div>Mailing
            <div class="page-title-subheading">Administrador
            </div>
        </div>
    </div>
    <div class="page-title-actions">
        <a class="btn-shadow mr-3 btn btn-success" href="{{ route('mkt.mailing.plantilla') }}">
            <i class="fa fa-download"></i> Descargar Plantilla
        </a>
    </div>
@endsection


@section('content')

@if(Session::has('message'))
    <p class="alert alert-success">{{ Session::get('message') }}</p>
@endif
@if(Session::has('error'))
    <p class="alert alert-danger">{{ Session::get('error') }}</p>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="card-shadow-primary border mb-3 card border-primary">
            <form action="{{ route('mkt.mailing.import') }}" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    @csrf
                    <div class="row">
                        <div class="col">
                          <div class="form-group">
                            <label for="estado">Plantilla</label>
                            <input type="hidden" name="asunto" id="asunto">
                            <select id="templateid" name="templateid" class="form-control cboselect"  style="width: 100%" onchange="setEmail(this)">
                                <option value="">Seleccione</option>
                                @foreach ($templates['templates'] as $email)
                                @if ($email['isActive'] === true)
                                    <option data-asunto="{{ $email['subject'] }}" value="{{ $email['id'] }}">{{ $email['name'] }}</option>
                                @endif
                                @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col">
                            <div class="col-md-12 mb-3">
                              <label for="envio">Modo de envio</label>
                                <select id="envio" name="envio" class="form-control">
                                    <option value="1">Transaccional</option>
                                    <option value="2">SendinBlue</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="archivo">Archivo</label>
                                <input type="file" id="archivo" name="archivo" class="form-control">
                            </div>
                        </div>
                        <div class="col"></div>
                    </div>

                  
                </div>
              <div class="d-block text-right card-footer">
                  <button onclick="clear_data();" class="mr-2 btn btn-link btn-sm">Cancelar</button>
                  <a href="#" id="view_template" class="mr-2 btn btn-info btn-lg" target="_blank" style="color:white">Ver plantilla</a>
                  <button type="submit" id="btn_guardar" class="btn btn-success btn-lg">Generar Proceso</button>
                </div>
            </form>           
        </div>
    </div>
</div>

@endsection



@section('modal')

<!-- Modal -->
<div class="modal fade modal-html" tabindex="-1" id="leadHtml" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Visualización de plantilla</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div id="div_mensajes_modal" class="d-none">
                <p id="mensajes_modal"></p>
            </div>
            <div id="formulario" class="form-horizontal">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div id="view_html" style="height: 450px;max-height: 100%;overflow: auto;"></div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="document.getElementById('view_html').innerHTML = '';">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection