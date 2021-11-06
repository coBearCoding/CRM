
<table align="center" width="100%">
    <tr>
        <th style="background-color: #0098ef;color: #FFFFFF; font-size: 14px; font-weight:bold; text-align: center"
            colspan="6"><h2>{{$empresa->nombre}}</h2></th>
    </tr>
    <tr>
        <th style="background-color: #0098ef;color: #FFFFFF; font-size: 14px; font-weight:bold; text-align: center"
            colspan="6"> <p>RUC: {{$empresa->ruc}}</p></th>
    </tr>
    <tr>
        <th style="background-color: #0098ef;color: #FFFFFF; font-size: 14px; font-weight:bold; text-align: center"
            colspan="6"><p>TELÉFONOS: {{$empresa->telefonos}} - DIRECCIÓN: {{$empresa->direccion}}</p></th>
    </tr>
    <tr>
        <th style="background-color: #0098ef;color: #FFFFFF; font-size: 14px; font-weight:bold; text-align: center"
            colspan="6"><p>{{$empresa->email}}</p></th>
    </tr>
</table>

<br>

<table align="center" width="100%">
    <thead>
    <tr>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center">N°</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center">Nombre</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center">Cédula</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center">Teléfono</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center">Correo</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center">Genero</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center">Dirección</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center">Campaña</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center">Programa</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center">Fuentes de Contacto</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center">Estado Comercial</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center">observaciones del estado comercial</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center">Motivos de su desinterés</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center">Observación General</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center">Asesor</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center">Fecha de Registro</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center">fechas de la última gestión</th>
    </tr>
    </thead>
    <tbody>
    @php $i=0; @endphp

    @foreach($datos as $result)
        @php $i++; @endphp
    <tr>
        <td style="text-align: center">{{$i}}</td>
        <td>{{$result->contacto_tipo->contacto->nombre ?? '' }}</td>
        <td>{{$result->contacto_tipo->contacto->cedula ?? '' }}</td>
        <td>{{$result->contacto_tipo->contacto->telefono ?? '' }}</td>
        <td>{{$result->contacto_tipo->contacto->correo ?? '' }}</td>
        <td>{{$result->contacto_tipo->contacto->genero ?? '' }}</td>
        <td>{{$result->contacto_tipo->contacto->direccion ?? '' }}</td>
        <td>{{$result->campana_programa->campana->nombre ?? '' }}</td>
        <td>{{$result->campana_programa->programa->nombre ?? '' }}</td>
        <td>{{$result->fuente_contacto->nombre ?? '' }}</td>
        <td>{{$result->estado_comercial->nombre ?? '' }}</td>
        <td>{{$result->observacion ?? '' }}</td>
        <td>
            @if($result->contacto_tipo->desinteres)
                @php
                    $dato = explode('Interesado, Motivo: ', $result->contacto_tipo->desinteres->observacion);
                    $rst = explode(', Observación: ',$dato[1]);
                @endphp
                {{ $rst[0] ?? '' }}
            @endif
        </td>
        <td>
            @if($result->contacto_tipo->desinteres)
                {{ $rst[1] ?? '' }}
            @endif
        </td>
        <td>{{$result->vendedor->name ?? '' }}</td>
        <td>{{$result->created_at ?? '' }}</td>
        <td>{{ $result->contacto_tipo->auditoria_last->created_at ?? '' }}</td>
    </tr>
    @endforeach
    </tbody>
</table>

<br>
<br>

<table align="center" width="100%" >
    <tr>
        <th colspan="3" style="background-color: #0098ef;color: #FFFFFF; font-size: 12px;text-align: left">
            <h2>USUARIO: {{ Auth::user()->name }} </h2></th>
        <th colspan="3" style="background-color: #0098ef;color: #FFFFFF; font-size: 12px;text-align: right">
            <p>FECHA: @php echo date('d-m-Y') @endphp</p></th>
    </tr>
</table>
