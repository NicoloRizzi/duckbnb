@component('mail::message')
# Nuovo appartamento

Hai inserito un nuovo appartamento

{{ $title }}
{{ $description }}

@component('mail::button', ['url' => config('app.url') . '/user' . '/apartments'])
I tuoi appartamenti
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent