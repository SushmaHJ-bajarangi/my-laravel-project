@extends('layouts.app')
@section('content')
    <section class="content-header">
        <h1 class="pull-left">Parts Request</h1>
    </section>
    <div class="clearfix"></div>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <form method="post" action="{{url('update')}}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-group col-sm-6">
                            {!! Form::label('unique_job_number', 'Unique job number:') !!}
                            <p>{{$parts_request->unique_job_number}}</p>
                            {{--<input type="text" name="unique_job_number" value="{{$parts_request->unique_job_number}}" class="form-control" required>--}}
                        </div>
                        <div class="form-group col-sm-6">
                            {!! Form::label('customer', 'Customer:') !!}
                            <p>{{ $parts_request->getCustomer->name }}</p>
                        </div>
                        <div class="form-group col-sm-6">
                            {!! Form::label('price', 'Price:') !!}
                            <p>{{ $parts_request->final_price }}</p>
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('team', 'Team:') !!}
                            <p>{{ $parts_request->getTeam->name }}</p>
                        </div>
                        <div class="form-group col-sm-6">
                            {!! Form::label('final_price', 'Final Price:') !!}
                            <p>{{ $parts_request->final_price }}</p>
                        </div>
                        <div class="form-group col-sm-6">
                            {!! Form::label('payment_method', 'Payment Method:') !!}
                            <p>{{ $parts_request->payment_method }}</p>
                        </div>
                        <div class="form-group col-sm-6">
                            {!! Form::label('payment_id', 'Payment Id:') !!}
                            <p>{{ $parts_request->payment_id }}</p>
                        </div>
                        <div class="form-group col-sm-6">
                            {!! Form::label('rasied_ticket', 'Raised Ticket:') !!}
                            <p>{{ $ticket->title }}</p>
                        </div>
                        <div class="form-group col-sm-6">
                            {!! Form::label('payment_type', 'Payment Type:') !!}
                            <p>{{ $parts_request->payment_type }}</p>
                        </div>
                        <div class="form-group col-sm-6">
                            {!! Form::label('date', 'Date:') !!}
                            <p>{{ $parts_request->date }}</p>
                        </div>
                        <div class="form-group col-sm-6">
                            {!! Form::label('status', 'Status:') !!}
                            <p>{{ $parts_request->status }}</p>
                        </div>
                        <div class="form-group col-sm-6">
                            {!! Form::label('payment_date', 'Payment Date:') !!}
                            <p>{{ $parts_request->payment_date }}</p>
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('parts_id', 'Parts Id:') !!}
                            @php
                                $data=explode(',',$parts_request->parts_id);
                                foreach($data as $key=>$item){
                                   $subcategory = App\Models\parts::where('id',$item)->first();

                                    if( count( $data ) != $key + 1 ){
                                    echo $subcategory->title.',';
                                    }
                                    else{
                                    echo $subcategory->title;
                                    }
                                }
                            @endphp
                        </div>
                        <div class="form-group col-sm-12">
                            <a href="{{ url('Request') }}" class="btn btn-default">Cancel</a>
                        </div>

        </form>
    </div>
    </div>
    </div>
    </div>


@endsection