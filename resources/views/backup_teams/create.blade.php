@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Service Team
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'backupTeams.store','id' => 'team-form']) !!}
                    <input type="hidden" value="" id="team_id">
                        @include('backup_teams.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
