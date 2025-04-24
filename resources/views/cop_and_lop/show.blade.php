@extends('layouts.app')
@section('content')

    <section class="content-header">
        <h1>
            COP And LOP
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
                           {{$data->name}}
                        </div>
                        <div class="form-group col-sm-12">
                            <a href="{{ url('cop_and_lop') }}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
