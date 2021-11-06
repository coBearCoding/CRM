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
        @foreach ($estados as $element)
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center;height:20px;vertical-align:center;">{{ $element->nombre }}</th>
        @endforeach
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center;vertical-align:center;">Total</th>
        <th style="background-color: #0a66b7;color: #FFFFFF; font-size: 12px;text-align: center;vertical-align:center;">%</th>
    </tr>
    </thead>
    <tbody>
    @php $i=0; $color = ""; @endphp
    
    @php $suma_total = Helper::sumArray($datos,'total') @endphp

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
            <td style="background-color:{{$color}};border-bottom: 1px solid #0a66b7">{{$result->vendedor}}</td>
            @foreach ($estados as $key => $element)
            <td style="text-align: center;background-color:{{$color}};border-bottom: 1px solid #0a66b7;vertical-align:center;">{{$result->{"$element->nombre"} }} </td>
            @endforeach
            <td style="text-align: center;background-color:{{$color}};border-bottom: 1px solid #0a66b7;vertical-align:center;">{{$result->total }}</td>
            @php
                $valor_horizontal = ($result->total / $suma_total) * 100;
            @endphp
            <td style="text-align: center;background-color:#a3d2ca;border-bottom: 1px solid #0a66b7;vertical-align:center;">{{ number_format($valor_horizontal, 2, ',', '') }}%</td>
        </tr>
    @endforeach
        <tr>
            <td style="text-align: center;background-color:#a3d2ca;border-bottom: 1px solid #0a66b7;height:20px;vertical-align:center;"></td>
            <td style="background-color:#a3d2ca;border-bottom: 1px solid #0a66b7;vertical-align:center;">Total</td>
            @foreach ($estados as $key => $element)
            <td style="text-align: center;background-color:#a3d2ca;border-bottom: 1px solid #0a66b7;vertical-align:center;">{!! Helper::sumArray($datos,$element->nombre) !!}</td>
            @endforeach
            <td style="text-align: center;background-color:#a3d2ca;border-bottom: 1px solid #0a66b7;vertical-align:center;">{!! Helper::sumArray($datos,'total') !!}</td>
            <td style="text-align: center;background-color:#a3d2ca;border-bottom: 1px solid #0a66b7;vertical-align:center;">100%</td>
        </tr>

        <tr>
            <td style="text-align: center;background-color:#a3d2ca;border-bottom: 1px solid #0a66b7;height:20px;;vertical-align:center;"></td>
            <td style="background-color:#a3d2ca;border-bottom: 1px solid #0a66b7;vertical-align:center;">Porcentaje</td>
            @foreach ($estados as $key => $element)
                @php
                    $valor = Helper::sumArray($datos,$element->nombre);
                    $valor = ($valor / $suma_total) * 100;
                @endphp
            <td style="text-align: center;background-color:#a3d2ca;border-bottom: 1px solid #0a66b7;vertical-align:center;">{{ number_format($valor, 2, ',', '') }}%</td>
            @endforeach
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
        <th colspan="3" style="border-bottom: 1px solid #0a66b7;text-align: left;height:20px;vertical-align:center">
            <h2>USUARIO: {{ Auth::user()->name }} </h2></th>
        <th colspan="4" style="border-bottom: 1px solid #0a66b7;text-align: right;height:20px;vertical-align:center">
            <p>FECHA: @php echo date('d-m-Y H:i:s') @endphp</p></th>
    </tr>
    <tr>
        <td style="text-align:right" colspan="7">Powered by: SocialTray - Links SA - copyright {{ date('Y') }}</td>
    </tr>
</table>