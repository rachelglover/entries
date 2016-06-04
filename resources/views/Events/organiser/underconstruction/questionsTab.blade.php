<div class="tab-pane {{ !empty($tabName) && $tabName == 'questions' ? 'active' : '' }}" id="questions">
    <div class="modal fade" id="questionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">New question</h4>
                </div>
                {!! Form::open(array( 'action' => 'QuestionController@store')) !!}
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}">
                        </div>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="event" value="{{ $event->id }}">
                        </div>
                        <div class="form-group">
                            <label for="question" class="control-label">Question:</label>
                            <small>Type it as you would like it to be seen on the entry form</small>
                            <input type="text" class="form-control" name="question">
                        </div>
                        <div class="form-group">
                            <label for="answerType" class="control-label">Answer type:</label>
                            <select class="form-control" name="answerType" id="answerType">
                                <option value="text">Text</option>
                                <option value="list">Drop-down list</option>
                                <option value="boolean">Yes/No</option>
                                <option value="number">Number</option>
                                <option value="date">Date</option>
                            </select>
                        </div>
                        <div class="form-group" id="listItemsDiv">
                            <label for="listItems" class="control-label">Items for your drop-down list</label>
                            <input type="text" class="form-control" name="listItems">
                            <p class="small">Separate list items with a comma e.g. A Class, B Class, C Class</p>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="submit" class="btn"><i class="fa fa-save"></i> Save question</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            <h3>Questions for your competitors</h3>
            <h5>You will automatically receive the following from all competitors:
            <ul>
                <li>Email address</li>
                <li>Telephone number</li>
                <li>Shooting club</li>
                <li>Home Country eligibility (ENG, SCO etc)</li>
            </ul></h5>
            <p>Do you need extra information like membership number, date of birth or national classification? Add your questions here and they will appear on the entry form.</p>
            <button type="button" class="btn" data-toggle="modal" data-target="#questionModal" id="questionModalButton">Add a question to your entry form</button>
            <p></p>
            @if ($event->questions()->get()->count() > 0)
            <table class="table table-striped table-bordered">
                <thead>
                    <th>Question</th>
                    <th class="text-center">Answer type</th>
                    <th class="text-center">Delete</th>
                </thead>
                <tbody>
                @foreach ($event->questions()->get() as $question)
                    <tr>
                        <td>{{ $question->question }}</td>
                        <td class="text-center">
                            <!-- answer type formatting -->
                            @if ($question->answerType == 'boolean')
                                Yes/No
                            @elseif ($question->answerType == 'list')
                                Drop-down list<br>
                                ({{ $question->listItems }})
                            @elseif ($question->answerType == 'date')
                                Date
                            @elseif ($question->answerType == 'text')
                                Text
                            @elseif ($question->answerType == 'number')
                                Number
                            @endif
                        </td>
                        <td class="text-center">
                            <form method="post" action="{{ action('QuestionController@destroy', $question->id) }}">
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