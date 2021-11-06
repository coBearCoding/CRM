
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
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center">Estado</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center">Fecha Creación</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center">Fecha Modificación</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center">Sistema</th>
    </tr>
    </thead>
    <tbody>
    @php $i=0; @endphp

    @foreach($lstResult as $result)
        @php $i++; @endphp
    <tr>
        <td style="text-align: center">{{$i}}</td>
        <td>{{$result->nombre}}</td>
        <td style="text-align: center">@if($result->estado == 'A') <span class="badge badge-success">ACTIVO</span> @else <span class="badge badge-danger">INACTIVO</span> @endif </td>
        <td style="text-align: center">{{$result->created_at}}</td>
        <td style="text-align: center">{{$result->updated_at}}</td>
        <td style="text-align: center">@if($result->sistema == 1) SI @else NO @endif</td>
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