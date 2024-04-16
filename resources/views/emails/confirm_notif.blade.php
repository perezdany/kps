@component('mail::message')
# A ne pas répondre!
	
Merci de ne pas répondre à ce mail.

Bonjour cher client, pour valider votre inscription, veuillez cliquer sur le bouton suivant:

@component('mail::button', ['url' => $data['url'], 'color' => 'primary'])
Valider
@endcomponent

Cordialement,<br>
{{ config('app.name') }}
@endcomponent
