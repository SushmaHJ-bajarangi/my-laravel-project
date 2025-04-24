@extends('layouts.app')
@section('content')

<section class="content-header">
    <h1>
      Car Bracket
    </h1>
</section>

<div class="content">
    <div class="box box-primary">
        <div class="box-body">
            <div class="row" style="padding-left: 20px">

                <!-- Name Field -->
                <div class="form-group">
                    {!! Form::label('name', 'name:') !!}
                    <p>{{$data->name}}</p>
                </div>

                <a href="{{ url('car_bracket') }}" class="btn btn-default">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection
