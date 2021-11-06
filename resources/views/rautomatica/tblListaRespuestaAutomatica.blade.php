
<table  id="tblListaCampana" class="table table-hover table-striped table-bordered">
    <thead>
        <tr>
            <th style="width: 5%;">#</th>
            <th style="width: 30%;">Nombre</th>
            <th style="width: 50%;">Formulario</th>
            <th style="width: 20%;">Opciones</th>
        </tr>
    </thead>
    <tbody>
        @php $count=1; @endphp
        @foreach($listaRespAuto as $row)
            <tr>
                <td>{{$count}}</td>
                <td>{{$row->nombre}}</td>
                <td>{{$row->nom_formulario}}</td>
                <td>
                    <div class="btn-group">
                        
                      <!--  <a style="color:#FFFFFF" onclick = "javascript: editarFormulario('{{$row->id}}');" class="btn btn-info btn_edit"><i class="fas fa-edit"></i></a>-->
                       
                        <a style="color:#FFFFFF" onclick="javascript: eliminarFormulario('{{$row->id}}','{{$row->nombre}}')" class="btn btn-danger btn_delete"><i class="fas fa-trash"></i></a>
                    </div>    
                    
                </td>
            </tr>
            @php $count++; @endphp     
        @endforeach
                                        
    </tbody>
</table>

