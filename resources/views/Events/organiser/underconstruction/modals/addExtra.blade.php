<div class="modal fade" id="extrasModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">New Optional Extra</h4>
            </div>
            <form method="post" action="{{ action('ExtrasController@store') }}">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}">
                    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control" name="event_id" value="{{ $event->id }}">
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Extra name:</label>
                        <p class="small">e.g. Presentation dinner, Team competition, aggregate... </p>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label for="cost" class="control-label">Cost of this extra (£)</label>
                        <input type="text" class="form-control" name="cost" default="0.00">
                    </div>
                    <div class="form-group">
                        <label for="multiples" class="control-label">Can the competitor order more than one of these?</label>
                        <p class="small">i.e. should they be able to order multiple dinner tickets/pin badges/team entries/whatevers?</p>
                        <input type="checkbox" class="form-control" name="multiples" value="1">
                    </div>
                    <div class="form-group">
                        <label for="discountable" class="control-label">If you are providing any entry discounts to competitors, should this be discounted too?</label>
                        <input type="checkbox" class="form-control" name="discountable" value="1">
                    </div>
                    <div class="form-group">
                        <label for="infoRequired" class="control-label">Do you need any information from the competitor about this extra?</label>
                        <p class="small">e.g. team name or T-shirt size</p>
                        <input type="checkbox" class="form-control" name="infoRequired" id="infoRequired" value="1">
                    </div>
                    <div class="form-group" id="infoLabelText">
                        <label for="infoRequiredLabel" class="control-label">What label should we put next to the text box for that information?</label>
                        <p class="small">e.g. Team Name:</p>
                        <input type="text" class="form-control" name="infoRequiredLabel">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit" class="btn"><i class="fa fa-save"></i> Save extra</button>
                </div>
            </form>
        </div>
    </div>
</div>
