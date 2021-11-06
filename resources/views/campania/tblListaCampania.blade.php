<?php  ?>
<table style="width: 100%;" id="tblListaCampana" class="table table-hover table-striped table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>{{session('nivel1')}}</th>
            <th>Inicio Campaña</th>
            <th>Final Campaña</th>
            <th>Estado</th>

            <th>Apertura</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>
        @php $count=1; @endphp
        @foreach($listaCampania as $row)
            <tr>
                <td>{{$row->id}}</td>
                <td>{{$row->nombre}}</td>
                <td>{{$row->nombre_oferta_academica}}</td>
                <td>{{$row->fecha_inicio}}</td>
                <td>{{$row->fecha_fin}}</td>

                <td><div class="{{$row->colorApertura}}">{{$row->apertura}}</div></td>
                <td>@if($row->estado == 'A') <span
                        class="badge badge-success">ACTIVO</span> @else <span
                        class="badge badge-danger">INACTIVO</span> @endif </td>

                <td>
                    <div class="btn-group">
                      
                        <a style="color:#FFFFFF" onclick = "javascript: editarCampana('{{$row->id}}');" class="btn btn-info btn_edit"><i class="fas fa-edit"></i></a>
                        
                        <a style="color:#FFFFFF" onclick="javascript: eliminarCampana('{{$row->id}}','{{$row->nombre}}')" class="btn btn-danger btn_delete"><i class="fas fa-trash"></i></a>
                        <button data-toggle="modal" data-target="#modalPrograma" title="Programas" type="button" class="btn btn-warning" onclick="nsecundario({{$row->id}})"><i class="fas fa-eye"></i></button>
                    </div>    
                    
                </td>

            </tr>
            @php $count++; @endphp     
        @endforeach
                                        
    </tbody>
</table>




