@extends('layouts.app')
@section('content')
    <section class="content-header">
        <h1 class="pull-left">Edit User</h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <form method="POST" action="{{url('update/note',$edit_note->id)}}" enctype="multipart/form-data">
                    @csrf
                    <div class="col-sm-6">
                        <label>Service Id</label>
                        <input type="text" name="service_id" value="{{$edit_note->service_id}}" class="form-control">
                    </div>

                    <div class="col-sm-6">
                        <label>Description</label>
                        <input type="text" name="description" value="{{$edit_note->description}}" class="form-control">
                    </div>
                    <div class="form-group col-sm-12">
                        <br>
                        <br>
                        <button type="submit" class="btn btn-primary">save</button>
                        <a href="{{ url('customer/note') }}" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection