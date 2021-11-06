<table id="tbl" class="table table-bordered">
    <thead>
    <tr>
        <th>Codigo</th>
        <th>Nombre</th>
        <th>Campaña</th>
        <th class="text-center">Estado</th>
        <th class="text-center">Accion</th>
    </tr>
    </thead>
    <tbody>
    @foreach($lstResult as $result)
        <tr>
            <td>
                {{$result->id}}
            </td>
            <td>
                {{$result->nombre}}
            </td>
            <td>
                {{$result->campana->nombre}}
            </td>
            <td class="text-center">@if($result->estado == 'A') <span
                        class="badge badge-success">ACTIVO</span> @else <span
                        class="badge badge-danger">INACTIVO</span> @endif </td>
            <td class="text-center">

                <div class="btn-group">
                    <button onclick="editData('{{$result->id}}')" type="button"
                            class="btn btn-info btn_edit"><i class="fas fa-edit"></i></button>
                    <button onclick="showPreview('{{$result->html_texto}}')" type="button"
                            class="btn btn-warning btn_ver"><i class="fas fa-eye"></i></button>
                    <!--<button data-id="{{$result->id}}" data-name="{{$result->nombre}}" type="button"
                            class="btn btn-danger btn_delete"><i class="fas fa-trash"></i></button>-->
                    <button onclick="eliminar('{{$result->id}}','{{$result->nombre}}')" data-id="{{$result->id}}" data-name="{{$result->nombre}}" type="button" class="btn btn-danger btn_delete"><i class="fas fa-trash"></i></button>
                </div>

            </td>
        </tr>
    @endforeach
    </tbody>
</table>

