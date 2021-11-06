<style>

#datatable tbody tr:nth-child(even) {
            background-color: #f2f2f2;
            border-collapse: collapse;
        }
</style>
<table align="center" width="100%">
    <tr>
        <th rowspan="4" style="border-bottom:1px solid #0a66b7"> <img src="assets/images/logo_inicial.png" alt="" width="140px" style="vertical-align:center;"></th>
        <th style="text-align: left;height:12px;vertical-align:center;font-size:10px"
            colspan="7"><h2>{{$empresa->nombre}}</h2></th>
    </tr>
    <tr>
        <th style="text-align: left;height:12px;vertical-align:center;font-size:10px"
            colspan="7"> <p>RUC: {{$empresa->ruc}}</p></th>
    </tr>
    <tr>
        <th style="text-align: left;height:12px;vertical-align:center;font-size:10px"
            colspan="7"><p>TELÉFONOS: {{$empresa->telefonos}} - DIRECCIÓN: {{$empresa->direccion}}</p></th>
    </tr>
    <tr>
        <th style="text-align: left;border-bottom: 1px solid #0a66b7;height:12px;vertical-align:center;font-size:10px"
            colspan="7"><p>Desde: {{ $fecha_inicio }} - Hasta: {{ $fecha_fin }}</p></th>
    </tr>
</table>

<br>

