<div class="row">
    <div class="col">
        <p><b>Campaña:</b> {{ $datos->contacto_historico_last->campana_programa->campana->nombre ?? '' }}</p>
        <p><b>Programa:</b> {{ $datos->contacto_historico_last->campana_programa->programa->nombre ?? '' }}</p>
        <p><b>Fuente de Contacto:</b> {{ $datos->contacto_historico_last->fuente_contacto->nombre ?? '' }}</p>
    </div>
    <div class="col">
        <p><b>Estado Comercial:</b> {{ $datos->contacto_historico_last->estado_comercial->nombre ?? '' }}</p>
        <p><b>Asesor:</b> {{ $datos->contacto_historico_last->vendedor->name ?? 'Sin Asignar' }}</p>
        <p><b>Registrado por:</b> {{ $datos->contacto_historico_last->creado_por->name ?? 'CRM-EcoBot' }}, el {{\Carbon\Carbon::parse($datos->contacto_historico_last->created_at)->format('j F, Y')}} a las {{\Carbon\Carbon::parse($datos->contacto_historico_last->created_at)->format('h:i:s A')}}</p>
    </div>
</div>
<div class="p-4">
    <div class="vertical-time-icons vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
        @php
            $total = count($datos->autoria_contacto) + 1 ?? 0;
        @endphp
        @if(!empty($datos->autoria_contacto))
             @foreach ($datos->autoria_contacto as $auditoria)
                 <div class="vertical-timeline-item vertical-timeline-element">
                    <div>
                        <div class="vertical-timeline-element-icon bounce-in">
                            <div class="timeline-icon border-{{ $auditoria->accion->color ?? 'primary' }}">
                                <i class="{{ $auditoria->accion->icono ?? 'lnr-license' }} text-{{ $auditoria->accion->color ?? 'primary' }}"></i>
                            </div>
                        </div>
                        <div class="vertical-timeline-element-content bounce-in">
                            <h4 class="timeline-title">{{ $total  = $total - 1 }}.- {{ $auditoria->accion->nombre ?? '' }}</h4>
                            <p>{{ $auditoria->observacion}} <br>
                                <b class="text-{{ $auditoria->accion->color ?? 'info' }}">{{ $auditoria->creado_por->name ?? ''}}, {{\Carbon\Carbon::parse($auditoria->created_at)->format('j F, Y')}} a las  {{\Carbon\Carbon::parse($auditoria->created_at)->format('h:i:s A')}}</b>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

</div>
