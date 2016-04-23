<div class="tab-pane {{ !empty($tabName) && $tabName == 'competitions' ? 'active' : '' }}" id="competitions">
    <div class="row">
        <div class="col-lg-12">
            <h3>Add competitions and details</h3>
            <button type="button" class="btn" data-toggle="modal" data-target="#addCompetitionModal" id="competitionModalButton">Add a competition to your event</button><br>
            <p></p>
            <!-- Foreach competition -->
            @foreach ($competitions->reverse() as $competition)

            @include('Events.organiser.underconstruction.modals.editCompetition')
                <div class="panel-group accordion" id="competitions">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#competitions" href="#collapse{{$competition->id}}"><i class="fa fa-trophy"></i> {{$competition->name}} <small class="pull-right">click to show/hide</small></a>
                            </h4>
                        </div>
                        <div id="collapse{{$competition->id}}" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <div class="row">
                                    <!-- Competition description -->
                                    <div style="padding:15px">{{$competition->description}}</div>

                                    <!-- options table -->
                                    <table class="table table-condensed">
                                        <tr>
                                            <td width="33%" class="text-center"><button type="button" class="btn btn-sm btn-template-main" data-toggle="modal" data-target="#editCompetitionModal-{{$competition->id}}" data-comp="{{$competition->id}}"><i class="fa fa-pencil"></i> Edit competition</button></td>
                                            <td width="33%" class="text-center">
                                                <form method="post" action="{{ action('CompetitionController@destroy',$competition->id) }}">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="event" value="{{ $event->id }}">
                                                    <button type="submit" name="submit" class="btn btn-template-main btn-sm"><i class="fa fa-trash-o"></i> Delete competition</button>
                                                </form>

                                            </td>
                                            <td width="33%" class="text-center">
                                                <button type="button" class="btn btn-template-main btn-sm" data-toggle="modal" data-target="#detailModal" data-comp="{{ $competition->id }}"><i class="fa fa-plus"></i> Add a detail</button>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- Information table -->
                                    <table class="table table-condensed table-striped">
                                        <tr>
                                            <td class="pull-right">
                                                <i class="fa fa-money"></i> <b>Fee:</b>
                                            </td>
                                            <td>£{{ $competition->fee }}</td>
                                        </tr>
                                        <tr>
                                            <td class="pull-right">
                                                <i class="fa fa-chevron-circle-right"></i> <b>Details:</b><br>
                                            </td>
                                            <td>
                                                <!-- Only display the details table if there are details to display -->
                                                @if ($competition->details()->get()->count())
                                                        <!-- details table -->
                                                <table class="table table-condensed">
                                                    <thead>
                                                    <th style="padding-right: 5px;">Detail name</th>
                                                    <th width="25%" class="text-center" style="padding-right: 5px;">Max. competitors</th>
                                                    <th width="25%" style="padding-right: 5px;">Date and time</th>
                                                    <th width="10%" class="text-center">Delete</th>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($competition->details()->get() as $detail)
                                                        <tr>
                                                            <td>{{ $detail->name }}</td>
                                                            <td class="text-center">{{ $detail->max }}</td>
                                                            <td>{{ $detail->dateTime }}</td>
                                                            <td class="text-center"><form method="post" action="{{ action('DetailController@destroy',$detail->id) }}">
                                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                    <input type="hidden" name="event" value="{{ $event->id }}">
                                                                    <button type="submit" name="submit" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o"></i></button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table> <!-- end details table -->
                                                @else
                                                    <p class="text-danger bold">Each competition must have at least one detail. Please add one using the button above.</p>
                                                @endif
                                            </td>
                                        </tr>
                                    </table> <!-- end information table -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>