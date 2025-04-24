@extends('layouts.app')
@section('content')
    <section class="content-header">
        <h1 class="pull-left">Raise Ticket</h1>
    </section>
<br>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <form method="post" id="createTicket" action="{{url('storeTicket')}}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="id" value="" id="ticket_id">
                        <div class="form-group col-sm-6">
                            {!! Form::label('unique_job_number', 'Unique Job Number:') !!}
                            <select name="unique_job_number" class="form-control select2" id="unique_job_number"  onchange="getZone(this.value)">>
                                <option selected disabled>Select Customer</option>
                                @if(isset($customers) && count($customers) > 0)
                                @foreach($customers as $customer)
                                        <option @if(isset($ticket) && $ticket->unique_job_number == $customer->unique_job_number) selected @endif value="{{$customer->unique_job_number}}">{{$customer->unique_job_number}} {{$customer->project_name}}  _   {{$customer->zone}} </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
<!--                     <div class="form-group col-sm-6">-->
<!--                        {!! Form::label('product_id', 'Customer Product:') !!}-->
<!--                         <select name="product_id" class="form-control select2" id="product_id"></select>-->
<!--                     </div>-->
<!--                     <div class="form-group col-sm-6">-->
<!--                         {!! Form::label('unique_job_number', 'Unique Job Number:') !!}-->
<!--                         <select name="unique_job_number" class="form-control select2" id="unique_job_number" onchange="getZone(this.value)"></select>-->
<!--                </div>-->
                        <div class="form-group col-sm-6">
                            {!! Form::label('title', 'Title:') !!}
                            <select name="title" class="form-control select2" id="title">
                                <option selected disabled>Select Title</option>
                                @if(isset($problems) && count($problems) > 0)
                                    @foreach($problems as $problem)
                                        <option @if(isset($ticket) && $ticket->title == $problem->title) selected @endif value="{{$problem->title}}">{{$problem->title}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>


                        <div class="form-group col-sm-12">
                            {!! Form::label('description', 'Description:') !!}
                            <textarea name="description" class="form-control" rows="5" id="description"></textarea>
                        </div>
                        <div class="col-md-6">
                            {!! Form::label('image', 'Image:') !!}
                            <input name="image" type="file" class="form-control">
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Priority Status (Is Urgent) :</label>
                            <div class="clearfix"></div>
                            <label class="radio-inline">
                                <input type="radio" name="is_urgent" value="yes">Yes
                            </label>
                            <label class="radio-inline">
                                <input type="radio" checked name="is_urgent"  value="no">No
                            </label>
                        </div>
                        <div class="form-group col-sm-6">
                            {!! Form::label('assigned_to', 'Assign To:') !!}
                            <select name="assigned_to" class="form-control select2"  id="assigned_to">
                                <option selected disabled>Select Team Leader</option>
                                @if(isset($teams) && count($teams) > 0)
                            @foreach($teams as $team)
                               <option @if(isset($ticket) && $ticket->assigned_to == $team->id) selected @endif value="{{$team->id}}">{{$team->name}}</option>
                            @endforeach
                            @endif
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            {!! Form::label('status', 'Status:') !!}
                            <select class="form-control" name="status" onchange="getStatus(this)" id="status">
                                <option value="Pending" selected >Pending</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-12 forward_reason" style="display: none">
                            {!! Form::label('forward_reason', 'Forwarded Reason:') !!}
                            <textarea name="forward_reason" class="form-control" rows="5"></textarea>
                        </div>
                        <div class="form-group col-sm-12 hold_reason" style="display: none">
                            {!! Form::label('hold_reason', 'Onhold Reason:') !!}
                            <textarea name="hold_reason" class="form-control" rows="5"></textarea>
                        </div>
                        <div class="form-group col-sm-12">
                            {!! Form::button('Save', ['class' => 'btn btn-primary', 'onclick' => 'ticketSubmit()']) !!}
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
        function getStatus(sel){
           var value = sel.value;
           if(value == 'Onhold'){
               $('.hold_reason').show();
               $('.forward_reason').hide();
           }
           else if(value == 'Forwarded'){
               $('.forward_reason').show();
               $('.hold_reason').hide()
           }
           else{
               $('.hold_reason').hide();
               $('.forward_reason').hide();
           }
        }

        function ticketSubmit(){
            var customer_id = $('#customer_id').val();
            var title = $('#title').val();
            var unique_job_number = $('#unique_job_number').val();
            // var description = $('#description').val();
            var assigned_to = $('#assigned_to').val();
            var status = $('#status').val();
            var ticket_id = $('#ticket_id').val();

            if(unique_job_number == null){
                toastr.clear();
                toastr.error('Unique Job Number Required');
            }
            else if(title == null){
                toastr.clear();
                toastr.error('Title Required');
            }
            else if(assigned_to == null){
                toastr.clear();
                toastr.error('Assigned To Required');
            }
            else if(status == null){
                toastr.clear();
                toastr.error('Status Required');
            }
            else{
                // {{--$.ajax({--}}
                //     {{--method: 'post',--}}
                //     {{--url: '{{url('checkTicketJobNumber')}}',--}}
                //     {{--data: {'ticket_id' : ticket_id,'unique_job_number':unique_job_number,'_token':'{{csrf_token()}}'},--}}
                //     {{--success: function(response){--}}
                //        {{--console.log(response);--}}
                //        {{--if(response == 'number_exists'){--}}
                //            {{--toastr.error('Unique Number Already In Use');--}}
                //        {{--}--}}
                //        {{--else{--}}
                           $('#createTicket').submit();
                       // }
                    // }
                // });
            }
        }


        $(document).ready(function(){
            $('.select2').select2();
        });

        function getProducts(val){
            $.ajax({
                url: "{{ url('getProducts') }}"+'/'+val,
                type: "get",
                success: function(data)
                {
                    console.log(data);
                    $("#product_id").html(data);
                }
            });
        }

        function getJobNumber(val){
            $.ajax({
                url: "{{ url('getProducts') }}"+'/'+val,
                type: "get",
                success: function(data)
                {
                    console.log(data);
                    $("#unique_job_number").html(data);
                }
            });
        }
        function getZone(val){
            $.ajax({
                url: "{{ url('getZone') }}"+'/'+val,
                type: "get",
                success: function(data)
                {
                    $("#assigned_to").html(data);
                }
            });
        }
    </script>
@endsection