<table id="datatable" align="center" width="100%">
    <thead>
    <tr>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center;height:20px;vertical-align:center;">N°</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center;vertical-align:center;">Asesor</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center;vertical-align:center;">Pasado</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center;vertical-align:center;">1 - 7 de {{ Helper::obtenerMes(date('m',strtotime($fecha_fin))) }}</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center;vertical-align:center;">8 - 14 de {{ Helper::obtenerMes(date('m',strtotime($fecha_fin))) }}</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center;vertical-align:center;">15 - 21 de {{ Helper::obtenerMes(date('m',strtotime($fecha_fin))) }}</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center;vertical-align:center;">22 - {{ date('t',strtotime($fecha_fin)) }} de {{ Helper::obtenerMes(date('m',strtotime($fecha_fin))) }}</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center;vertical-align:center;">Futuro</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center;vertical-align:center;">Total</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center;vertical-align:center;">%</th>
    </tr>
    </thead>
    <tbody>
    @php $i=0; $color = ""; $totales = 0;@endphp
    
    {{-- @php $suma_total = Helper::sumArray($datos,'total') @endphp --}}

    @foreach($datos as $result)
        @php
            $total_horizontal_aux = $result->pasado + $result->{"1-7"} + $result->{"8-14"} + $result->{"15-21"} + $result->{"22-31"} +  $result->futuro;
            $totales = $totales + $total_horizontal_aux;
        @endphp
    @endforeach

    @foreach($datos as $result)
        @php $i++; @endphp
 
    
       @php 
       if($i%2 == 0){
       $color = "#f2f2f2" ;
       }else{
       $color = "none" ;
       }
       @endphp
    
       
    
        <tr>
            <td style="text-align: center;background-color:{{$color}};border-bottom: 1px solid #0a66b7;height:20px;vertical-align:center;">{{$i}}</td>
            <td style="background-color:{{$color}};border-bottom: 1px solid #0a66b7">{{$result->asesor}}</td>
            <td style="text-align: center;background-color:{{$color}};border-bottom: 1px solid #0a66b7;vertical-align:center;">{{$result->pasado}}</td>
            <td style="text-align: center;background-color:{{$color}};border-bottom: 1px solid #0a66b7;vertical-align:center;">{{$result->{"1-7"} }}</td>
            <td style="text-align: center;background-color:{{$color}};border-bottom: 1px solid #0a66b7;vertical-align:center;">{{$result->{"8-14"} }}</td>
            <td style="text-align: center;background-color:{{$color}};border-bottom: 1px solid #0a66b7;vertical-align:center;">{{$result->{"15-21"} }}</td>
            <td style="text-align: center;background-color:{{$color}};border-bottom: 1px solid #0a66b7;vertical-align:center;">{{$result->{"22-31"} }}</td>
            <td style="text-align: center;background-color:{{$color}};border-bottom: 1px solid #0a66b7;vertical-align:center;">{{$result->futuro }}</td>
            @php
                $total_horizontal = $result->pasado + $result->{"1-7"} + $result->{"8-14"} + $result->{"15-21"} + $result->{"22-31"};
            @endphp
            <td style="text-align: center;background-color:{{$color}};border-bottom: 1px solid #0a66b7">{{ $total_horizontal }}</td>
            @php
                $porcentaje_horizontal = ($total_horizontal / $totales) * 100;
            @endphp
            <td style="text-align: center;background-color:#a3d2ca;border-bottom: 1px solid #0a66b7">{{ number_format($porcentaje_horizontal, 2, ',', '') }}%</td>
     
        </tr>
    @endforeach
        <tr>
            <td style="text-align: center;background-color:#a3d2ca;border-bottom: 1px solid #0a66b7;height:20px;vertical-align:center;"></td>
            <td style="background-color:#a3d2ca;border-bottom: 1px solid #0a66b7;vertical-align:center;">Total</td>
            
            <td style="text-align: center;background-color:#a3d2ca;border-bottom: 1px solid #0a66b7;vertical-align:center;">{!! Helper::sumArray($datos,'pasado') !!}</td>
            <td style="text-align: center;background-color:#a3d2ca;border-bottom: 1px solid #0a66b7;vertical-align:center;">{!! Helper::sumArray($datos,'1-7') !!}</td>
            <td style="text-align: center;background-color:#a3d2ca;border-bottom: 1px solid #0a66b7;vertical-align:center;">{!! Helper::sumArray($datos,'8-14') !!}</td>
            <td style="text-align: center;background-color:#a3d2ca;border-bottom: 1px solid #0a66b7;vertical-align:center;">{!! Helper::sumArray($datos,'15-21') !!}</td>
            <td style="text-align: center;background-color:#a3d2ca;border-bottom: 1px solid #0a66b7;vertical-align:center;">{!! Helper::sumArray($datos,'22-31') !!}</td>
            <td style="text-align: center;background-color:#a3d2ca;border-bottom: 1px solid #0a66b7;vertical-align:center;">{!! Helper::sumArray($datos,'futuro') !!}</td>

            <td style="text-align: center;background-color:#a3d2ca;border-bottom: 1px solid #0a66b7;vertical-align:center;">{{ $totales }}</td>
            <td style="text-align: center;background-color:#a3d2ca;border-bottom: 1px solid #0a66b7;vertical-align:center;">100%</td>
        </tr>

        <tr>
            <td style=";background-color:#a3d2ca;border-bottom: 1px solid #0a66b7;height: 20px;vertical-align:center;"></td>
            <td style=";background-color:#a3d2ca;border-bottom: 1px solid #0a66b7;vertical-align:center;">Porcentaje</td>
            
                @php
                    $valor1 = Helper::sumArray($datos,'pasado');
                    $valor1 = ($valor1 / $totales) * 100;

                    $valor2 = Helper::sumArray($datos,'1-7');
                    $valor2 = ($valor2 / $totales) * 100;

                    $valor3 = Helper::sumArray($datos,'8-14');
                    $valor3 = ($valor3 / $totales) * 100;

                    $valor4 = Helper::sumArray($datos,'15-21');
                    $valor4 = ($valor4 / $totales) * 100;

                    $valor5 = Helper::sumArray($datos,'22-31');
                    $valor5 = ($valor5 / $totales) * 100;

                    $valor6 = Helper::sumArray($datos,'futuro');
                    $valor6 = ($valor6 / $totales) * 100;
                @endphp
            <td style="text-align: center;background-color:#a3d2ca;border-bottom: 1px solid #0a66b7;vertical-align:center;">{{ number_format($valor1, 2, ',', '') }}%</td>
            <td style="text-align: center;background-color:#a3d2ca;border-bottom: 1px solid #0a66b7;vertical-align:center;">{{ number_format($valor2, 2, ',', '') }}%</td>
            <td style="text-align: center;background-color:#a3d2ca;border-bottom: 1px solid #0a66b7;vertical-align:center;">{{ number_format($valor3, 2, ',', '') }}%</td>
            <td style="text-align: center;background-color:#a3d2ca;border-bottom: 1px solid #0a66b7;vertical-align:center;">{{ number_format($valor4, 2, ',', '') }}%</td>
            <td style="text-align: center;background-color:#a3d2ca;border-bottom: 1px solid #0a66b7;vertical-align:center;">{{ number_format($valor5, 2, ',', '') }}%</td>
            <td style="text-align: center;background-color:#a3d2ca;border-bottom: 1px solid #0a66b7;vertical-align:center;">{{ number_format($valor6, 2, ',', '') }}%</td>

            <td style="text-align: center;background-color:#a3d2ca;border-bottom: 1px solid #0a66b7;vertical-align:center;">100%</td>
            <td style="text-align: center;background-color:#ffffff;border-bottom: 1px solid #0a66b7;vertical-align:center;"></td>
        </tr>

    </tbody>
</table>
{{-- <pre>
    @php
        print_r($datos);
    @endphp
</pre> --}}
<br>
<br>

<table align="center" width="100%" >
    <tr>
        <th colspan="4" style="border-bottom: 1px solid #0a66b7;text-align: left;vertical-align:center;height:20px">
            <h2>USUARIO: {{ Auth::user()->name }} </h2></th>
        <th colspan="4" style="border-bottom: 1px solid #0a66b7;text-align: right;vertical-align:center;height:20px">
            <p>FECHA: @php echo date('d-m-Y H:i:s') @endphp</p></th>
    </tr>
    <tr>
        <td style="text-align:right" colspan="8">Powered by: SocialTray - Links SA - copyright {{ date('Y') }}</td>
    </tr>
</table>