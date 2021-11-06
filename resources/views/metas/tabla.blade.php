<?php?>
<table id="tbl" class="table table-hover table-striped table-bordered">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Sede</th>
            <th>Inicio</th>
            <th>Final</th>
            <th>N° Lead</th>
            <th>N° Cliente</th>
            <th>Estado</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($lstMetas as $row)
            <tr>
                <td>{{$row->nombre}}</td>
                <td>@if($row->sede == '') TODAS @else {{$row->sede->nombre}} @endif</td>
                <td>{{$row->fecha_ini}}</td>
                <td>{{$row->fecha_fin}}</td>
                <td>{{$row->num_lead}}</td>
                <td>{{$row->num_cliente}}</td>
                <td>@if($row->estado == 'A')  <span class="badge badge-success">ACTIVO</span> @else <span class="badge badge-danger">INACTIVO</span> @endif </td>
                <td class="text-center">

                    <div class="btn-group">
                        <button onclick="editar({{$row->id}})" data-id="{{$row->id}}" data-name="{{$row->nombre}}"
                                type="button"
                                class="btn btn-info btn_edit"><i class="fas fa-edit"></i></button>
                        <button onclick="eliminar({{$row->id}},'{{$row->nombre}}')" data-id="{{$row->id}}" data-name="{{$row->nombre}}"
                                type="button"
                                class="btn btn-danger btn_delete"><i class="fas fa-trash"></i></button>
                    </div>

                </td>
            </tr>
        @endforeach

    </tbody>
</table>




