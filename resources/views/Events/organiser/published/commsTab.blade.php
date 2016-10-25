<div class="tab-pane" id="communications">
    <p>You can send an email to all of your competitors below and your competitors will be able to reply to your email address directly. This allows your entrants to reply to you directly. Alternatively, all the email addresses for your competitors are in the main Excel download on the Overview tab. </p>
    <form method="post" action="{{ action('EventsController@sendMassEmail', $event->slug) }}">
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
                <label for="from" class="control-label">Email from:</label>
                <input type="text" class="form-control" name="from" value="{{ $event->getOrganiserEmail($event->id) }}" disabled>
            </div>
            <div class="form-group">
                <label for="to" class="control-label">To: ALL COMPETITORS</label>
            </div>
            <div class="form-group">
                {!! Form::label('Your message:') !!}
                {!! Form::textarea('message', null,
                    array('required',
                        'class' => 'form-control',
                        'placeholder' => 'Type here'
                    )) !!}
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" name="submit" class="btn"><i class="fa fa-save"></i> Send email</button>
        </div>
    </form>
</div>