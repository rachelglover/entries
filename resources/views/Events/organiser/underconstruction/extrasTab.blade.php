<div class="tab-pane {{ !empty($tabName) && $tabName == 'extras' ? 'active' : '' }}" id="extras">
    <div class="row">
        <div class="col-lg-12">
            <h3>Optional extras</h3>
            <p>Adding optional dinner tickets, accommodation, merchandise or anything else you can think of to your event is really simple and they'll appear on the entry form. </p>
            <button type="button" class="btn" data-toggle="modal" data-target="#extrasModal" id="extrasModalButton">Add an extra to your entry form</button>
            <p></p>
            @if ($event->extras()->get()->count() > 0)
                <table class="table table-striped table-bordered">
                    <thead>
                    <th>Extra</th>
                    <th class="text-center">Cost</th>
                    <th class="text-center">Delete</th>
                    </thead>
                    <tbody>
                    @foreach ($event->extras()->get() as $extra)
                        <tr>
                            <td>{{ $extra->name }}
                                <ul>
                            @if ($extra->multiples == "1")
                                    <li>Competitors can order more than one</li>
                            @endif
                            @if ($extra->infoRequired == "1")
                                    <li>You require information from competitors for this extra ("{{$extra->infoRequiredLabel}}")</li>
                            @endif
                                </ul>
                            </td>
                            <td class="text-center">
                                £{{$extra->cost}}
                            </td>
                            <td class="text-center">
                                <form method="post" action="{{ action('ExtrasController@destroy', $extra->id) }}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="event" value="{{ $event->id }}">
                                    <button type="submit" name="submit" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>