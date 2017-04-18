<p>Dear {{$athlete->name}},</p>

<h4>{{$event->name}}</h4>

<p>You have succesfully entered the following competitions:</p>

@foreach ($entries as $entry)
    <ul>
        <li>NEED TO FIGURE OUT HOW TO LIST DETAILS HERE @TODO</li>
    </ul>
@endforeach