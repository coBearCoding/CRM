<table id="tbl" class="table table-bordered">
    <thead>
    <tr>
        <th>Código</th>
        <th>Nombre</th>
        <th>Menú Principal</th>
        <th class="text-center">Estado</th>
        <th class="text-center">Accion</th>
    </tr>
    </thead>
    <tbody>
    @foreach($lstResult as $result)
        <tr>
            <td>{{$result->id}}</td>
            <td>
                {{$result->nombre}}
            </td>
            <td>
                @if(!empty($result->menuPadre)) {{$result->menuPadre->nombre}} @else  @endif
            </td>
            <td class="text-center">@if($result->estado == 'A') <span
                        class="badge badge-success">ACTIVO</span> @else <span
                        class="badge badge-danger">INACTIVO</span> @endif </td>
            <td class="text-center">

                <div class="btn-group">
                    <button onclick="editar({{$result->id}})" data-id="{{$result->id}}" data-name="{{$result->nombre}}" type="button"
                            class="btn btn-info btn_edit"><i class="fas fa-edit"></i></button>
                    <button onclick="eliminar({{$result->id}},'{{$result->nombre}}')" data-id="{{$result->id}}" data-name="{{$result->nombre}}" type="button"
                            class="btn btn-danger btn_delete"><i class="fas fa-trash"></i></button>
                </div>

            </td>
        </tr>
    @endforeach
    </tbody>
</table>

