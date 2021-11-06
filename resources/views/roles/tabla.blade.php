<table id="tbl_roles" class="table table-bordered">
    <thead>
    <tr>
        <th>Nombre</th>
        <th class="text-center">Estado</th>
        <th class="text-center">Accion</th>
    </tr>
    </thead>
    <tbody>
    @foreach($lstRol as $rol)
    <tr>
        <td>{{$rol->nombre}}</td>
        <td class="text-center">@if($rol->estado == 'A') <span class="badge badge-success">ACTIVO</span> @else <span class="badge badge-danger">INACTIVO</span> @endif </td>
        <td class="text-center">
            @if($rol->sistema != 1)
            <div class="btn-group">
                <button onclick="editar({{$rol->id}})" data-id="{{$rol->id}}" data-name="{{$rol->nombre}}"  type="button" class="btn btn-info btn_edit"><i class="fas fa-edit"></i></button>
                <button onclick="eliminar({{$rol->id}},'{{$rol->nombre}}')" data-id="{{$rol->id}}" data-name="{{$rol->nombre}}" type="button" class="btn btn-danger btn_delete"><i class="fas fa-trash"></i></button>
            </div>
            @endif
        </td>
    </tr>
    @endforeach
    </tbody>
</table>

