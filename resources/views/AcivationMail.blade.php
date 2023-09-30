@component('mail::message')

<center>Geachte {{ $rol }},<br> klik hieronder om je account te bevestigen.</center>

@component('mail::button', ['url' => $url])
Klik hier
@endcomponent
@endcomponent
