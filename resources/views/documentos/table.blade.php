<table id="tbl_documentos" class="table table-bordered">
    <thead class="thead-light">
    <tr>
        <th scope="col">oferta Academica</th>
        <th scope="col">Nombre</th>
        <th scope="col">Tipo de Documento</th>
        <th scope="col">Es requerido</th>
        <th scope="col">Acciones</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($results as $doc)
        <tr>
            <td>{{ $doc->servicio->nombre ?? '' }}</td>
            <td>{{ $doc->nombre ?? '' }}</td>
            <td>{{ $doc->tipo_documento->nombre ?? '' }}</td>
            <td>{{ $doc->requerido == 'S' ? 'SI' : 'NO' }}</td>
            <td><a href="#!" class="table-action" data-toggle="tooltip" data-original-title="Edit" onclick="editar({{ $doc->id }},{{ $doc->servicio_id }},'{{ $doc->nombre }}',{{ $doc->tipo_documento_id }},'{{ $doc->requerido }}')">
                        <i class="fas fa-edit"></i>
                      </a></td>
        </tr>
    @endforeach
    </tbody>
</table>