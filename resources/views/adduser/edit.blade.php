@extends('layouts.app')
@section('content')
<section class="content-header">
    <h1 class="pull-left">Edit User</h1>
</section>

<div class="content">
    <div class="clearfix"></div>
    <div class="box box-primary">
        <div class="box-body">
            <form method="POST" action="{{url('update/user',$edit_user->id)}}" enctype="multipart/form-data">
                @csrf
                <div class="col-sm-6">
                    <label>Name</label>
                    <input type="text" name="name" value="{{$edit_user->name}}" class="form-control">
                </div>

                <div class="col-sm-6">
                    <label>Email</label>
                    <input type="email" name="email" value="{{$edit_user->email}}" class="form-control">
                </div>
                <div class="col-sm-6">
                    <label>Password</label>
                    <input type="number" name="password"  value="{{$edit_user->password}}"   class="form-control">
                </div>
                <div class="col-sm-6">
                    <label>Add Role</label>
                    <select class="form-control" name="role">
                        <option value="0">User</option>
                    </select>
                </div>

                <div class="form-group col-sm-12">
                    <br>
                    <br>
                    <button type="submit" class="btn btn-primary">save</button>
                    <a href="{{ url('listUser') }}" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection