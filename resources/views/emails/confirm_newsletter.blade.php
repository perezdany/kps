@component('mail::message')
# A ne pas répondre!
	
Merci de ne pas répondre à ce mail.

Bonjour! Vous venez de vous abonner à notre liste de diffusion. Vous pouvez si vous le souhaitez vous désabonner en <b>cliquant sur le bouton suivant ou le faire à la reception d'une publication:<b>

@component('mail::button', ['url' => $data['url'], 'color' => 'primary'])
Se désabonner
@endcomponent

Cordialement,<br>
{{ config('app.name') }}
@endcomponent