<div class="btn-group">
<button data-toggle="tooltip" data-placement="top" title="Llamar" type="button" class="btn btn-success" onclick="llamada('{{ $contacto['telefono'] }}','{{ $contacto['nombre'] }}',{{ $id }})"><i class="fas fa-phone"></i></button>
<button onclick="para('{{ $contacto['correo'] }}',{{ $id }})" data-toggle="modal" data-target=".modal-envio"  title="Envio Transaccional"  title="Editar" type="button" class="btn btn-primary"><i class="fa fa-envelope"></i></button>
<button data-toggle="modal" data-target=".modal-seguimiento" title="Tratamiento de Leads"  type="button" class="btn btn-warning"><i class="fa fa-user"></i></button>
</div>
<br>
<div class="btn-group" style="padding-top: 15px">
<button data-toggle="modal" data-target=".modal-lead" title="Editar" onclick="ver_info({{$id}})" type="button" class="btn btn-info"><i class="fa fa-edit"></i></button>
<button data-toggle="tooltip" data-placement="top" title="Eliminar" onclick="eliminar({{$id}},'{{ $id }}','Eliminar')" type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button>
</div>
