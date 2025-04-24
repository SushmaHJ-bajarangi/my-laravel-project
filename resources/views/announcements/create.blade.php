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
                    {!! Form::open(['route' => 'announcements.store','enctype'=>'multipart/form-data','id'=>'announcement','files' => true]) !!}

                        @include('announcements.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
