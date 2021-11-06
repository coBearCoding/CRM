<div class="btn-group">
<button data-toggle="tooltip" data-placement="top" title="Llamar" type="button" class="btn btn-success" onclick="llamada('{{ $contacto_tipo['contacto']['telefono'] }}','{{ $contacto_tipo['contacto']['nombre'] }}',{{ $contacto_tipo_id }})"><i class="fas fa-phone"></i></button>
<button onclick="para('{{ $contacto_tipo['contacto']['correo'] }}',{{ $contacto_tipo_id }},'{{ $contacto_tipo['contacto']['nombre'] }}')" data-toggle="modal" data-target=".modal-envio"  title="Envio Transaccional"  title="Editar" type="button" class="btn btn-primary"><i class="fa fa-envelope"></i></button>
{{--<button data-toggle="modal" data-target=".modal-seguimiento" title="Seguimiento de Leads" onclick="seguimiento({{$contacto_tipo_id}})"  type="button" class="btn btn-warning"><i class="fa fa-user"></i></button>--}}
<button data-toggle="modal" data-target=".modal-seguimiento-show" title="Seguimiento de Leads historial" onclick="auditoriaShow({{$contacto_tipo_id}})"  type="button" class="btn btn-secondary"><i class="fa fa-tasks"></i></button>
<button onclick="preguntasModal({{ $contacto_tipo_id }},'')" data-toggle="modal" data-target=".modal-pregunta"  title="Preguntas" type="button" class="btn btn-primary"><i class="fas fa-question"></i></button>
{{-- <button onclick="preguntasModal({{ $contacto_tipo_id }},{{ $campana_programa['programa']['nprimario_id']}})" data-toggle="modal" data-target=".modal-pregunta"  title="Preguntas" type="button" class="btn btn-primary"><i class="fas fa-question"></i></button> --}}
</div>
<br>
<div class="btn-group" style="padding-top: 15px">
<button data-toggle="modal" data-target=".modal-lead" title="Editar" onclick="ver_info({{$contacto_tipo_id}})" type="button" class="btn btn-info"><i class="fa fa-edit"></i></button>
<button data-toggle="modal" data-target=".modal-estado" title="Estado Comercial" onclick="estado({{$contacto_tipo_id}},{{$id}},this)" type="button" class="btn btn-primary"><i class="fa fa-archive"></i></button>

<a data-toggle="tooltip" data-placement="top" title="WhatsApp" target="_blank" onclick="Registro({{ $contacto_tipo_id }})" href="https://api.whatsapp.com/send?phone=+593{!! Helper::phone($contacto_tipo['contacto']['telefono']) !!}&text=Hola {{$contacto_tipo['contacto']['nombre']}}, un gusto saludarte..." class="btn btn-success"><i class="fa fa-whatsapp" aria-hidden="true"></i>
</a>
@if (Auth::user()->roles->id == 1 || Auth::user()->roles->id == 2 || Auth::user()->roles->id == 4)
<button data-toggle="tooltip" data-placement="top" title="Eliminar" onclick="eliminar({{$contacto_tipo_id}},'{{ $contacto_tipo['contacto']['nombre'] }}','Eliminar')" type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button>
@endif
</div>
