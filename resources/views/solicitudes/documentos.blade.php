{{--@dd($solicitud->documentos);--}}
<div class="row">
    <div class="col-md-12 col-lg-5">
        <div class="main-card mb-3 card">
            <div class="card-header">Documentos</div>
            <input type="hidden" id="idsolicitud" name="idsolicitud" value="{{$solicitud->id}}">
            <input type="hidden" id="xurl" name="xurl" value="{{env('APP_ADMISIONES')}}">
            <input type="hidden" id="cod_solicitud_documentos" name="cod_solicitud_documentos"
                   value="{{$solicitud->cod_solicitud}}">
            @foreach($documentos as $documento)
            <ul class="todo-list-wrapper list-group list-group-flush">
                <li class="list-group-item">
                    <div class="todo-indicator bg-info"></div>
                    <div class="widget-content p-0">
                        <div class="row">
                            <div class="col-4">
                                <div class="widget-heading">
                                    <label style="font-weight: bold" for="solicitudPostulante">{{ $documento->nombre ?? '' }}</label>
                                    @if(!empty($solicitud->documentos))
                                        @php
                                            $solic_doc = Helper::searchArray($solicitud->documentos,$documento->id);
                                            $texto = '';
                                            $color = '';
                                            $solicitud_documento_id = $solic_doc['id'] ?? 0;
                                            if (!empty($solic_doc)) {
                                                if ($solic_doc['estado'] == 'A') {
                                                    $texto = 'Aprobado';
                                                    $color = 'primary';
                                                }else if($solic_doc['estado'] == 'R'){
                                                    $texto = 'Rechazado';
                                                    $color = 'danger';
                                                }
                                            }
                                        @endphp
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                @if(!empty($solic_doc))
                                    <span class="badge badge-pill badge-{{ $color }}">{{ $texto }}</span>
                                @endif
                            </div>
                            <div class="col-4">
                                <button class="border-0 btn-transition btn btn-outline-info" title="Ver"
                                    onclick="verDocumento('{{env('APP_ADMISIONES')}}/','{{$solic_doc['nombre'] ?? ''}}'); event.preventDefault()">
                                <i class="fa fa-eye"></i>
                                </button>
                                <button class="border-0 btn-transition btn btn-outline-success" title="Aprobar"
                                        onclick="aprobarDenegar('{{ $documento->nombre ?? '' }} del postualante',{{ $solicitud_documento_id }},'A');event.preventDefault()">
                                    <i class="fa fa-check"></i>
                                </button>
                                <button class="border-0 btn-transition btn btn-outline-danger" title="Rechazar"
                                        onclick="aprobarDenegar('{{ $documento->nombre ?? '' }} del postualante',{{ $solicitud_documento_id }},'R');event.preventDefault()">
                                    <i class="fa fa-times"></i>
                                </button>
                                @if($solicitud_documento_id != 0)
                                <a href="{{url('solicitudes/descargar')}}/{{$solicitud_documento_id}}" class="border-0 btn-transition btn btn-outline-secondary" title="Descargar">
                                    <i class="fa fa-download"></i>
                                </a>
                                @endif
                            </div>

                        </div>

                    </div>
                </li>
            </ul>
            @endforeach

            <div class="row">
                <div class="col-12">
                    <div class="input-group">
                      <span class="input-group-text" style="font-weight: bold;" id="motivo-label">Motivo:</span>
                      <textarea class="form-control" aria-label="motivo-label" id="motivo" name="motivo" maxlength="200"></textarea>
                    </div>
                </div>
            </div>


            <div class="d-block text-right card-footer">
                <button class="btn btn-success btn-lg modal-close" data-dismiss="modal" type="button" id="registrar"
                        onclick="aplicar_cambios({{$solicitud->id}},'{{$codigo}}','{{$migrado}}');event.preventDefault()">Registrar cambio de estado
                </button>
            </div>
        </div>
    </div>
    <div class="col-lg-7 col-md-12">
        <div id="viewResult" style="height: 100%;max-height: 110vh;">

        </div>
    </div>
</div>
