<table id="tbl_users" class="table table-bordered">
    <thead>
    <tr>
        <th>Nombre</th>
        <th>Rol</th>
        <th>Sede</th>
        <th>Estado</th>
        <th class="text-center">Accion</th>
    </tr>
    </thead>
    <tbody>
    @foreach($lstUser as $user)
        <tr>
            <td>{{$user->name}} <br>{{$user->email}}</td>
            <td>{{$user->rol}}</td>
            <td>@if($user->sede == '') TODAS @else {{$user->sede}} @endif</td>
            <td>@if($user->status == 'A')  <span class="badge badge-success">ACTIVO</span> @else <span class="badge badge-danger">INACTIVO</span> @endif </td>
            <td class="text-center">

                    <div class="btn-group">
                        <button onclick="Editar({{$user->id}})" data-id="{{$user->id}}" data-name="{{$user->name}}"
                                type="button"
                                class="btn btn-info btn_edit"><i class="fas fa-edit"></i></button>
                        <button onclick="eliminar({{$user->id}})" data-id="{{$user->id}}" data-name="{{$user->name}}"
                                type="button"
                                class="btn btn-danger btn_delete"><i class="fas fa-trash"></i></button>
                    </div>

            </td>
        </tr>
    @endforeach
    </tbody>
</table>

