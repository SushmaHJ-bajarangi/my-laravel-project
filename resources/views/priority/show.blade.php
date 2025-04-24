@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Priority
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    <!-- Title Field -->
                    <div class="form-group">
                        {!! Form::label('title', 'Title:') !!}
                        <p>{{ $data->title }}</p>
                    </div>

                    <a href="{{ url('priority') }}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
