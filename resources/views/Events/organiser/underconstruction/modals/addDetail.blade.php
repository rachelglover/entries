<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">New detail</h4>
            </div>
            <form method="post" action="{{ action('DetailController@store') }}">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}">
                    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control" name="event" value="{{ $event->id }}">
                    </div>
                    <div class="comp form-group">
                        <input type="hidden" class="form-control" name="competition">
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Detail name:</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label for="max" class="control-label">Maximum competitors:</label>
                        <input type="text" class="form-control" name="max">
                    </div>
                    <div class="form-group">
                        <label for="dateTime" class="control-label">Date and time:</label>
                        <input type="text" class="form-control" name="dateTime" id="dateTime">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit" class="btn"><i class="fa fa-save"></i> Save detail</button>
                </div>
            </form>
        </div>
    </div>
</div>
