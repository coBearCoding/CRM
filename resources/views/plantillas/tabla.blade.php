
<table id="tbl" class="table table-bordered">
    <thead>
    <tr>
        <th>#</th>
        <th>Nombre</th>
        <th class="text-center">Campaña</th>
        <th class="text-center">Estado</th>
        <th class="text-center">Accion</th>
    </tr>
    </thead>
    <tbody>
    @foreach($listPlantilla as $result)
         <tr>
            <td>
                {{$result->id}}
            </td>
            <td>
                {{$result->nombre}}
            </td>
            <td>
                {{$result->nom_campana}}
            </td>
            <td class="text-center">@if($result->estado == 'A') <span
                        class="badge badge-success">ACTIVO</span> @else <span
                        class="badge badge-danger">INACTIVO</span> @endif </td>
            <td class="text-center">

                <div class="btn-group">
                    <button onclick="editar('{{$result->id}}')" type="button"
                            class="btn btn-info btn_edit"><i class="fas fa-edit"></i></button>
                    <button onclick="preview('{{$result->id}}')" type="button"
                            class="btn btn-warning btn_ver"><i class="fas fa-eye"></i></button>
                     <a style="color:#FFFFFF" onclick="javascript: eliminar('{{$result->id}}','{{$result->nombre}}')" class="btn btn-danger btn_delete"><i class="fas fa-trash"></i></a>
                </div>

            </td>
        </tr>
    @endforeach
    </tbody>
</table>

