<div class="tab-pane {{ !empty($tabName) && $tabName == 'discounts' ? 'active' : '' }}" id="discounts">
    <div class="modal fade" id="discountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">New discount</h4>
                </div>
                {!! Form::open(array( 'action' => 'DiscountController@store')) !!}
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}">
                        </div>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="event" value="{{ $event->id }}">
                        </div>
                        <div class="form-group">
                            <label for="for" class="control-label">Who's the discount for?</label><small> e.g. Juniors, Students, Members</small>
                            <input type="text" class="form-control" name="for">
                        </div>
                        <div class="form-group">
                            <label for="info" class="control-label">Any associated info?</label> <small> e.g. Juniors must be under 21; Students must show a valid student ID on the day</small>
                            <input type="text" class="form-control" name="info">
                        </div>
                        <div class="form-group">
                            <label for="type" class="control-label">What type of discount is this?</label>
                            <select class="form-control" name="type" id="type">
                                <option value="fixed">Fixed amount</option>
                                <option value="percentage">Percentage</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="value" class="control-label">Value (£ or %)</label>
                            <input type="text" class="form-control" name="value" id="value">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="submit" class="btn"><i class="fa fa-save"></i> Save discount</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            <h3>Discounts for your competitors</h3>
            <p>Do you want to offer discounts to your event for certain competitors? Add your discounts here and they will appear on the entry form.</p>
            <button type="button" class="btn" data-toggle="modal" data-target="#discountModal" id="discountModalButton">Add a discount to your event</button>
            <p></p>
            @if ($event->discounts()->get()->count() > 0)
            <table class="table table-striped table-bordered">
                <thead>
                    <th class="text-center">Discount for</th>
                    <th class="text-center">Type</th>
                    <th class="text-center">Value (£ or %)</th>
                    <th class="text-center">Options</th>
                </thead>
                <tbody>
                @foreach ($event->discounts()->get() as $discount)
                    <tr>
                        <td class="text-center">
                            {{ $discount->for }}<br />
                            {{ $discount->info }}
                        </td>
                        <td class="text-center">{{ $discount->type }}</td>
                        @if ($discount->type == "fixed")
                            <td class="text-center">£{{ $discount->value }}</td>
                        @else ($question->type == "percentage")
                            <td class="text-center">{{ $discount->value }}%</td>
                        @endif
                        <td class="text-center">
                            <form method="post" action="{{ action('DiscountController@destroy', $discount->id) }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="event" value="{{ $event->id }}">
                                <button type="submit" name="submit" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </body>
            </table>
            @endif
        </div>
    </div>
</div>