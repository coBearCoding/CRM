@component('mail::message')
# Notificación

Hola {{ $data->vendedor }}, Tienes el siguiente recordatorio. <br>

Nombre: {{ $data->nombre }}<br>
Teléfono: {{ $data->telefono }}<br>
Correo: {{ $data->correo }}<br>
Fecha de contacto: {{\Carbon\Carbon::parse($data->fecha_prox_contacto)->format('j F, Y')}} a las {{\Carbon\Carbon::parse($data->fecha_prox_contacto)->format('h:i:s A')}}<br>
Observación: {{ $data->observacion }}<br>



@component('mail::button', ['url' => env('APP_URL')])
Ir al CRM
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
