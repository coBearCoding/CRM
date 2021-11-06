
<table align="center" width="100%">
    <tr>
        <th style="background-color: #0098ef;color: #FFFFFF; font-size: 14px; font-weight:bold; text-align: center"
            colspan="11"><h2>{{$empresa->nombre}}</h2></th>
    </tr>
    <tr>
        <th style="background-color: #0098ef;color: #FFFFFF; font-size: 14px; font-weight:bold; text-align: center"
            colspan="11"> <p>RUC: {{$empresa->ruc}}</p></th>
    </tr>
    <tr>
        <th style="background-color: #0098ef;color: #FFFFFF; font-size: 14px; font-weight:bold; text-align: center"
            colspan="11"><p>TELÉFONOS: {{$empresa->telefonos}} - DIRECCIÓN: {{$empresa->direccion}}</p></th>
    </tr>
    <tr>
        <th style="background-color: #0098ef;color: #FFFFFF; font-size: 14px; font-weight:bold; text-align: center"
            colspan="11"><p>{{$empresa->email}}</p></th>
    </tr>
</table>

<br>

<table align="center" width="100%">
    <thead>
    <tr>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center">N°</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center">Extensión</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center">Nombre</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center">Fecha Hora de inicio</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center">Fecha Hora de fin</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center">Duración (seg)</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center">Tiempo de espera (seg)</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center">Tipo</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center">Teléfono</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center">Estado</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center">Archivo</th>
        
    </tr>
    </thead>
    <tbody>
    @php $i=0; @endphp

    @foreach($datos['data'] as $result)
        @php $i++; @endphp
        @switch($result['type'])
            @case('Inbound')
                @php $type='Entrantes'; @endphp
                @break

            @case('ManualDialing')
                @php $type='Salientes'; @endphp
                @break

            @default
                @php $type=''; @endphp
        @endswitch

        @switch($result['status'])
            @case('terminada')
                @php $status='Terminada'; @endphp
                @break
            @case('abandonada')
                @php $status='Abandonada'; @endphp
                @break
            @case('Failure')
                @php $status='Fallida'; @endphp
                @break
            @case('Success')
                @php $status='Exitosa'; @endphp
                @break
            @case('NoAnswer')
                @php $status='No Contestada'; @endphp
                @break
            @case('Shortcall')
                @php $status='Llamada corta'; @endphp
                @break
            @default
                @php $status=''; @endphp
        @endswitch
    <tr>

        <td style="text-align: center">{{$i}}</td>
        <td>{{$result['agentnick'] ?? '' }}</td>
        <td>{{$result['name'] ?? '' }}</td>
        <td>{{$result['start_date'] ?? '' }}</td>
        <td>{{$result['end_date'] ?? '' }}</td>
        <td>{{$result['duration'] ?? '' }}</td>
        <td>{{$result['duration_wait'] ?? '' }}</td>
        <td>{{ $type }}</td>
        <td>{{$result['telefono'] ?? '' }}</td>
        <td>{{$status }}</td>
        <td>{{$result['recordingfile'] ?? '' }}</td>
        
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