@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Manufacture Stages
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

                    <a href="{{ url('manufacture_stages') }}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
