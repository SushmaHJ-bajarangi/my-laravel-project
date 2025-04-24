@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1>
        Car Door Opening
    </h1>
</section>

<div class="content">
    @include('adminlte-templates::common.errors')
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                    @csrf

                    <div class="form-group col-sm-6">
                        <label>Name:</label>
                        <p>{{$data->name}}</p>
                    </div>

                    <div class="form-group col-sm-12">
                        <a href="{{ url('car_door_opening') }}" class="btn btn-default">Cancel</a>
                    </div>

            </div>
        </div>
    </div>
</div>


@endsection