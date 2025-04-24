@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Customer Problems
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('problems.show_fields')
                    <a href="{{ route('problems.index') }}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
