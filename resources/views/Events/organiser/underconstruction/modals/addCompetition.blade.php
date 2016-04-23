<div class="modal fade" id="addCompetitionModal" tabindex="-1" role="dialog" aria-labelledby="AddCompetitionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ action('CompetitionController@store') }}">
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
                        <label for="name" class="control-label">Competition name:</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="form group">
                        <label for="description" class="control-label">Short description</label>
                        <input type="text" name="description" class="form-control">
                    </div>
                    <div class="form group">
                        <label for="fee" class="control-label">Entry fee (£)</label>
                        <input type="text" name="fee" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit" class="btn"><i class="fa fa-save"></i> Save competition</button>
                </div>
            </form>
        </div>
    </div>
</div>