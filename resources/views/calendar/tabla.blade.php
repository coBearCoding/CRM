<table id="tbl" class="table table-bordered">
    <thead>
    <tr>
        <th>Nombre</th>
        <th class="text-center">Estado</th>
        <th class="text-center">Accion</th>
    </tr>
    </thead>
    <tbody>
    @foreach($lstResult as $res)
    <tr>
        <td>{{$res->nom_medio_gestion}}</td>
        <td class="text-center">@if($res->st_medio_gestion == 'A') <span class="badge badge-success">ACTIVO</span> @else <span class="badge badge-danger">INACTIVO</span> @endif </td>
        <td class="text-center">
            @if($res->permiso != 1)
            <div class="btn-group">
                <button data-id="{{$res->cod_medio_gestion}}" data-name="{{$res->nom_medio_gestion}}"  type="button" class="btn btn-info btn_edit"><i class="fas fa-edit"></i></button>
                <button data-id="{{$res->cod_medio_gestion}}" data-name="{{$res->nom_medio_gestion}}" type="button" class="btn btn-danger btn_delete"><i class="fas fa-trash"></i></button>
            </div>
            @endif
        </td>
    </tr>
    @endforeach
    </tbody>
</table>

