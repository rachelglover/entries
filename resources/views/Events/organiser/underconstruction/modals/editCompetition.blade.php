<div class="modal fade" id="editCompetitionModal-{{$competition->id}}" tabindex="-1" role="dialog" aria-labelledby="EditCompetitionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::model($competition, ['method' => 'PATCH', 'action' => ['CompetitionController@update', $competition->id]]) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="AddCompetitionModalLabel">Add a competition to your event</h4>
                </div>
                <div class="modal-body">
                    <div class="form group">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" class="form-control">
                    </div>
                    <div class="form group">
                        <input type="hidden" name="event" value="{{ $event->id }}" class="form-control">
                    </div>
                    <div class="form group">
                        {!! Form::label('name', 'Competition name:') !!}
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form group">
                        {!! Form::label('description', 'Short description:') !!}
                        {!! Form::text('description', null, ['class' => 'form-control', 'id' => 'shortdescription']) !!}
                    </div>
                    <div class="form group">
                        {!! Form::label('fee', 'Entry fee (£):') !!}
                        {!! Form::text('fee', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit" class="btn"><i class="fa fa-save"></i> Save competition</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>