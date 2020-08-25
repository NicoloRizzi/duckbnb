@component('mail::message')
# Il tuo appartamento è stato modificato

Hai modificato il tuo appartamento con successo con successo

{{ $title }}

@component('mail::button', ['url' => config('app.url') . '/user' . '/apartments'])
I tuoi appartamenti
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent