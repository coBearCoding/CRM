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
    @foreach($lsResult as $result)
        <tr>
            <td class="text-center">{{ $result->id }}</td>
            <td>
                <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left mr-3">
                           <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                                    <span class="icon-wrapper-bg" style="background-color: {{$result->color}} "></span>

                                    <i class="icon icon-anim-pulse {{$result->icono}}"
                                       style="color: {{$result->color}}"></i>
                                </span>
                        </div>
                        <div class="widget-content-left">
                            <div class="widget-heading">{{$result->nombre}}</div>
                        </div>
                    </div>
                </div>
            </td>
            <td class="text-center">@if($result->estado == 'A') <span
                        class="badge badge-success">ACTIVO</span> @else <span
                        class="badge badge-danger">INACTIVO</span> @endif </td>
            <td class="text-center">

                <div class="btn-group">
                    <button onclick="editar({{$result->id}})"  data-id="{{$result->id}}" data-name="{{$result->nombre}}" type="button"
                            class="btn btn-info btn_edit"><i class="fas fa-edit"></i></button>
                    <button onclick="eliminar({{$result->id}},'{{$result->nombre}}')" data-id="{{$result->id}}" data-name="{{$result->nombre}}" type="button"
                            class="btn btn-danger btn_delete"><i class="fas fa-trash"></i></button>
                </div>

            </td>
        </tr>
    @endforeach
    </tbody>
</table>

