@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            No Of Floors
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'noOfFloors.store','id'=>'no_of_floors']) !!}

                        @include('no_of_floors.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
