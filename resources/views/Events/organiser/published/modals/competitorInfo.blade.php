<!--<div class="modal fade" id="viewEntryCompetitorInfoModal" tabindex="-1" role="dialog" aria-labelledby="viewEntryCompetitorInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="AddCompetitionModalLabel"></h4>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                        <th>Entry</th>
                        <th>Detail</th>
                    </thead>
                    <tbody>
                        <tr><td>asdf</td><td>asdf</td></tr>
                    </tbody>
                </table>
                <div>
                All the information about the competitor and their entries here. 
                Would like to see:
                * Answers to questions on the entry form
                * Any additional extras ordered
                * All competition entries and the details assigned
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>-->
<div class="modal fade" id="viewEntryCompetitorInfoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
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
            <div class="modal-footer">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" name="submit" class="btn btn-success"><i class="fa fa-save"></i> Publish</button>
            </div>
        </div>
    </div>
</div>