<p>Dear {{$athlete->firstname}},</p>

<h4>{{$event->name}}</h4>

<p>Your entries for this event have been withdrawn.</p>

<p>We aim to process all refunds within 48 hours and will send confirmation as soon as it has been completed.</p>

<p>You can still manage your entries from <a href="{{ action('PagesController@userEntries') }}">your account</a>.</p>

<p>Many thanks,<br>
    The Foresight Entries Team</p>