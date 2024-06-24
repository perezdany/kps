@component('mail::message')
# A ne pas répondre!
	
Merci de ne pas répondre à ce mail.

Bonjour cher client, Votre réservation du  <b>{{$data['date_reserv']}}</b> sur l'appartement <b>{{$data['appart']}}</b> a été validée.
<br>Elle ne sera plus affichée dans les réservations en cours:


Cordialement,<br>
{{ config('app.name') }}
@endcomponent
