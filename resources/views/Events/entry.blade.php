@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h3>Entry form: {{$event->name}}</h3>
        <form method="post" action="{{ action('EntryController@confirmEntry') }}">
        <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}">
        <!-- User information that we already have on file from the profile -->
        <div class="panel panel-primary">
            <div class="panel-heading">Update your details</div>
            <div class="panel-body">
                <p>Here are the details currently associated with your profile that the event organiser will be able to access. If you need to modify any info you can do it here, or change it on your profile later.</p>
                <table class="table table-striped table-bordered">
                    <tr>
                        <td class="bold">Name</td>
                        <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                    </tr>
                    <tr>
                        <td class="bold">Email</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td class="bold">Phone number</td>
                        <td><input name="user-phone" type="text" value="{{ $user->phone }}" class="form-control"></td>
                    </tr>
                    <tr>
                        <td class="bold">Club</td>
                        <td><input name="user-club" type="text" value="{{ $user->club }}" class="form-control"></td>
                    </tr>
                    <tr>
                        <td class="bold">Home Country</td>
                        <td><input name="user-country" type="text" value="{{ $user->homeCountry }}" class="form-control">
                        </td>
                    </tr>
                </table>

            </div>
        </div>

        <!-- Custom questions that the organiser wants the user answer -->
        @if ($event->questions()->get())
        <div class="panel panel-primary">
            <div class="panel-heading">Answer questions</div>
            <div class="panel-body">
                <p>The organiser would also like you to answer the following questions:</p>
                <table class="table table-bordered table-striped">
                    @foreach ($event->questions()->get() as $question)
                        <tr>
                            <td>{{ $question->question }}</td>
                            <td>
                                @if ($question->answerType == "text")
                                    <input type="text" name="questions[{{$question->id}}]" class="form-control">
                                @endif
                                @if ($question->answerType == "number")
                                    <input type="text" name="questions[{{$question->id}}]" class="form-control">
                                @endif
                                @if ($question->answerType == "boolean")
                                    <select name="questions[{{$question->id}}]" class="form-control">
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                @endif
                                @if ($question->answerType == "date")
                                    <input type="date" id="questionDate" name="questions[{{$question->id}}]" class="form-control datetime">
                                @endif
                                @if ($question->answerType == "list")
                                    <select name="questions[{{$question->id}}]" class="form-control">
                                        @foreach (explode(',', $question->listItems) as $listItem)
                                            <option value="{{$listItem}}">{{$listItem}}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        @endif

        <!-- Competitions and details -->
        <!-- the if shouldn't be necessary but until I get the publish checks in place
        then it has to stay -->
        @if ($event->competitions()->get())
        <div class="panel panel-primary">
            <div class="panel-heading">Enter competitions</div>
            <div class="panel-body">
                <p>Please select the competitions you wish to enter.</p>
                <table class="table table-bordered table-striped">
                    <thead>
                    <th width="25%">Competition</th>
                    <th width="25%">Description</th>
                    <th width="15%">Entry fee</th>
                    <th width="35%">Enter</th>
                    </thead>

                    <tbody>
                    @foreach ($event->competitions()->get() as $competition)
                        <tr>
                            <td>
                                {{ $competition->name }}
                            </td>
                            <td>
                                {{ $competition->description }}
                            </td>
                            <td>
                                £{{ $competition->fee }}
                            </td>
                            <td>
                                <table>
                                    
                                    <select name="competitions[{{$competition->id}}]" class="form-control input-sm">
                                        <option value="noEntry">Select a detail to enter...</option>
                                        @foreach ($competition->details()->get() as $detail)
                                                <!-- work out places left -->
                                        <!-- $left = $detail->max - $entries->details($detail->id) -->
                                        <!-- not elegant but required to do the calculation -->
                                        <?php $left = $detail->max - rand(0, $detail->max); ?>

                                        @if ($left > 1)
                                                <option value="{{$detail->id}}">{{$detail->name}} | {{$detail->dateTime->toDayDateTimeString()}} | {{$left}} places left</option>
                                        @endif
                                        @if ($left == 1)
                                                <option value="{{$detail->id}}">{{$detail->name}} | {{$detail->dateTime->toDayDateTimeString()}} | {{$left}} place left</option>
                                    @endif
                                        @if ($left == 0)
                                                <option value="{{$detail->id}}" disabled>{{$detail->name}} | {{$detail->dateTime->toDayDateTimeString()}} | FULL</option>
                                    @endif

                                                </tr>
                                            @endforeach
                                    </select>
                                </table>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Optional extras that can be ordered and paid for -->
        @if ($event->extras()->get())
        <div class="panel panel-primary">
            <div class="panel-heading">Get optional extras</div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <th width="25%">Extra</th>
                    <th width="25%">Cost</th>
                    <th width="50%">Order</th>
                    </thead>
                    <tbody>
                    @foreach ($event->extras()->get() as $extra)
                        <tr>
                            <td>
                                {{$extra->name}}
                            </td>
                            <td>
                                £{{$extra->cost}}
                            </td>
                            <td>
                                Order: <input type="checkbox" name="extras[{{$extra->id}}]" id="extra-checkbox" value="{{$extra->cost}}">
                                <div id="extra-div">
                                    @if ($extra->multiples == "1")
                                        <br>How many? <input type="text" name="extras[{{$extra->id}}][multiple]" class="form-control" value="1">
                                    @endif
                                    @if ($extra->infoRequired == "1")
                                        {{$extra->infoRequiredLabel}}<input type="text" name="extras[{{$extra->id}}][infoRequired]" class="form-control">
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

       
        <input type="hidden" name="event_id" value="{{$event->id}}">

        <!-- submit form -->
        <button type="submit" value="Enter" class="btn btn-success pull-right"><i class="fa fa-dot-circle-o"></i> Confirm and Pay</button>
        </form>

    </div>
</div>
@endsection