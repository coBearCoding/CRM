<table id="tbl" class="table table-bordered">
    <thead>
    <tr>
        <th>Código</th>
        <th>Nombre</th>
        <th class="text-center">Estado</th>
        <th class="text-center">Accion</th>
    </tr>
    </thead>
    <tbody>
    @foreach($lstResult as $res)
    <tr>
        <td>{{$res->id}}</td>
        <td>{{$res->nombre}}</td>
        <td class="text-center">@if($res->estado == 'A') <span class="badge badge-success">ACTIVO</span> @else <span class="badge badge-danger">INACTIVO</span> @endif </td>
        <td class="text-center">
            @if($res->permiso != 1)
            <div class="btn-group">
                <button onclick="editar({{$res->id}})" data-id="{{$res->id}}" data-name="{{$res->nombre}}"  type="button" class="btn btn-info btn_edit"><i class="fas fa-edit"></i></button>
                <button onclick="eliminar({{$res->id}},'{{$res->nombre}}')" data-id="{{$res->id}}" data-name="{{$res->nombre}}" type="button" class="btn btn-danger btn_delete"><i class="fas fa-trash"></i></button>
            </div>
            @endif
        </td>
    </tr>
    @endforeach
    </tbody>
</table>

