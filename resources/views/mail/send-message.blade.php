@component('mail::message')
# Nuovo messaggio da 
{{ $data['email'] }}

<br>
Messaggio:

{{ $data['message'] }}


@component('mail::button', ['url' => config('app.url') . '/user' . '/apartments'])
I tuoi appartamenti
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent