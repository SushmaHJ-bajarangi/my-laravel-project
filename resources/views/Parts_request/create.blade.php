@extends('layouts.app')
@section('content')

    <section class="content-header">
        <h1 class="pull-left">Request Parts</h1>
    </section>
    <div class="clearfix"></div>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <form method="post" id="create" action="{{url('store')}}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-group col-sm-6">

                            {!! Form::label('unique_job_number', 'Unique Job Number:') !!}
                            <select name="unique_job_number" class="form-control select2" id="unique_job_number">
                                <option selected disabled>Select Customer</option>
                                @if(isset($customers) && count($customers) > 0)
                                    @foreach($customers as $customer)
                                        <option @if(isset($ticket) && $ticket->unique_job_number == $customer->unique_job_number) selected @endif value="{{$customer->unique_job_number}}">{{$customer->unique_job_number}} {{$customer->getCustomer->name}}  _   {{$customer->zone}}</option>                                @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group col-sm-6">
                        {!! Form::label('customer_id', 'Customer') !!}
                            <select name="customer_id" class="form-control select2" id="customer_id">
                                <option selected disabled>Select Customer</option>
                                @if(isset($customers) && count($customers) > 0)
                                    @foreach($customers as $customer)
                                        <option @if(isset($ticket) && $customer->customer_id == $customer->customer_id) selected @endif value="{{$customer->customer_id}}">{{$customer->getCustomer->name}} </option>
                                    @endforeach
                                        @endif

                            </select>


{{--                            {!! Form::text('customer_id', null, ['class' => 'form-control','id'=>'customer_id']) !!}--}}
                        </div>

                        <div class="form-group col-sm-6">
                        {!! Form::label('amt', 'Price') !!}

                            <select name="parts_id" class="form-control select2" id="parts_id">
                                <option selected disabled>Select Customer</option>
                                @if(isset($parts) && count($parts) > 0)
                                    @foreach($parts as $part)
                                        <option @if(isset($ticket) && $ticket->parts_id == $part->parts_id) selected @endif value="{{$part->parts_id}}">{{$part->title}}</option>
                                    @endforeach
                                @endif
                            </select>


{{--                            {!! Form::text('amt', null, ['class' => 'form-control','id'=>'amt']) !!}--}}
                        </div>

                        <div class="form-group col-sm-6">
                        {!! Form::label('ticket_id', 'Ticket') !!}
                            {!! Form::text('ticket_id', null, ['class' => 'form-control','id'=>'ticket_id']) !!}
                        </div>


                        <div class="form-group col-sm-6">
                            {!! Form::label('payment_type', 'Payment Type') !!}
                            {!! Form::text('payment_type', null, ['class' => 'form-control','id'=>'payment_type']) !!}
                        </div>


                        <div class="form-group col-sm-6">
                            <div class="clearfix"></div>

                            {!! Form::label('parts_id', 'Parts') !!}
{{--                            {!! Form::text('parts_id', null, ['class' => 'form-control','id'=>'parts_id']) !!}--}}
                            <select name="parts_id" class="form-control select2" multiple id="parts_id">
                                <option selected disabled>Select Customer</option>
                                @if(isset($parts) && count($parts) > 0)
                                    @foreach($parts as $part)
                                        <option @if(isset($ticket) && $ticket->parts_id == $part->parts_id) selected @endif value="{{$part->parts_id}}">{{$part->title}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="clearfix"></div>

                        <div class="form-group col-sm-6">
                        {!! Form::label('technician_user_id', 'Team') !!}
{{--                            {!! Form::text('technician_user_id', null, ['class' => 'form-control','id'=>'technician_user_id']) !!}--}}
                            <select name="technician_user_id" class="form-control select2"  id="technician_user_id">
                                <option selected disabled>Select Customer</option>
                                @if(isset($teams) && count($teams) > 0)
                                    @foreach($teams as $team)
                                        <option @if(isset($ticket) && $ticket->technician_user_id == $team->technician_user_id) selected @endif value="{{$team->technician_user_id}}">{{$team->title}}_{{$team->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>


                        <div class="form-group col-sm-6">
                        {!! Form::label('final_price', 'Final price') !!}
                            {!! Form::text('final_price', null, ['class' => 'form-control','id'=>'final_price']) !!}
                        </div>

                        <div class="clearfix"></div>

                        <div class="form-group col-sm-6">
                        {!! Form::label('payment_id', 'Payment Id') !!}
                            {!! Form::text('payment_id', null, ['class' => 'form-control','id'=>'payment_id']) !!}
                        </div>
 <div class="form-group col-sm-6">
                        {!! Form::label('payment_method', 'Payment Method') !!}
                            {!! Form::text('payment_method', null, ['class' => 'form-control','id'=>'payment_method']) !!}
                        </div>
 <div class="form-group col-sm-6">
                        {!! Form::label('date', 'Date') !!}
                            {!! Form::text('date', null, ['class' => 'form-control','id'=>'		date']) !!}
                        </div>
 <div class="form-group col-sm-6">
                        {!! Form::label('status', 'Status') !!}
                            {!! Form::text('status', null, ['class' => 'form-control','id'=>'status']) !!}
                        </div>
 <div class="form-group col-sm-6">
                        {!! Form::label('admin_status', 'Admin Status') !!}
                            {!! Form::text('admin_status', null, ['class' => 'form-control','id'=>'	admin_status']) !!}
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