<table id="tbl_servicios" class="table table-bordered">
    <thead>
    <tr>
        <th>Nombre</th>
        <th>Sector</th>
        <th>Sigla</th>
        <th>Carpeta</th>
        <th>Opciones</th>
    </tr>
    </thead>
    <tbody>
    @foreach($results as $rst)
        <tr>
            <td>{{$rst->nombre}}</td>
            <td>{{$rst->sector}}</td>
            <td>{{$rst->sigla}}</td>
            <td>{{$rst->cod_caja}}</td>
            <td>
                @if($rst->permiso != 1)
                    <div class="btn-group">
                        <button data-id="{{$rst->id}}"
                                onclick="showInfo({{$rst->id}},'{{$rst->nombre_entidad}}','{{$rst->sector}}','{{$rst->sigla}}','{{$rst->cod_caja}}')"
                                data-name="{{$rst->nombre}}" type="button" class="btn btn-info btn_edit"
                                data-toggle="modal" data-target=".modal-example"><i class="fas fa-edit"></i></button>
                        <button data-id="{{$rst->id}}" data-name="{{$rst->nombre}}" type="button"
                                class="btn btn-danger btn_delete"><i class="fas fa-trash"></i></button>
                    </div>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

