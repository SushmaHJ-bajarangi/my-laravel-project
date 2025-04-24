@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">AMC PAYMENT DIRECT</h1>
        <h1 class="pull-right">
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <!-- Title Field -->
            <form method="POST" id="amcPayment">
                @csrf
                <div class="form-group col-sm-12">
                    {!! Form::label('Job Number', 'Job Number:') !!}
                    <select name="unique_job_number" class="form-control select2" id="unique_job_number" >
                        <option selected disabled hidden >Select Job Number</option>
                        @foreach($customerProduct as $item)
                        <option value="{{$item->unique_job_number}}">{{$item->unique_job_number}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-sm-6">
                    {!! Form::label('Amount', 'Amount:') !!}
                    {!! Form::number('amount', null, ['class' => 'form-control','id'=>'amount']) !!}
                </div>

                <div class="form-group col-sm-6">
                    <label>Plans</label>
                    <select class="form-control" name="plan" id="plan">
                        <option selected disabled hidden>Select Plans</option>
                        @if(isset($plans) && count($plans) > 0)
                            @foreach($plans as $plans)
                                <option  value="{{$plans->id}}">{{$plans->title}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="form-group col-sm-6" id="warranty_start_date_id">
                    {!! Form::label('amc_start_date', 'AMC Start Date:') !!}
                    <div class = 'input-group date' id='datetimepicker4'>
                        <input type = 'text'  id="start_date" name="start_date" class="form-control"  />
                        <span class = "input-group-addon">
                             <span class = "glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                </div>

                <!-- Warranty End Date Field -->
                <div class="form-group col-sm-6" id="warranty_end_date_id">
                    {!! Form::label('amc_end_date', 'AMC End Date:') !!}
                    <div class = 'input-group date' id='datetimepicker3'>
                        <input type = 'text' id="end_date" name="end_date" class="form-control"  />
                        <span class = "input-group-addon">
                         <span class = "glyphicon glyphicon-time"></span>
                        </span>
                     </div>
                </div>

                <div class="form-group col-sm-6">
                    {!! Form::label('Services', 'Services:') !!}
                    <input type='number' id="services" name="services" class="form-control"/>
                </div>

                <!-- Submit Field -->
                <div class="form-group col-sm-12">
                    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                </div>
            </form>
            </div>
        </div>
        <div class="text-center">
        </div>
    </div>
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>

<script>
    $(document).ready(function() {
        $("#datetimepicker3").datetimepicker({
            format: "DD-MM-YYYY"
        });
        $("#datetimepicker4").datetimepicker({
            format: "DD-MM-YYYY"
        });
        $(".select2").select2();
        $('#amcPayment').submit(function(e) {
            e.preventDefault();

            var unique_job_number = $('#unique_job_number').val();
            var services = $('#services').val();
            var amount = $('#amount').val();
            var plan = $('#plan').val();
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            if(unique_job_number == null){
                toastr.clear();
                toastr.error('Please Select Unique Job Number');
            }
            else if(services == '' || services == '0')
            {
                toastr.error('Please enter number of service');
            }
           else if(amount == '')
            {
                toastr.clear();
                toastr.error('Please enter any amount');
            }
           else if(plan == null)
            {
                toastr.clear();
                toastr.error('Please Select any plans');
            }
          else  if(start_date == '')
            {
                toastr.clear();
                toastr.error('Please Select start Date');
            }
           else if(end_date == '')
            {
                toastr.clear();
                toastr.error('Please Select end Date');
            }
            else {
                var formData = {
                    '_token': '{{ csrf_token() }}',
                    unique_job_number: $("#unique_job_number").val(),
                    services: $("#services").val(),
                    amount: $("#amount").val(),
                    plan: $("#plan").val(),
                    start_date: $("#start_date").val(),
                    end_date: $("#end_date").val(),
                };
                $.ajax({
                    type: "POST",
                    url: '{{url("paymentamc/createamcpayment")}}',
                    data: formData,
                    dataType: 'json',
                    success: function (data) {
                        if(data.status_data =='success')
                        {
                            toastr.clear();
                            toastr.success(data.msg);
                            window.location.reload()
                        }
                        else {
                            toastr.clear();
                            toastr.error(data.msg);
                            window.location.reload()
                        }

                    },
                    error: function (data) {
                        console.log(data);
                        window.location.reload()
                    }
                });
            }
        });

    });
</script>
@endsection

