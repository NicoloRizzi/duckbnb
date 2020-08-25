@component('mail::message')
# Appartamento eliminato

Hai eliminato il tuo appartamento con successo

{{ $title }}

@component('mail::button', ['url' => config('app.url') . '/user' . '/apartments'])
I tuoi appartamenti
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent