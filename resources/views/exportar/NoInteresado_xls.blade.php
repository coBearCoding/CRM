
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
    {{-- <img src="https://crm.ecotec.edu.ec/images/logo_inicial.jpg" alt="" style="max-width:210px"> --}}
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
@php
    $totales = 0;
    $total_horizontal = 0;
@endphp
@foreach($datos as $result)
@php
    $total_horizontal_aux =  $result->{"Factor_economico"} + $result->{"Horario"} + $result->{"Entorno"} + $result->{"Titulo"} + $result->{"Modalidad"} + $result->{"Maestria"} + $result->{"No_interesado"} + $result->{"Sede"} +$result->{"Sin_motivo"} +$result->{"Otros"};
    $totales = $totales + $total_horizontal_aux;
@endphp
@endforeach
<!--<table style="font:arial, sans-serif;color:#0e49b5">
    <tr>
        <td><h4 style="margin-bottom:0"></h4></td>
    </tr>
</table>-->
<table style="font:arial, sans-serif;color:#393e46">
    <tr>
        <td><h6 style="margin-top:0"> Desde: {{ $fecha_inicio }} - Hasta {{ $fecha_fin }}</h6></td>
    </tr>
</table>
<div style="border: 1px solid #769fcd;border-radius:.2rem;background:#fff">
<table align="center" width="100%" style="font: arial , sans-serif;" class="table-report">
    <thead>
    <tr>
        <th style="background-color:#0061a8;color:#fff; font-size: 12px;text-align: center;border: 1px solid #0061a8">N°</th>
        <th style="background-color:#0061a8;color:#fff; font-size: 12px;text-align: center;border: 1px solid #0061a8">Asesor</th>
        <th style="background-color:#0061a8;color:#fff; font-size: 12px;text-align: center;border: 1px solid #0061a8">Factor_economico</th>
        <th style="background-color:#0061a8;color:#fff; font-size: 12px;text-align: center;border: 1px solid #0061a8">Horario</th>
        <th style="background-color:#0061a8;color:#fff; font-size: 12px;text-align: center;border: 1px solid #0061a8">Entorno</th>
        <th style="background-color:#0061a8;color:#fff; font-size: 12px;text-align: center;border: 1px solid #0061a8">Titulo</th>
        <th style="background-color:#0061a8;color:#fff; font-size: 12px;text-align: center;border: 1px solid #0061a8">Modalidad</th>
        <th style="background-color:#0061a8;color:#fff; font-size: 12px;text-align: center;border: 1px solid #0061a8">Maestria</th>
        <th style="background-color:#0061a8;color:#fff; font-size: 12px;text-align: center;border: 1px solid #0061a8">No_interesado</th>
        <th style="background-color:#0061a8;color:#fff; font-size: 12px;text-align: center;border: 1px solid #0061a8">Sede</th>
        <th style="background-color:#0061a8;color:#fff; font-size: 12px;text-align: center;border: 1px solid #0061a8">Sin_motivo</th>
        <th style="background-color:#0061a8;color:#fff; font-size: 12px;text-align: center;border: 1px solid #0061a8">Otros</th>
        <th style="background-color:#0061a8;color:#fff; font-size: 12px;text-align: center;border: 1px solid #0061a8">Total</th>
        <th style="background-color:#0061a8;color:#fff; font-size: 12px;text-align: center;border: 1px solid #0061a8">Porcentaje</th>
    </tr>
    </thead>
    <tbody>
    @php $i=0; @endphp

    @foreach($datos as $result)
        @php $i++; @endphp
    <tr>
        <td style="text-align: center;font-size: 12px;">{{$i}}</td>
        <td style="font-size: 12px;">{{$result->asesor}}</td>
        <td style="text-align: center;font-size: 12px;">{{$result->Factor_economico}}</td>
        <td style="text-align: center;font-size: 12px;">{{$result->Horario}}</td>
        <td style="text-align: center;font-size: 12px;">{{$result->Entorno}}</td>
        <td style="text-align: center;font-size: 12px;">{{$result->Titulo}}</td>
        <td style="text-align: center;font-size: 12px;">{{$result->Modalidad}}</td>
        <td style="text-align: center;font-size: 12px;">{{$result->Maestria}}</td>
        <td style="text-align: center;font-size: 12px;">{{$result->No_interesado}}</td>
        <td style="text-align: center;font-size: 12px;">{{$result->Sede}}</td>
        <td style="text-align: center;font-size: 12px;">{{$result->Sin_motivo}}</td>
        <td style="text-align: center;font-size: 12px;">{{$result->Otros}}</td>
        {{-- <td style="text-align: center;font-size: 12px;">{{$result->Total}}</td> --}}
            @php
                $total_horizontal =  $result->{"Factor_economico"} + $result->{"Horario"} + $result->{"Entorno"} + $result->{"Titulo"} + $result->{"Modalidad"} + $result->{"Maestria"} + $result->{"No_interesado"} + $result->{"Sede"} +$result->{"Sin_motivo"} +$result->{"Otros"};
            @endphp

        <td style="text-align: center;font-size: 12px;">{{$total_horizontal }}</td>
        @php
            $porcentaje_horizontal = ($total_horizontal / $totales) * 100;
        @endphp
        <td style="text-align: center;background-color:#a3d2ca;font-size: 12px;">{{ number_format($porcentaje_horizontal, 2, ',', '') }}%</td>
    </tr>
    @endforeach

    <tr>
        <td style="text-align: center;background-color:#a3d2ca;font-size: 12px;"></td>
        <td style="background-color:#a3d2ca;font-size: 12px;">Total</td>
        <td style="text-align: center;background-color:#a3d2ca;font-size: 12px;">{!! Helper::sumArray($datos,'Factor_economico') !!}</td>
        <td style="text-align: center;background-color:#a3d2ca;font-size: 12px;">{!! Helper::sumArray($datos,'Horario') !!}</td>
        <td style="text-align: center;background-color:#a3d2ca;font-size: 12px;">{!! Helper::sumArray($datos,'Entorno') !!}</td>
        <td style="text-align: center;background-color:#a3d2ca;font-size: 12px;">{!! Helper::sumArray($datos,'Titulo') !!}</td>
        <td style="text-align: center;background-color:#a3d2ca;font-size: 12px;">{!! Helper::sumArray($datos,'Modalidad') !!}</td>
        <td style="text-align: center;background-color:#a3d2ca;font-size: 12px;">{!! Helper::sumArray($datos,'Maestria') !!}</td>
        <td style="text-align: center;background-color:#a3d2ca;font-size: 12px;">{!! Helper::sumArray($datos,'No_interesado') !!}</td>
        <td style="text-align: center;background-color:#a3d2ca;font-size: 12px;">{!! Helper::sumArray($datos,'Sede') !!}</td>
        <td style="text-align: center;background-color:#a3d2ca;font-size: 12px;">{!! Helper::sumArray($datos,'Sin_motivo') !!}</td>
        <td style="text-align: center;background-color:#a3d2ca;font-size: 12px;">{!! Helper::sumArray($datos,'Otros') !!}</td>
        {{-- <td style="text-align: center;background-color:#a3d2ca;font-size: 12px;">{!! Helper::sumArray($datos,'Total') !!}</td> --}}
        <td style="text-align: center;background-color:#a3d2ca;font-size: 12px;">{{ $totales }}</td>
        <td style="text-align: center;background-color:#a3d2ca;font-size: 12px;">100%</td>
    </tr>

    <tr>
        <td style="text-align: center ;background-color:#a3d2ca;font-size: 12px;"></td>
        <td style="background-color:#a3d2ca;font-size: 12px;">Porcentaje</td>

        @php
        $valor1 = Helper::sumArray($datos,'Factor_economico');
        $valor1 = ($valor1 / $totales) * 100;

        $valor2 = Helper::sumArray($datos,'Horario');
        $valor2 = ($valor2 / $totales) * 100;

        $valor3 = Helper::sumArray($datos,'Entorno');
        $valor3 = ($valor3 / $totales) * 100;

        $valor4 = Helper::sumArray($datos,'Titulo');
        $valor4 = ($valor4 / $totales) * 100;

        $valor5 = Helper::sumArray($datos,'Modalidad');
        $valor5 = ($valor5 / $totales) * 100;

        $valor6 = Helper::sumArray($datos,'Maestria');
        $valor6 = ($valor6 / $totales) * 100;

        $valor7 = Helper::sumArray($datos,'No_interesado');
        $valor7 = ($valor7 / $totales) * 100;

        $valor8 = Helper::sumArray($datos,'Sede');
        $valor8 = ($valor8 / $totales) * 100;

        $valor9 = Helper::sumArray($datos,'Sin_motivo');
        $valor9 = ($valor9 / $totales) * 100;

        $valor10 = Helper::sumArray($datos,'Otros');
        $valor10 = ($valor10 / $totales) * 100;

        $valor11 = Helper::sumArray($datos,'Total');
        $valor11 = ($valor11 / $totales) * 100;


    @endphp
    <td style="text-align: center; background-color:#a3d2ca;font-size: 12px;">{{ number_format($valor1, 2, ',', '') }}%</td>
    <td style="text-align: center; background-color:#a3d2ca;font-size: 12px;">{{ number_format($valor2, 2, ',', '') }}%</td>
    <td style="text-align: center; background-color:#a3d2ca;font-size: 12px;">{{ number_format($valor3, 2, ',', '') }}%</td>
    <td style="text-align: center; background-color:#a3d2ca;font-size: 12px;">{{ number_format($valor4, 2, ',', '') }}%</td>
    <td style="text-align: center; background-color:#a3d2ca;font-size: 12px;">{{ number_format($valor5, 2, ',', '') }}%</td>
    <td style="text-align: center; background-color:#a3d2ca;font-size: 12px;">{{ number_format($valor6, 2, ',', '') }}%</td>
    <td style="text-align: center; background-color:#a3d2ca;font-size: 12px;">{{ number_format($valor7, 2, ',', '') }}%</td>
    <td style="text-align: center; background-color:#a3d2ca;font-size: 12px;">{{ number_format($valor8, 2, ',', '') }}%</td>
    <td style="text-align: center; background-color:#a3d2ca;font-size: 12px;">{{ number_format($valor9, 2, ',', '') }}%</td>
    <td style="text-align: center; background-color:#a3d2ca;font-size: 12px;">{{ number_format($valor10, 2, ',', '') }}%</td>
    <td style="text-align: center; background-color:#a3d2ca;font-size: 12px;">{{ number_format($valor11, 2, ',', '') }}%</td>

        <td style="text-align: center; background-color:#a3d2ca;font-size: 12px;">100%</td>
        <td style="text-align: center; background-color:#a3d2ca;font-size: 12px;"></td>
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
        <td style="text-align:right" colspan="2">Powered by: Ecotec - copyright {{ date('Y') }}</td>
    </tr>
</table>
