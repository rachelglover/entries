<p>Dear {{$athlete->firstname}},</p>

<h4>{{$event->name}}</h4>

<p>You have succesfully entered the following competitions:</p>

<ul>
@foreach ($entries as $entry)
    <li>{{ $competitions[$entry->id]->name }} ({{$competitions[$entry->id]->description}})</li>
@endforeach
</ul>

<p>You can manage your entries from <a href="{{ action('PagesController@userEntries') }}">your account</a>, including cancellations and refunds.</p>

<p>Many thanks,<br>
    The Foresight Entries Team</p>