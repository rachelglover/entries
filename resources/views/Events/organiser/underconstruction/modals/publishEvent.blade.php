<div class="modal fade" id="publishModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Publish your event to the site</h4>
            </div>
            <div class="modal-body">
                <h4>Are you sure you're ready to accept entries for this event?</h4>
                <p>Once your event is on the site you will no longer be able to edit your competitions, their details or any questions you want on the entry form. If you're happy to proceed please click below.</p>
            </div>
            <form method="post" action="{{ action('PagesController@publish', $event->slug) }}">
                <div class="modal-footer">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit" class="btn btn-success"><i class="fa fa-save"></i> Publish</button>
                </div>
            </form>
        </div>
    </div>
</div>
