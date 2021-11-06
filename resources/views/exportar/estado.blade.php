
<head>
    <style>
        .table-report{
            border-collapse: collapse;
        }

        @page {
            margin: 0cm 2cm 0cm 2cm ;
            font-family: Arial;
        }
        /* .table-report tr th{
            color: #0e49b5;
            text-transform: uppercase;
        } */
        .table-report tr td{
            border-top: 1px solid #769fcd;
        }
        .table-report tr th, .table-report tr td{
            padding-top: .55rem;
            padding-bottom: .55rem;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
            border-collapse: collapse;
        }
    </style>
</head>
<table width="100%" style="font:arial, sans-serif;color:#393e46">
<tbody>

<td>
    <img src="https://crm.ecotec.edu.ec/images/logo_inicial.jpg" alt="" style="max-width:210px">
</td>
<td>

            <div style="margin-top: 2px;margin-bottom: 0;text-align: right;font-size:.7em;"> <span>{{$empresa->nombre}}</span> </div>
            <div style="margin-top: 2px;margin-bottom: 0;text-align: right;font-size:.7em"> <span>Ruc: </span> {{$empresa->ruc}}</div>
            <div style="margin-top: 2px;margin-bottom: 0;text-align: right;font-size:.7em"> <span>Teléfono: </span> {{$empresa->telefonos}}</div>
            <div style="margin-top: 2px;margin-bottom: 0;text-align: right;font-size:.7em"> <span>Direccion: </span>{{$empresa->direccion}}</div>
            <div style="margin-top: 2px;margin-bottom: 0;text-align: right;font-size:.7em"> <span>Correo: </span> {{$empresa->email}}</div> 
</td>
</tbody>
<hr style="color:#769fcd">

</table>
@php $suma_total = Helper::sumArray($datos,'total') @endphp
<!--<table style="font:arial, sans-serif;color:#0e49b5">
    <tr>
        <td><h4 style="margin-bottom:0">Gestión</h4></td>
    </tr>
</table>-->
<table style="font:arial, sans-serif;color:#393e46">
    <tr>
        <td><h6 style="margin-top:0">Estado Comercial Desde: {{ $fecha_inicio }} - Hasta {{ $fecha_fin }}</h6></td>
    </tr>
</table>
<div style="border: 1px solid #769fcd;border-radius:.2rem;background:#fff">
<table align="center" width="100%" style="font: arial , sans-serif;" class="table-report">
    <thead>
    <tr>
        <th style="background-color:#0061a8;color:#fff; font-size: 12px;text-align: center;border: 1px solid #0061a8">N°</th>
        <th style="background-color:#0061a8;color:#fff; font-size: 12px;text-align: center;border: 1px solid #0061a8">Asesor</th>
        @foreach ($estados as $element)
        <th style="background-color:#0061a8;color:#fff; font-size: 12px;text-align: center;border: 1px solid #0061a8">{{ $element->nombre }}</th>
        @endforeach
        <th style="background-color:#0061a8;color:#fff; font-size: 12px;text-align: center;border: 1px solid #0061a8">Total</th>
        <th style="background-color:#0061a8;color:#fff; font-size: 12px;text-align: center;border: 1px solid #0061a8">%</th>
    </tr>
    </thead>
    <tbody>
    @php $i=0; @endphp

    @foreach($datos as $result)
        @php $i++; @endphp
    <tr>
        <td style="text-align: center;font-size: 12px;">{{$i}}</td>
        <td style="font-size: 12px;">{{$result->vendedor}}</td>
        @foreach ($estados as $element)
        <td style="text-align: center;font-size: 12px;">{{$result->{"$element->nombre"} }}</td>
        @endforeach
        <td style="text-align: center;font-size: 12px;">{{$result->total }}</td>
        @php
            $valor_horizontal = ($result->total / $suma_total) * 100;
        @endphp
        <td style="text-align: center;background-color:#a3d2ca;font-size: 12px;">{{ number_format($valor_horizontal, 2, ',', '') }}%</td>
    </tr>
    @endforeach

    <tr>
        <td style="text-align: center;background-color:#a3d2ca;font-size: 12px;"></td>
        <td style="background-color:#a3d2ca;font-size: 12px;">Total</td>
        @foreach ($estados as $key => $element)
        <td style="text-align: center;background-color:#a3d2ca;font-size: 12px;">{!! Helper::sumArray($datos,$element->nombre) !!}</td>
        @endforeach
        <td style="text-align: center;background-color:#a3d2ca;font-size: 12px;">{!! Helper::sumArray($datos,'total') !!}</td>
        <td style="text-align: center;background-color:#a3d2ca;font-size: 12px;">100%</td>
    </tr>

    <tr>
        <td style="text-align: center;background-color:#a3d2ca;font-size: 12px;"></td>
        <td style="background-color:#a3d2ca;font-size: 12px;">Porcentaje</td>
        @foreach ($estados as $key => $element)
            @php
                $valor = Helper::sumArray($datos,$element->nombre);
                $valor = ($valor / $suma_total) * 100;
            @endphp
        <td style="text-align: center;background-color:#a3d2ca;font-size: 12px;">{{ number_format($valor, 2, ',', '') }}%</td>
        @endforeach
        <td style="text-align: center;background-color:#a3d2ca;font-size: 12px;">100%</td>
        <td style="text-align: center;background-color:#a3d2ca;font-size: 12px;"></td>
    </tr>
    </tbody>
</table>
</div>

<br>
<br>

<table align="center" width="100%" style="font:arial, sans-serif;font-size:.7em;border-bottom:1px dotted #769fcd">
    <tr>
        <td>USUARIO: {{ Auth::user()->name }}</td>
        <td style="text-align:right">FECHA: @php echo date('d-m-Y H:i:s') @endphp</td>
    </tr>
    <tr>
        <td style="text-align:right" colspan="2">Powered by: SocialTray - Links SA - copyright {{ date('Y') }}</td>
    </tr>
</table>