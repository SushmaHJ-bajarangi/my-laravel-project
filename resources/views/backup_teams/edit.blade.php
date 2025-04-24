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
                   {!! Form::model($backupTeam, ['route' => ['backupTeams.update', $backupTeam->id], 'method' => 'patch','id' => 'team-form']) !!}
                   <input type="hidden" value="{{$backupTeam->id}}" id="team_id">
                        @include('backup_teams.fields')
                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection