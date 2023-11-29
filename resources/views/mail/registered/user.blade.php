@component('mail::message')
# ¡Buen día, {{ $data['name'] }}!
# Bienvenido al sistema {{ config('app.name') }}
Has sido registrado con los siguientes datos:
<br>
Usuario: {{ $data['email'] }}
<br>
Password: {{ $data['password'] }}
<br>
@component('mail::button', ['url' => $data["urlEmail"], 'color' => 'green'])
    Acceder con un click
@endcomponent
O acceder con tus datos:
@component('mail::button', ['url' => $url, 'color' => 'blue'])
    Acceder
@endcomponent
Si quieres reportar algún error, hacer una pregunta o solicitar una característica nueva, puedes hacerlo desde aquí:
@component('mail::button', ['url' => 'https://forms.gle/YjbAwnELxm8WxRxQ7', 'color' => 'red'])
    Centro de Ayuda
@endcomponent
Gracias,<br>
{{ config('app.name') }}
<hr>
Si tienes problemas para visualizar el boton, puedes hacer click en el siguiente enlace: <a href="{{$data["urlEmail"]}}">{{$data["urlEmail"]}}</a>
@endcomponent
