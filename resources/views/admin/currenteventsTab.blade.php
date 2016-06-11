<div class="tab-pane" id="currentevents">
    <table class="table table-striped">
        <thead>
        <th>Event ID</th>
        <th>Event name</th>
        <th>Event status</th>
        <th>Featured? (MAX = 4 published events)</th>
        </thead>
        <tbody>
        @foreach ($events as $event)
            <form method="post" action="{{ action('PagesController@siteAdminToggleFeatured',$event->slug) }}">
                <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}">
                <tr>
                    <td>{{$event->id}}</td>
                    <td>{{$event->name}}</td>
                    <td>
                        @if ($event->status == "published")
                            <div class="alert-success center">{{$event->status}}</div>
                        @else
                            <div class="alert-danger center">{{$event->status}}</div>
                        @endif
                    </td>
                    @if ($event->featured == 1)
                        <td><button type="submit" name="submit" value="{{$event->slug}}" class="btn btn-success">Featured</button></td>
                    @else
                        <td><button type="submit" name="submit" value="{{$event->slug}}" class="btn btn-warning">Not featured</button></td>
                    @endif
                </tr>
            </form>
        @endforeach
        </tbody>
    </table>
</div>