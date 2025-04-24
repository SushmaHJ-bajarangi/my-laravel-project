@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Priority
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <form action="{{url('priority/store')}}" method="post" >
                        @csrf
                    <div class="form-group col-sm-6">
                        <label>Title:</label>
                        <input type="text" name="title" class="form-control" id="title" required>
                    </div>
                    <div class="form-group col-sm-12">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ url('priority') }}" class="btn btn-default">Cancel</a>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
