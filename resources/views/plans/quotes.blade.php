@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
@endsection
@section('content')
    <section class="content-header">
        <h1 class="pull-left">Generated Quotes</h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <table id="example" class="display" style="width:100%">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Customer</th>
                        <th>Job Number</th>
                        <th>Plan</th>
                        <th>Price</th>
                        <th>Services</th>
                        <th>Rating</th>
                        @if (auth()->check())
                            @if (auth()->user()->role == 1)
                                <th>Action</th>
                                @else
                                <th></th>
                                @endif
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($quotes) && count($quotes) > 0)
                        @php($count = 1)
                        @foreach($quotes as $quote)
                            <?php
                                $customer = App\Models\customers::where('id',$quote->generateQuoteDetails->customer_id)->first();
                                $getCustomerDel = App\Models\customer_products::where('unique_job_number',$quote->generateQuoteDetails->customer_job_id)->first();
                                $floors = $getCustomerDel->number_of_floors;
                                $passengers = $getCustomerDel->passenger_capacity;
                                $getCustomerPrice = App\Models\PlanPrice::where('is_deleted',0)
                                                    ->where(function ($query) use ($floors) {
                                                    $query->where('no_of_floors_from', '<=', $floors)->where('no_of_floors_to', '>=', $floors);
                                                    })
                                                    ->where(function ($query1) use ($passengers) {
                                                        $query1->where('passengers_capacity_from', '<=', $passengers)->where('passengers_capacity_to', '>=', $passengers);
                                                    })
                                                    ->first();
                                $distance = $getCustomerDel->distance;
                                if($distance == '200'){
                                    $setting = App\Models\Settings::where('key','distance_greater_than_200')->first();
                                    $price = $setting->value;
                                }
                                else if($distance == '100'){
                                    $setting = App\Models\Settings::where('key','distance_less_than_100')->first();
                                    $price = $setting->value;
                                }
                                else if($distance == '100-200'){
                                    $setting = App\Models\Settings::where('key','distance_less_than_100_greater_than_200')->first();
                                    $price = $setting->value;
                                }
                            if(isset($getCustomerPrice->price)){
                                    $sum = $getCustomerPrice->price+$price;
                                }
                                else{
                                    $sum = $price;
                                }
                            ?>
                            <tr>
                                <td>{{$count}}</td>
                                <td>{{$customer->name}}</td>
                                <td>{{$quote->generateQuoteDetails->customer_job_id}}</td>
                                <td>{{$quote->getPlan->title}}</td>
                                <td><span>Generated Price : {{$sum}}</span><input type="number" name="price" id="price_{{$quote->id}}" @if(isset($quote->final_amount)) value="{{$quote->final_amount}}" @else value="{{$quote->price}}" @endif class="form-control"></td>
                                <td><input type="number" name="services" id="services_{{$quote->id}}" @if(isset($quote->service)) value="{{$quote->service}}" @endif class="form-control" style="margin-top: 19px"></td>
                                <td><?php
                                    $count=App\Models\review::where('customer_id',$customer->id)->count();
                                    $review=App\Models\review::where('customer_id',$customer->id)->sum('t_star');
                                    if($review !=0)
                                    {
                                        $final_review=$review/$count;
                                        echo round($final_review,2);
                                    }
                                    else{
                                        echo '0.0';
                                    }

                                ?></td>
                                @if (auth()->check())
                                    @if (auth()->user()->role == 1)
                                        <td>
                                            <div class='plan-btn-group'>
                                                <a onclick="editQuote('{{$quote->id}}')" class='btn btn-success' style="margin-right: 10px">Generate Quote</a>
                                                <form method="post" action="{{url('generateQuotesDelete/'.$quote->id)}}">
                                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                    <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-trash"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    @else
                                        <td></td>
                                    @endif
                                @endif
                            </tr>
                            @php($count++)
                        @endforeach
                    @else
                        <tr>
                            <center><td rowspan="8">NO RECORDS</td></center>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        } );

        function editQuote(id){
            var price = $('#price_'+id).val();
            var services = $('#services_'+id).val();
            if(price == '' || price.length <= 0){
                toastr.clear();
                toastr.error('Price Required');
            }
            else if(services == '' || services.length <= 0){
                toastr.clear();
                toastr.error('Services Required');
            }
            else{
                $.ajax({
                    url: '{{url('updateQuote')}}',
                    type: 'post',
                    data: {'id':id,'price':price,'services':services,'_token':'{{csrf_token()}}'},
                    success: function(response) {
                       if(response == 'success'){
                           toastr.success('Quote Updated Successfully');
                       }
                    }
                });
            }
        }
    </script>
@endsection
