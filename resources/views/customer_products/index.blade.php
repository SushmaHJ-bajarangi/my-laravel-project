@extends('layouts.app')

@section('content')
    <section class="content-header">
        <form class="form-inline">
            <div class="form-group col-sm-4">
                {!! Form::label('filter_job_unique_number', 'Filter job unique number:') !!}
                <input type="text" class="form-control" name="job_number" id="job_number" placeholder="Search Job Number" @if(isset($_GET['job_number'])) value="{{$_GET['job_number']}}" @endif>
            </div>
            <br>
        </form>
        <br><br><br>
        <h1 class="pull-left" style="margin-left:0px">Customer Projects</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{{ route('customerProducts.create') }}">Add New</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('customer_products.table')
            </div>
        </div>
        <div class="text-center">

        </div>
    </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

var role = "{{ auth()->user()->role == 1 }} ";
//
    $(function(){
        var showAdminColumns =  role ==3 ? true:false;

        $('#datatable').DataTable({
            serverSide:true,
            processing:true,
            pageLength:25,
//            ajax:urlMasterData,
            columns:[
                { data:'edit' , name: 'edit' ,visible : showAdminColumns},
                { data:'cancel' , name: 'cancel' ,visible : showAdminColumns},
            ],

        })
    })


</script>

@endsection


