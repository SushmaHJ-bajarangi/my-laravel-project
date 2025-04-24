@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Announcement
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($announcement, ['route' => ['announcements.update', $announcement->id], 'method' => 'patch','id'=>'announcement','enctype'=>'multipart/form-data','files' => true]) !!}

                        @include('announcements.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection