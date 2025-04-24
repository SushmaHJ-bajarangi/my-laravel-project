<div class="table-responsive">
    <table class="table" id="example">
        <thead>
            <tr>
                <th>Title</th>
                <th>Name</th>
                <th>Email</th>
                <th>Number</th>
                <th>Zone</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($backupTeams as $backupTeam)
            <tr>
                <td>{{ $backupTeam->title }}</td>
                <td>{{ $backupTeam->name }}</td>
                <td>{{ $backupTeam->email }}</td>
                <td>{{ $backupTeam->contact_number }}</td>
                <td>{{$backupTeam->zonetitle}}</td>
                <td class="text-center">
                    {!! Form::open(['route' => ['backupTeams.destroy', $backupTeam->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('backupTeams.show', [$backupTeam->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('backupTeams.edit', [$backupTeam->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
