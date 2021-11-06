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
    @foreach($lstInfo as $info)
    <tr>
        <td>{{$info->id}}</td>
        <td>{{$info->nombre}}</td>
        <td class="text-center">@if($info->estado == 'A') <span class="badge badge-success">ACTIVO</span> @else <span class="badge badge-danger">INACTIVO</span> @endif </td>
        <td class="text-center">
            @if($info->sistema != 1)
            <div class="btn-group">
                <button onclick="editar({{$info->id}})" data-id="{{$info->id}}" data-name="{{$info->nombre}}"  type="button" class="btn btn-info btn_edit"><i class="fas fa-edit"></i></button>
                <button onclick="eliminar({{$info->id}},'{{$info->nombre}}')" data-id="{{$info->id}}" data-name="{{$info->nombre}}" type="button" class="btn btn-danger btn_delete"><i class="fas fa-trash"></i></button>
            </div>
            @endif
        </td>
    </tr>
    @endforeach
    </tbody>
</table>

