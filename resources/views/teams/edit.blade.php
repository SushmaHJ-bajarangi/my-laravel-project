@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Technician Team
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($team, ['route' => ['teams.update', $team->id], 'method' => 'patch','id' => 'team-form']) !!}
                   <input type="hidden" value="{{$team->id}}" id="team_id">
                        @include('teams.fields')
                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection