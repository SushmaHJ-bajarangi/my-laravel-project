@extends('layouts.app')
@section('content')
<section class="content-header">
    <h1 class="pull-left">Raise Ticket</h1>
</section>
<div class="clearfix"></div>
<div class="content">
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <form method="post" action="{{url('updateTicket/'.$id)}}">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" name="id" value="{{$id}}">
{{--                    <div class="form-group col-sm-6">--}}
{{--                        {!! Form::label('customer_id', 'Customer:') !!}--}}
{{--                        <input type="text" name="customer_id" value="{{$customer->name}}" class="form-control">--}}
{{--                    </div>--}}
                    <div class="form-group col-sm-6">
                        {!! Form::label('unique_job_number', 'Unique Job Number:') !!}
                        <select name="unique_job_number" class="form-control select2" id="unique_job_number">>
                            <option selected disabled>Select Customer</option>
                            @if(isset($customer_products) && count($customer_products) > 0)
                                @foreach($customer_products as $customer)
                                    <option @if(isset($ticket) && $ticket->unique_job_number == $customer->unique_job_number) selected @endif value="{{$customer->unique_job_number}}">{{$customer->unique_job_number}} {{$customer->project_name}}  _   {{$customer->zone}} - {{$customer->getCustomer->contact_number}}</option>                                @endforeach
                            @endif
                        </select>
                    </div>
                    {{--<div class="form-group col-sm-6">--}}
                        {{--{!! Form::label('product_id', 'Customer Product:') !!}--}}
                        {{--<input type="text" name="product_id" value="{{$customer_products}}" class="form-control">--}}
                    {{--</div>--}}
                    <div class="form-group col-sm-6">
                        {!! Form::label('title', 'Title:') !!}
{{--                        <input name="title" type="text" value="{{$ticket->title}}" class="form-control">--}}
                        <select name="title" class="form-control select2" id="title">
                            <option selected disabled>Select Title</option>
                            @if(isset($problems) && count($problems) > 0)
                                @foreach($problems as $problem)
                                    <option @if(isset($ticket) && $ticket->title == $problem->title) selected @endif value="{{$problem->title}}">{{$problem->title}}</option>                                @endforeach
                            @endif
                        </select>
                    </div>
{{--                    <div class="form-group col-sm-6">--}}
{{--                        {!! Form::label('unique_job_number', 'Unique Job Number:') !!}--}}
{{--                        <input name="unique_job_number" type="text" value="{{$ticket->unique_job_number}}" class="form-control">--}}
{{--                    </div>--}}
                    <div class="form-group col-sm-12">
                        {!! Form::label('description', 'Description:') !!}
                        <textarea name="description" class="form-control" rows="5">{{$ticket->description}}</textarea>
                    </div>
                    <div class="form-group col-sm-6">
                        {!! Form::label('date', 'Date:') !!}
                        <input type="date" name="progress_date" value="{{$ticket->progress_date}}" class="form-control" required>
                    </div>
                    <div class="form-group col-sm-6">
                        {!! Form::label('assigned_to', 'Assign To:') !!}
                        <select name="assigned_to" class="form-control select2" required>
                            <option selected disabled>Select Team Leader</option>
                            @if(isset($teams) && count($teams) > 0)
                                @foreach($teams as $team)
                                    <option @if(isset($ticket) && $ticket->assigned_to == $team->id) selected @endif value="{{$team->id}}">{{$team->title}}_{{$team->name}}_{{$team->zone}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Priority Status (Is Urgent) :</label>
                        <div class="clearfix"></div>
                        <label class="radio-inline">
                            <input type="radio" @if(isset($ticket) && $ticket->is_urgent == 'yes') checked @endif name="is_urgent" value="yes">Yes
                        </label>
                        <label class="radio-inline">
                            <input type="radio" @if(isset($ticket) && $ticket->is_urgent == 'no') checked @endif name="is_urgent"  value="no">No
                        </label>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Selected Image :</label>
                        <div class="clearfix"></div>
                        @if(!empty($ticket->image))
                        <img class="raise_ticket_image" src="{{asset('/images/products/'.$ticket->image)}}">
                        @else
                        <img class="raise_ticket_image" src="{{asset('/images/no_img.png')}}">
                        @endif
                    </div>
                    <div class="form-group col-sm-12">
                        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                        <a href="{{ url('tickets') }}" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            $('.select2').select2();
        });
    </script>
@endsection
