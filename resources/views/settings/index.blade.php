@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-12">
        <div class="col-md-7">
            <h4>Price Plan</h4>
            <div class="box box-primary">
                <div class="box-body" style="height:485px;overflow: auto">
                    <button style="margin-bottom: 10px" class="btn btn-primary pull-right" data-toggle="modal" data-target="#priceModal">Add New</button>
                    <div class="clearfix"></div>
                    @if(isset($plans_price) && count($plans_price) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Plan</th>
                                <th>Price</th>
                                <th>Number of floors</th>
                                <th>Number of passengers</th>
                                @if (auth()->check())
                                @if (auth()->user()->role == 1)
                                <th>Actions</th>
                                @else
                                <th></th>
                                @endif
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @php($count = 1)
                            @foreach($plans_price as $price)
                            <tr>
                                <td>{{$count}}</td>
                                <td>{{$price->getPlan->title}}</td>
                                <td>{{$price->price}}</td>
                                @if(isset($price->no_of_floors_from) && isset($price->no_of_floors_to))
                                <td>{{$price->no_of_floors_from}} to {{$price->no_of_floors_to}}</td>
                                @endif
                                @if(isset($price->passengers_capacity_from) && isset($price->passengers_capacity_to))
                                <td>{{$price->passengers_capacity_from}} to {{$price->passengers_capacity_to}}</td>
                                @endif
                                @if (auth()->check())
                                @if (auth()->user()->role == 1)
                                <td>
                                    <div class='plan-btn-group'>
                                        <a class="btn btn-default btn-xs" data-toggle="modal" data-target="#priceModal_{{$price->id}}"><i class="glyphicon glyphicon-edit"></i></a>
                                        <form method="post" action="{{url('planPriceDelete/'.$price->id)}}">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                            <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                                @else
                                <td></td>
                                @endif
                                @endif
                            </tr>
                            @php($count++)
                            <div id="priceModal_{{$price->id}}" class="modal fade" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Edit Price Plan</h4>
                                        </div>
                                        <div class="">
                                            <div class="col-md-12">
                                                <form method="post" action="{{url('updatePlan/'.$price->id)}}" id="postPrice_{{$price->id}}">
                                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                    <input type="hidden" name="id" value="{{$price->id}}">
                                                    <div class="col-md-6 marginTop">
                                                        <label>Plans</label>
                                                        <select class="form-control" name="plan_id" id="plan_id_{{$price->id}}">
                                                            <option disabled selected>Select Plan</option>
                                                            @if(isset($plans) && count($plans) > 0)
                                                            @foreach($plans as $plan)
                                                            <option @if(isset($price) && $price->plan_id == $plan->id) selected @endif value="{{$plan->id}}">{{$plan->title}}</option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 marginTop">
                                                        <label>Price Plan</label>
                                                        <input type="number" name="price" class="form-control" id="price_{{$price->id}}" value="{{$price->price}}">
                                                    </div>

                                                    <div class="col-md-6 marginTop">
                                                        <label>Number Of Floors</label>
                                                        <input type="number" id="no_of_floors_from_{{$price->id}}" value="{{$price->no_of_floors_from}}" name="no_of_floors_from" class="form-control" placeholder="From">
                                                    </div>
                                                    <div class="col-md-6 marginTop">
                                                        <label class="visibleNone">Number Of Floors</label>
                                                        <input type="number" id="no_of_floors_to_{{$price->id}}" value="{{$price->no_of_floors_to}}" name="no_of_floors_to" class="form-control" placeholder="To">
                                                    </div>

                                                    <div class="col-md-6 marginTop">
                                                        <label>Passengers Capacity</label>
                                                        <input type="number" value="{{$price->passengers_capacity_from}}" name="passengers_capacity_from" id="passengers_capacity_from_{{$price->id}}" class="form-control" placeholder="From">
                                                    </div>
                                                    <div class="col-md-6 marginTop">
                                                        <label class="visibleNone">Passengers Capacity</label>
                                                        <input type="number" value="{{$price->passengers_capacity_to}}" id="passengers_capacity_to_{{$price->id}}" name="passengers_capacity_to" class="form-control" placeholder="To">
                                                    </div>
                                                    <div class="col-md-6 marginTop">
                                                        <button type="button" class="btn btn-success" onclick="priceUpdate('{{$price->id}}')">Submit</button>
                                                    </div>
                                                    <div class="col-md-6 marginTop">
                                                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="modal-footer"></div>
                                    </div>

                                </div>
                            </div>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-center">NO RECORDS FOUND</p>
                    @endif
                </div>
            </div>

            <div id="priceModal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Create Price Plan</h4>
                        </div>
                        <div class="">
                            <div class="col-md-12">
                                <form method="post" action="{{url('postPlan')}}" id="postPrice">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <div class="col-md-6 marginTop">
                                        <label>Plans</label>
                                        <select class="form-control" name="plan_id" id="plan_id">
                                            <option disabled selected>Select Plan</option>
                                            @if(isset($plans) && count($plans) > 0)
                                            @foreach($plans as $plan)
                                            <option value="{{$plan->id}}">{{$plan->title}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-6 marginTop">
                                        <label>Price Plan</label>
                                        <input type="number" name="price" class="form-control" id="price">
                                    </div>
                                    <div class="col-md-6 marginTop">
                                        <label>Number Of Floors</label>
                                        <input type="number" id="no_of_floors_from" name="no_of_floors_from" class="form-control" placeholder="From">
                                    </div>
                                    <div class="col-md-6 marginTop">
                                        <label class="visibleNone">Number Of Floors</label>
                                        <input type="number" id="no_of_floors_to" name="no_of_floors_to" class="form-control" placeholder="To">
                                    </div>

                                    <div class="col-md-6 marginTop">
                                        <label>Passengers Capacity</label>
                                        <input type="number" name="passengers_capacity_from" id="passengers_capacity_from" class="form-control" placeholder="From">
                                    </div>
                                    <div class="col-md-6 marginTop">
                                        <label class="visibleNone">Passengers Capacity</label>
                                        <input type="number" id="passengers_capacity_to" name="passengers_capacity_to" class="form-control" placeholder="To">
                                    </div>
                                    <div class="col-md-6 marginTop">
                                        <button type="button" class="btn btn-success" onclick="priceSubmit()">Submit</button>
                                    </div>
                                    <div class="col-md-6 marginTop">
                                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer"></div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-5">
            <h4>Distance Price</h4>
            <div class="box box-primary">
                <div class="box-body">
                    <form method="post" action="{{url('postDistance')}}">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                        <?php
                        $fieldName100 = 'distance_less_than_100';
                        $fieldName100_200 = 'distance_less_than_100_greater_than_200';
                        $fieldName200 = 'distance_greater_than_200';
                        if(\App\Models\Settings::where('key',$fieldName100)->exists()){
                            $getfieldName100 = \App\Models\Settings::where('key',$fieldName100)->first();
                            $value100 = $getfieldName100['value'];
                        }
                        if(\App\Models\Settings::where('key',$fieldName100_200)->exists()){
                            $getfieldName100_200 = \App\Models\Settings::where('key',$fieldName100_200)->first();
                            $value100_200 = $getfieldName100_200['value'];
                        }
                        if(\App\Models\Settings::where('key',$fieldName200)->exists()){
                            $getfieldName200 = \App\Models\Settings::where('key',$fieldName200)->first();
                            $value200 = $getfieldName200['value'];
                        }
                        ?>
                        
                        <div class="form-group">
                            <label>Distance < 100</label>
                            <input type="hidden" value="distance_less_than_100" name="key[]">
                            <input required type="number" @if(isset($fieldName100) && isset($value100)) value="{{$value100}}" @endif class="form-control" name="value[]">
                        </div>
                        <div class="form-group">
                            <label>Distance < 100 > 200</label>
                            <input type="hidden" value="distance_less_than_100_greater_than_200" name="key[]">
                            <input required type="number" @if(isset($fieldName100_200) && isset($value100_200)) value="{{$value100_200}}" @endif class="form-control" name="value[]">
                        </div>
                        <div class="form-group">
                            <label>Distance > 200</label>
                            <input type="hidden" value="distance_greater_than_200" name="key[]">
                            <input required type="number" @if(isset($fieldName200) && isset($value200)) value="{{$value200}}" @endif class="form-control" name="value[]">
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function priceSubmit(){
        var plan_id = $('#plan_id').val();
        var price = $('#price').val();
        var no_of_floors_from = $('#no_of_floors_from').val();
        var no_of_floors_to = $('#no_of_floors_to').val();
        var passengers_capacity_from = $('#passengers_capacity_from').val();
        var passengers_capacity_to = $('#passengers_capacity_to').val();
        if(plan_id == null){
            toastr.clear();
            toastr.error('Plan Required');
        }
        else if(price == '' || price.length <= 0){
            toastr.clear();
            toastr.error('Price Required');
        }
        else if(no_of_floors_from == '' || no_of_floors_from.length <= 0){
            toastr.clear();
            toastr.error('Number Of Floors Required');
        }
        else if(no_of_floors_to == '' || no_of_floors_to.length <= 0){
            toastr.clear();
            toastr.error('Number Of Floors Required');
        }
        else if(passengers_capacity_from == '' || passengers_capacity_from.length <= 0){
            toastr.clear();
            toastr.error('Passenger Capacity Required');
        }
        else if(passengers_capacity_to == '' || passengers_capacity_to.length <= 0){
            toastr.clear();
            toastr.error('Passenger Capacity Required');
        }
        else{
            $('#postPrice').submit();
        }
    }

    function priceUpdate(id){
        var plan_id = $('#plan_id_'+id).val();
        var price = $('#price_'+id).val();
        var no_of_floors_from = $('#no_of_floors_from_'+id).val();
        var no_of_floors_to = $('#no_of_floors_to_'+id).val();
        var passengers_capacity_from = $('#passengers_capacity_from_'+id).val();
        var passengers_capacity_to = $('#passengers_capacity_to_'+id).val();
        if(plan_id == null){
            toastr.clear();
            toastr.error('Plan Required');
        }
        else if(price == '' || price.length <= 0){
            toastr.clear();
            toastr.error('Price Required');
        }
        else if(no_of_floors_from == '' || no_of_floors_from.length <= 0){
            toastr.clear();
            toastr.error('Number Of Floors Required');
        }
        else if(no_of_floors_to == '' || no_of_floors_to.length <= 0){
            toastr.clear();
            toastr.error('Number Of Floors Required');
        }
        else if(passengers_capacity_from == '' || passengers_capacity_from.length <= 0){
            toastr.clear();
            toastr.error('Passenger Capacity Required');
        }
        else if(passengers_capacity_to == '' || passengers_capacity_to.length <= 0){
            toastr.clear();
            toastr.error('Passenger Capacity Required');
        }
        else{
            $('#postPrice_'+id).submit();
        }
    }
</script>
@endsection