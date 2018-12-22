<table class="table table-responsive" id="jobs-table">
    <thead>
        <tr>
            <th>Title</th>
        <th>Description</th>
        <th>Created By</th>
        <th>Modified By</th>
        <th>Is Active</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($jobs as $job)
        <tr>
            <td>{!! $job->title !!}</td>
            <td>{!! $job->description !!}</td>
            <td>{!! $job->created_by !!}</td>
            <td>{!! $job->modified_by !!}</td>
            <td>{!! $job->is_active !!}</td>
            <td>
                {!! Form::open(['route' => ['jobs.destroy', $job->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('jobs.show', [$job->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('jobs.edit', [$job->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>