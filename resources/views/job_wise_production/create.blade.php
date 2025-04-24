@extends('layouts.app')

@section('content')

<section class="content-header">
    <h1>
       Job-Wise Production And Dispatch Status
    </h1>
</section>

<div class="content">

    @include('adminlte-templates::common.errors')

                <form method="post" action="{{url('job_wise_production/store')}}">
                    @csrf

                    <input type="hidden" name="current_step" id="current_step" value="1">

                    <ul class="nav nav-tabs" id="stepper" style="display:none;">

                        <li class="active">
                            <a href="#step1" data-toggle="tab" id="step1-tab">Step 1</a>
                        </li>

                        <li>
                            <a href="#step2" data-toggle="tab" id="step2-tab">Step 2</a>
                        </li>

                        <li>
                            <a href="#step3" data-toggle="tab" id="step3-tab">Step 3</a>
                        </li>

                        <li>
                            <a href="#step4" data-toggle="tab" id="step4-tab">Step 4</a>
                        </li>

                        <li>
                            <a href="#step5" data-toggle="tab" id="step5-tab">Step 5</a>
                        </li>

                        <li>
                            <a href="#step6" data-toggle="tab" id="step6-tab">Step 6</a>
                        </li>

                        <li>
                            <a href="#step7" data-toggle="tab" id="step7-tab">Step 7</a>
                        </li>

                    </ul>

                    <div class="tab-content">

                        <div class="tab-pane active" id="step1">
                            
                               <div class="box box-primary">
                           <div class="box-body">
                            <div class="row">

                    <div class="form-group col-sm-12">
                        <label for="place">Place:</label>
                        <input class="form-control" id="place" name="place" type="text" value="{{old('place')}}">
                    </div>

                    <div class="form-group col-sm-12">
                        <label>Job No:</label>
                        <select class="form-control select2"  style="position: relative !important;" name="job_no"  id="job_no" onchange="getJobDetails(this.value)" required>
                            <option selected disabled>Select JobNo</option>
                            @if(isset($jobno) && count($jobno) > 0)
                            @foreach($jobno as $item)
                            <option value="{{$item->job_no}}" {{ old('$jobno') == $item->job_no ? 'selected' : ''}}>{{$item->job_no}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group col-sm-12 ">
                        <label>CRM:</label>
                        <select class="form-control select2" style="position: relative !important;"  name="crm_id" id="crm_id">
                            <option selected disabled>Select Crm</option>
                            @if(isset( $crm) && count( $crm) > 0)
                            @foreach( $crm as $item)
                            <option value="{{$item->id}}" {{ old('crm_id') == $item->id ? 'selected' : ''}}>{{$item->name}} </option>
                            @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="payment_received_manufacturing_date">Payment Received for  Manufactruing  Date:</label>
                        <input class="form-control" id="payment_received_manufacturing_date" name="payment_received_manufacturing_date" type="date" value="{{old('payment_received_manufacturing_date')}}">
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="crm_confirmation_date">Crm Confirmation Date:</label>
                        <input class="form-control" id="crm_confirmation_date" name="crm_confirmation_date" type="date" value="{{old('crm_confirmation_date')}}">
                    </div>

                    <div class="form-group col-sm-12 ">
                        <label>Customer Name</label>
                        <input class ="form-control" id="customer_id"  name="customer_id"  type="text" value="{{old('customer_id')}}">
<!--                        <select class="form-control select2"  style="position: relative !important;" name="customer_id" id="customer_id" required="" value="{{old('customer_id')}}">-->
<!--                            <option selected disabled>Select Customer</option>-->
<!--                            @if(isset($customer) && count($customer) > 0)-->
<!--                            @foreach($customer as $item)-->
<!--                            <option value="{{$item->id}}" {{ old('customer_id') == $item->id ? 'selected' : ''}}>{{$item->name}}</option>-->
<!--                            @endforeach-->
<!--                            @endif-->
<!--                        </select>-->
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="addressu">Address Details:</label>
                        <textarea class="form-control" id="addressu" name="addressu" cols="50" rows="10" value="{{old('addressu')}}"></textarea>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="specifications">Specifications:</label>
                        <textarea class="form-control" id="specifications" name="specifications" cols="50" rows="10" value="{{old('specifications')}}"></textarea>
                    </div>

                            </div>
                        </div>
                        </div>
                            <a href="{{ url('job_wise_production') }}" class="btn btn-default">Cancel</a>
                            <button class="btn btn-primary next-step">Next</button>
                        </div>

                        <div class="tab-pane" id="step2">
                            <div class="box box-primary">
                        <div class="box-body">

                            <hr style="clear: both;">
                            <div class="form-group col-sm-12">
                                <label for=""> For Factory Use only</label>
                            </div>
                            <hr style="clear: both;">

                            <hr style="clear: both;">
                            <div class="form-group col-sm-12">
                                <label for=""> 1ST  LOT PRODUCTION DETAILS</label>
                            </div>
                            <hr style="clear: both;">

                            <div class="row">

                                <hr style="clear: both;">
                                <div class="form-group col-sm-12">
                                    <label for=""> Bracket Details </label>
                                </div>
                                <hr style="clear: both;">


                                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Car Bracket</label>
                                        <select class="form-control select2" name="car_bracket" id="car_bracket">
                                            <option selected disabled>Select Car Bracket</option>
                                            @if(isset($carbracket) && count($carbracket) > 0)
                                                @foreach($carbracket as $item)
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Car Bracket Readiness Status</label>
                                        <select class="form-control select2" name="car_bracket_readiness_status" id="car_bracket_readiness_status">
                                            <option selected disabled> Select Car Bracket Radiness Status </option>
                                            @if(isset($readinessstatus) && count($readinessstatus) > 0)
                                                @foreach($readinessstatus as $item)
                                                    <option value="{{$item->id}}">{{$item->title}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="car_bracket_readiness_date">Car Bracket Radiness Date:</label>
                                    <input class="form-control" id="car_bracket_readiness_date" name="car_bracket_readiness_date" type="date" value="{{old('car_bracket_readiness_date')}}">
                                </div>
                                </div>



                                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Cwt Bracket</label>
                                        <select class="form-control select2" name="cwt_bracket" id="cwt_bracket">
                                            <option selected disabled>Select cwt Bracket</option>
                                            @if(isset($cwtbracket) && count($cwtbracket) > 0)
                                                @foreach($cwtbracket as $item)
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Cwt Bracket Radiness Status</label>
                                        <select class="form-control select2" name="cwt_bracket_readiness_status" id="cwt_bracket_readiness_status">
                                            <option selected disabled> Select Cwt Bracket Radiness Status </option>
                                            @if(isset($readinessstatus) && count($readinessstatus) > 0)
                                                @foreach($readinessstatus as $item)
                                                    <option value="{{$item->id}}">{{$item->title}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                                <div class="form-group ">
                                    <label for="cwt_bracket_readiness_date">Cwt Bracket Radiness Date:</label>
                                    <input class="form-control" id="cwt_bracket_readiness_date" name="cwt_bracket_readiness_date" type="date" value="{{old('cwt_bracket_readiness_date')}}">
                                </div>
                                </div>


                                <hr style="clear: both;">
                                <div class="form-group col-sm-12">
                                    <label for=""> Landing Door Details </label>
                                </div>
                                <hr style="clear: both;">

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>LD Opening</label>
                                        <select class="form-control" name="ld_opening" id="ld_opening">
                                            <option selected disabled>Select LD Opening</option>
                                            @if(isset($ldopening) && count($ldopening) > 0)
                                                @foreach($ldopening as $item)
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>LD Finish</label>
                                        <select class="form-control" name="ld_finish" id="ld_finish">
                                            <option selected disabled>Select LD Finish</option>
                                            @if(isset($ldfinish) && count($ldfinish) > 0)
                                                @foreach($ldfinish as $item)
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>LD Frame Status</label>
                                        <select class="form-control select2" name="ld_frame_status" id="ld_frame_status">
                                            <option selected disabled>Select LD Frame Status</option>
                                            @if(isset($readinessstatus) && count($readinessstatus) > 0)
                                                @foreach($readinessstatus as $item)
                                                    <option value="{{$item->id}}">{{$item->title}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label for="ld_frame_readiness_date">LD Frame Readiness Date:</label>
                                    <input class="form-control" id="ld_frame_readiness_date" name="ld_frame_readiness_date" type="date" value="{{old('ld_frame_readiness_date')}}">
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>LD Status</label>
                                        <select class="form-control select2" name="ld_status" id="ld_status">
                                            <option selected disabled>Select LD Status</option>
                                            @if(isset($readinessstatus) && count($readinessstatus) > 0)
                                                @foreach($readinessstatus as $item)
                                                    <option value="{{$item->id}}">{{$item->title}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label for="ld_readiness_date">LD Radiness Date:</label>
                                    <input class="form-control" id="ld_readiness_date" name="ld_readiness_date" type="date" value="{{old('ld_readiness_date')}}">
                                </div>

                                <div class="form-group col-sm-12">
                                    <label for="comments">Comments:</label>
                                    <textarea class="form-control" id="comments" name="comments" cols="50" rows="10" value ="{{old('comments')}}"></textarea>
                                </div>

                            </div>
                        </div>
                    </div>
                             <hr style="clear: both;">
                            <button class="btn btn-secondary prev-step">Previous</button>
                            <button class="btn btn-primary next-step">Next</button>
                        </div>

                        <div class="tab-pane" id="step3">
                             <div class="box box-primary">
                        <div class="box-body">

                            <hr style="clear: both;">
                            <div class="form-group col-sm-12">
                                <label for=""> 2nd LOT PRODUCTION DETAILS</label>
                            </div>
                            <hr style="clear: both;">

                            <div class="row">

                                <hr style="clear: both;">
                                <div class="form-group col-sm-12">
                                    <label for=""> Machine Channel Details </label>
                                 </div>
                                <hr style="clear: both;">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Machine Channel Type</label>
                                        <select class="form-control select2" name="machine_channel_type" id="machine_channel_type">
                                            <option selected disabled>Select Machine Channel </option>
                                            @if(isset($machinechannel) && count($machinechannel) > 0)
                                                @foreach($machinechannel as $item)
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Machine Channel Readiness Status</label>
                                        <select class="form-control select2" name="machine_channel_readiness_status" id="machine_channel_readiness_status">
                                            <option selected disabled> Select Machine Channel Radiness Status </option>
                                            @if(isset($readinessstatus) && count($readinessstatus) > 0)
                                                @foreach($readinessstatus as $item)
                                                    <option value="{{$item->id}}">{{$item->title}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-sm-4">
                                    <label for="machine_channel_readiness_date">Machine channel Radiness Date:</label>
                                    <input class="form-control" id="machine_channel_readiness_date" name="machine_channel_readiness_date" type="date" value="{{old('machine_channel_readiness_date')}}">
                                </div>

                                <hr style="clear: both;">
                                <div class="form-group col-sm-12">
                                    <label for=""> Machine Details </label>
                                </div>
                                <hr style="clear: both;">


                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Machine</label>
                                        <select class="form-control select2" name="machine" id="machine">
                                            <option selected disabled>Select Machine</option>
                                            @if(isset($machine) && count($machine) > 0)
                                                @foreach($machine as $item)
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label> Machine Radiness Status</label>
                                        <select class="form-control select2" name="machine_readiness_status" id="machine_readiness_status">
                                            <option selected disabled> Select machine Radiness Status </option>
                                            @if(isset($readinessstatus) && count($readinessstatus) > 0)
                                                @foreach($readinessstatus as $item)
                                                    <option value="{{$item->id}}">{{$item->title}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-sm-4">
                                    <label for="machine_readiness_date">Machine Radiness Date:</label>
                                    <input class="form-control" id="machine_readiness_date" name="machine_readiness_date" type="date" value="{{old('machine_readiness_date')}}">
                                </div>

                                <hr style="clear: both;">
                                <div class="form-group col-sm-12">
                                    <label for=""> Car Frame Details </label>
                                </div>
                                <hr style="clear: both;">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Car Frame</label>
                                        <select class="form-control select2" name="car_frame" id="car_frame">
                                            <option selected disabled>Select Car Frame</option>
                                            @if(isset($carframe) && count($carframe) > 0)
                                                @foreach($carframe as $item)
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Car Frame Readiness Status</label>
                                        <select class="form-control select2" name="car_frame_readiness_status" id="car_frame_readiness_status">
                                            <option selected disabled>Select Car Frame Readiness Status</option>
                                            @if(isset($readinessstatus) && count($readinessstatus) > 0)
                                                @foreach($readinessstatus as $item)
                                                    <option value="{{$item->id}}">{{$item->title}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-sm-4">
                                    <label for="car_frame_readiness_date">Car Frame Radiness Date:</label>
                                    <input class="form-control" id="car_frame_readiness_date" name="car_frame_readiness_date" type="date" value="{{old('car_frame_readiness_date')}}">
                                </div>


                                <hr style="clear: both;">
                                <div class="form-group col-sm-12">
                                    <label for=""> Cwt Frame Details </label>
                                </div>
                                <hr style="clear: both;">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label> Cwt Frame  </label>
                                        <select class="form-control select2" name="cwt_frame" id="cwt_frame">
                                            <option selected disabled>Select Car frame</option>
                                            @if(isset($cwtframe) && count($cwtframe) > 0)
                                                @foreach($cwtframe as $item)
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>


                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Cwt Frame Radiness Status</label>
                                        <select class="form-control select2" name="cwt_frame_readiness_status" id="cwt_frame_status">
                                            <option selected disabled>Select Car Bracket</option>
                                            @if(isset($readinessstatus) && count($readinessstatus) > 0)
                                                @foreach($readinessstatus as $item)
                                                    <option value="{{$item->id}}">{{$item->title}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-sm-4">
                                    <label for="cwt_frame_readiness_date">Cwt Frame Radiness Date:</label>
                                    <input class="form-control" id="cwt_frame_readiness_date" name="cwt_frame_readiness_date" type="date" value="{{old('cwt_frame_readiness_date')}}">
                                </div>


                                <hr style="clear: both;">
                                <div class="form-group col-sm-12">
                                    <label for=""> Stock Items </label>
                                </div>
                                <hr style="clear: both;">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Rope Available</label>
                                        <select class="form-control select2" name="rope_available" id="rope_available">
                                            <option selected disabled>Select Car Bracket</option>
                                            @if(isset($ropeavailable) && count($ropeavailable) > 0)
                                                @foreach($ropeavailable as $item)
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>OSG Assy Available</label>
                                        <select class="form-control select2" name="osg_assy_available" id="osg_assy_available">
                                            <option selected disabled>Select Car Bracket</option>
                                            @if(isset($osgassyavailable) && count($osgassyavailable) > 0)
                                                @foreach($osgassyavailable as $item)
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-sm-12">
                                    <label for="comment_after_osg">Comments:</label>
                                    <textarea class="form-control" id="comment_after_osg" name="comment_after_osg" cols="50" rows="10" value ="{{old('comment_after_osg')}}"></textarea>
                                </div>

                            </div>
                        </div>
                    </div>
                 
                            <button class="btn btn-secondary prev-step">Previous</button>
                            <button class="btn btn-primary next-step">Next</button>
                        </div>

                        <div class="tab-pane" id="step4">
                    <div class="box box-primary">
                        <div class="box-body">

                            <hr style="clear: both;">
                            <div class="form-group col-sm-12">
                                <label for=""> 3rd LOT PRODUCTION DETAILS</label>
                            </div>
                            <hr style="clear: both;">

                            <div class="row">

                                <hr style="clear: both;">
                                <div class="form-group col-sm-12">
                                    <label for="">Cabin Details </label>
                                </div>
                                <hr style="clear: both;">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Cabin</label>
                                        <select class="form-control select2" name="cabin" id="cabin">
                                            <option selected disabled>Select Cabin</option>
                                            @if(isset($ldfinish) && count($ldfinish) > 0)
                                            @foreach($ldfinish as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Cabin Readiness Status</label>
                                        <select class="form-control select2" name="cabin_readiness_status" id="cabin_readiness_status">
                                            <option selected disabled> SelectCar Bracket Radiness Status </option>
                                            @if(isset($readinessstatus) && count($readinessstatus) > 0)
                                            @foreach($readinessstatus as $item)
                                            <option value="{{$item->id}}">{{$item->title}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-sm-4">
                                    <label for="cabin_readiness_date">Cabin Radiness Date:</label>
                                    <input class="form-control" id="cabin_readiness_date" name="cabin_readiness_date" type="date" value="{{old('cabin_readiness_date')}}">
                                </div>

                                <hr style="clear: both;">
                                <div class="form-group col-sm-12">
                                    <label for=""> Controller Details </label>
                                </div>
                                <hr style="clear: both;">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Controller</label>
                                        <select class="form-control select2" name="controller" id="controller">
                                            <option selected disabled>Select Controller</option>
                                            @if(isset($controller) && count($controller) > 0)
                                            @foreach($controller as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label> Controller Readiness Status</label>
                                        <select class="form-control select2" name="controller_readiness_status" id="controller_readiness_status">
                                            <option selected disabled> Select Controller Readiness Status </option>
                                            @if(isset($readinessstatus) && count($readinessstatus) > 0)
                                            @foreach($readinessstatus as $item)
                                            <option value="{{$item->id}}">{{$item->title}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-sm-4">
                                    <label for="controller_readiness_date">Controller Radiness Date:</label>
                                    <input class="form-control" id="controller_readiness_date" name="controller_readiness_date" type="date" value="{{old('controller_readiness_date')}}">
                                </div>


                                <hr style="clear: both;">
                                <div class="form-group col-sm-12">
                                    <label for=""> Car Door Details </label>
                                </div>
                                <hr style="clear: both;">

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Car Door Opening</label>
                                        <select class="form-control select2" name="car_door_opening" id="car_door_opening">
                                            <option selected disabled>Select Car Door Opening</option>
                                            @if(isset($cardooropening) && count($cardooropening) > 0)
                                            @foreach($cardooropening as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Car Door Finish</label>
                                        <select class="form-control select2" name="car_door_finish" id="car_door_finish">
                                            <option selected disabled>Select Car Door Finish</option>
                                            @if(isset($ldfinish) && count($ldfinish) > 0)
                                            @foreach($ldfinish as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Car Door Status</label>
                                        <select class="form-control select2" name="car_door_readiness_status" id="car_door_status">
                                            <option selected disabled>Select car door status</option>
                                            @if(isset($readinessstatus) && count($readinessstatus) > 0)
                                            @foreach($readinessstatus as $item)
                                            <option value="{{$item->id}}">{{$item->title}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-sm-3">
                                    <label for="car_door_readiness_date">Car Door Radiness Date:</label>
                                    <input class="form-control" id="car_door_readiness_date" name="car_door_readiness_date" type="date" value="{{old('car_door_readiness_date')}}">
                                </div>

                                <hr style="clear: both;">
                                <div class="form-group col-sm-12">
                                    <label for="">COP & LOP Details </label>
                                </div>
                                <hr style="clear: both;">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>COP & LOP </label>
                                        <select class="form-control select2" name="cop_lop" id="cop_and_lop">
                                            <option selected disabled>Select Cop And Lop</option>
                                            @if(isset($copandlop) && count($copandlop) > 0)
                                            @foreach($copandlop as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>COP & LOP Status</label>
                                        <select class="form-control select2" name="cop_lop_readiness_status" id="cop_and_lop_status">
                                            <option selected disabled>Select COP & LOP Status</option>
                                            @if(isset($readinessstatus) && count($readinessstatus) > 0)
                                            @foreach($readinessstatus as $item)
                                            <option value="{{$item->id}}">{{$item->title}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-sm-4">
                                    <label for="cop_and_lop_readiness_date">COP & LOP Radiness Date:</label>
                                    <input class="form-control" id="cop_and_lop_readiness_date" name="cop_lop_readiness_date" type="date" value="{{old('cop_and_lop_readiness_date')}}">
                                </div>

                                <hr style="clear: both;">
                                <div class="form-group col-sm-12">
                                    <label for=""> Harness Details </label>
                                </div>
                                <hr style="clear: both;">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Harness</label>
                                        <select class="form-control select2" name="harness" id="harness">
                                            <option selected disabled>Select Harness</option>
                                            @if(isset($harness) && count($harness) > 0)
                                            @foreach($harness as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Harness Readiness Status</label>
                                        <select class="form-control select2" name="harness_readiness_status" id="harness_readiness_status">
                                            <option selected disabled>Select Harness Readiness Status</option>
                                            @if(isset($readinessstatus) && count($readinessstatus) > 0)
                                            @foreach($readinessstatus as $item)
                                            <option value="{{$item->id}}">{{$item->title}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-sm-4">
                                    <label for="harness_readiness_date">Harness Radiness Date:</label>
                                    <input class="form-control" id="harness_readiness_date" name="harness_readiness_date" type="date" value="{{old('harness_readiness_date')}}">
                                </div>

                                <div class="form-group col-sm-12">
                                    <label for="commentscommentscomments">Comments:</label>
                                    <textarea class="form-control" id="commentscommentscomments" name="commentscommentscomments" cols="50" rows="10" value ="{{old('commentscommentscomments')}}"></textarea>
                                </div>

                            </div>
                        </div>
                    </div>
                    <hr style="clear: both;">
                        <button class="btn btn-secondary prev-step">Previous</button>
                        <button class="btn btn-primary next-step">Next</button>
                       </div>

                        <div class="tab-pane" id="step5">
                    <div class="box box-primary">
                        <div class="box-body">

                            <hr style="clear: both;">
                            <div class="form-group col-sm-12">
                                <label for=""> For Godown Use only</label>
                            </div>
                            <hr style="clear: both;">

                            <hr style="clear: both;">
                            <div class="form-group col-sm-12">
                                <label for=""> 1st LOT Dispatch Details</label>
                            </div>
                            <hr style="clear: both;">

                            <hr style="clear: both;">
                            <div class="form-group col-sm-12">
                                <label for=""> Bracket Details</label>
                            </div>
                            <hr style="clear: both;">

                            <div class="row">

                                <div class="form-group col-sm-12 ckeck1">
                                    <label for="myCheck">Full Dispatched:</label>
                                    <input type="checkbox" id="myCheck" onclick="toggleFields()" name="is_revised" checked>
                                </div>

                                <div class="form-group fullDispatch1 col-sm-3" id="fullDispatchedDate1">
                                    <label for="full_dispatched_date1">Full Dispatched Date:</label>
                                    <input class="form-control" id="full_dispatched_date1" name="full_dispatched_date1" type="date" value="{{old('full_dispatched_date1')}}">
                                </div>

                                <div id="otherFields1" style="display:none;">

                                    <div class="col-lg-3 col-md-3 col-sm-5 col-12">
                                        <div class="form-group">
                                            <label>Car Bracket Available Status</label>
                                            <select class="form-control select2 width-12" name="car_bracket_available_status" id="car_bracket_available_status">
                                                <option selected disabled>Select Car Bracket Available Status</option>
                                                @if(isset($readinessstatus) && count($readinessstatus) > 0)
                                                    @foreach($readinessstatus as $item)
                                                        <option value="{{$item->id}}">{{$item->title}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-5 col-12">
                                    <div class="form-group">
                                        <label for="car_bracket_available_date">Car Bracket Available Date:</label>
                                        <input class="form-control" id="car_bracket_available_date" name="car_bracket_available_date" type="date" value="{{old('car_bracket_available_date')}}">
                                    </div>
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-5 col-12">
                                        <div class="form-group">
                                            <label>Car Bracket Dispatch Status</label>
                                            <select class="form-control select2" name="car_bracket_dispatch_status" id="car_bracket_dispatch_status">
                                                <option selected disabled>Select Car Bracket Dispatch Status</option>
                                                @if(isset($readinessstatus) && count($readinessstatus) > 0)
                                                    @foreach($readinessstatus as $item)
                                                        <option value="{{$item->id}}">{{$item->title}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-3 col-sm-5 col-12">
                                    <div class="form-group">
                                        <label for="car_bracket_dispatch_date">Car Bracket Dispatch Date:</label>
                                        <input class="form-control" id="car_bracket_dispatch_date" name="car_bracket_dispatch_date" type="date" value="{{old('car_bracket_dispatch_date')}}">
                                    </div>
                                    </div>



                                        <div class="col-lg-3 col-md-3 col-sm-5 col-12">
                                        <div class="form-group">
                                            <label>Cwt Bracket Available Status</label>
                                            <select class="form-control select2" name="cwt_bracket_available_status" id="cwt_bracket_available_status">
                                                <option selected disabled>Select Cwt Bracket Available Status</option>
                                                @if(isset($readinessstatus) && count($readinessstatus) > 0)
                                                    @foreach($readinessstatus as $item)
                                                        <option value="{{$item->id}}">{{$item->title}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                        <div class="col-lg-3 col-md-3 col-sm-5 col-12">
                                         <div class="form-group">
                                             <label for="cwt_bracket_available_date">Cwt Bracket Available Date:</label>
                                             <input class="form-control" id="cwt_bracket_available_date" name="cwt_bracket_available_date" type="date" value="{{old('cwt_bracket_available_date')}}">
                                        </div>
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-sm-5 col-12">
                                        <div class="form-group">
                                            <label>Cwt Bracket Dispatch Status</label>
                                            <select class="form-control select2" name="cwt_bracket_dispatch_status" id="cwt_bracket_dispatch_status">
                                                <option selected disabled>Select Cwt Bracket Dispatch Status</option>
                                                @if(isset($readinessstatus) && count($readinessstatus) > 0)
                                                    @foreach($readinessstatus as $item)
                                                        <option value="{{$item->id}}">{{$item->title}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                        <div class="col-lg-2 col-md-3 col-sm-5 col-12">
                                    <div class="form-group">
                                        <label for="cwt_bracket_dispatch_date">Cwt Bracket Dispatch Date:</label>
                                        <input class="form-control" id="cwt_bracket_dispatch_date" name="cwt_bracket_dispatch_date" type="date" value="{{old('cwt_bracket_dispatch_date')}}">
                                    </div>
                                    </div>


                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="ld_frame_received_date">LD Frame Received Date:</label>
                                        <input class="form-control" id="ld_frame_received_date" name="ld_frame_received_date" type="date" value="{{old('ld_frame_received_date')}}">
                                    </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>LD Frame Dispatch Status</label>
                                            <select class="form-control select2" name="ld_frame_dispatch_status" id="ld_frame_dispatch_status">
                                                <option selected disabled>LD Frame Dispatch Status</option>
                                                @if(isset($readinessstatus) && count($readinessstatus) > 0)
                                                    @foreach($readinessstatus as $item)
                                                        <option value="{{$item->id}}">{{$item->title}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                        <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="ld_frame_dispatch_date">LD Frame Dispatch Date:</label>
                                        <input class="form-control" id="ld_frame_dispatch_date" name="ld_frame_dispatch_date" type="date" value="{{old('ld_frame_dispatch_date')}}">
                                    </div>
                                        </div>


                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="ld_received_date">LD Received Date:</label>
                                        <input class="form-control" id="ld_received_date" name="ld_received_date" type="date" value="{{old('ld_received_date')}}">
                                    </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>LD Dispatch Status</label>
                                            <select class="form-control select2" name="ld_dispatch_status" id="ld_dispatch_status">
                                                <option selected disabled>Select LD Dispatch Status</option>
                                                @if(isset($readinessstatus) && count($readinessstatus) > 0)
                                                    @foreach($readinessstatus as $item)
                                                        <option value="{{$item->id}}">{{$item->title}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="ld_dispatch_date">LD Dispatch Date:</label>
                                        <input class="form-control" id="ld_dispatch_date" name="ld_dispatch_date" type="date" value="{{old('ld_dispatch_date')}}">
                                    </div>
                                    </div>


                                </div>

                            </div>

                        </div>
                    <hr style="clear: both;">
                      </div>
                            <button class="btn btn-secondary prev-step">Previous</button>
                            <button class="btn btn-primary next-step">Next</button>
                        </div>

                        <div class="tab-pane" id="step6">

                     <div class="box box-primary">
                        <div class="box-body">

                            <hr style="clear: both;">
                            <div class="form-group col-sm-12">
                                <label for=""> 2nd LOT Dispatch Details</label>
                            </div>
                            <hr style="clear: both;">

                            <hr style="clear: both;">
                            <div class="form-group col-sm-12">
                                <label for=""> Machine Details</label>
                            </div>
                            <hr style="clear: both;">

                            <div class="row">

                                <div class="form-group col-sm-12">
                                    <label for="is_checkedbox">Full Dispatched:</label>
                                    <input type="checkbox" id="is_checkedbox" onclick="toggleFields_two()" name="is_checkedbox" checked>
                                </div>

                                <div class="form-group fullDispatch1 col-sm-3" id="fullDispatchedDate2">
                                    <label for="full_dispatched_date2">Full Dispatched Date:</label>
                                    <input class="form-control" id="full_dispatched_date2" name="full_dispatched_date2" type="date" value="{{old('full_dispatched_date2')}}">
                                </div>

                                <div id="otherFields2" style="display:none;">

                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                        <label for="machine_channel_received_date">Machine Channel Received Date:</label>
                                          <input class="form-control" id="machine_channel_received_date" name="machine_channel_received_date" type="date" value="{{old('machine_channel_received_date')}}">
                                           </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="form-group d-flex flex-column">
                                        <label>Machine Channel Dispatch Status</label>
                                        <select class="form-control select2" name="machine_channel_dispatch_status" id="machine_channel_dispatch_status">
                                            <option selected disabled>Select Machine Channel Dispatch Status</option>
                                            @if(isset($readinessstatus) && count($readinessstatus) > 0)
                                            @foreach($readinessstatus as $item)
                                            <option value="{{$item->id}}">{{$item->title}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                        <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                                  <div class="form-group dispatch_date1">
                                    <label for="machine_channel_dispatch_date">Machine Channel Dispatch Date:</label>
                                    <input class="form-control" id="machine_channel_dispatch_date" name="machine_channel_dispatch_date" type="date" value="{{old('machine_channel_dispatch_date')}}">
                                </div>
                                        </div>


                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="form-group dispatch_date1">
                                    <label for="machine_available_date">Machine Available Date:</label>
                                    <input class="form-control" id="machine_available_date" name="machine_available_date" type="date" value="{{old('machine_available_date')}}">
                                </div>
                                </div>

                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="form-group d-flex flex-column">
                                        <label>Machine Dispatch Status</label>
                                        <select class="form-control select2" name="machine_dispatch_status" id="machine_dispatch_status">
                                            <option selected disabled>Select Machine Dispatch Status</option>
                                            @if(isset($readinessstatus) && count($readinessstatus) > 0)
                                            @foreach($readinessstatus as $item)
                                            <option value="{{$item->id}}">{{$item->title}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                        <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                                    <div class="form-group dispatch_date1">
                                        <label for="machine_dispatch_date">Machine Dispatch Date:</label>
                                        <input class="form-control" id="machine_dispatch_date" name="machine_dispatch_date" type="date" value="{{old('machine_dispatch_date')}}">
                                    </div>
                                        </div>



                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="car_frame_received_date">Car Frame Received Date:</label>
                                        <input class="form-control" id="car_frame_received_date" name="car_frame_received_date" type="date" value="{{old('car_frame_received_date')}}">
                                    </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="form-group d-flex flex-column">
                                            <label>Car Frame Dispatch Status</label>
                                            <select class="form-control select2" name="car_frame_dispatch_status" id="car_frame_dispatch_status">
                                                <option selected disabled>Select Car Frame Dispatch Status</option>
                                                @if(isset($readinessstatus) && count($readinessstatus) > 0)
                                                    @foreach($readinessstatus as $item)
                                                        <option value="{{$item->id}}">{{$item->title}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                        <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                                    <div class="form-group dispatch_date2 ">
                                        <label for="car_frame_dispatch_date">Car Frame Dispatch Date:</label>
                                        <input class="form-control" id="car_frame_dispatch_date" name="car_frame_dispatch_date" type="date" value="{{old('car_frame_dispatch_date')}}">
                                    </div>
                                        </div>



                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="cwt_frame_received_date">Cwt Frame Received Date:</label>
                                        <input class="form-control" id="cwt_frame_received_date" name="cwt_frame_received_date" type="date" value="{{old('cwt_frame_received_date')}}">
                                    </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="form-group d-flex flex-column">
                                            <label>Cwt Frame Dispatch Status</label>
                                            <select class="form-control select2" name="cwt_frame_dispatch_status" id="cwt_frame_dispatch_status">
                                                <option selected disabled>Select Car Frame Dispatch Status</option>
                                                @if(isset($readinessstatus) && count($readinessstatus) > 0)
                                                    @foreach($readinessstatus as $item)
                                                        <option value="{{$item->id}}">{{$item->title}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                                    <div class="form-group dispatch_date2">
                                        <label for="cwt_frame_dispatch_date">Cwt Frame Dispatch Date:</label>
                                        <input class="form-control" id="cwt_frame_dispatch_date" name="cwt_frame_dispatch_date" type="date" value="{{old('cwt_frame_dispatch_date')}}">
                                    </div>
                                    </div>


                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="form-group dispatch_date1">
                                             <label for="rope_available_date">Rope Available Date:</label>
                                             <input class="form-control" id="rope_available_date" name="rope_available_date" type="date" value="{{old('rope_available_date')}}">
                                        </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="form-group d-flex flex-column">
                                            <label>Rope Dispatch Status</label>
                                            <select class="form-control select2" name="rope_dispatch_status" id="rope_dispatch_status">
                                                <option selected disabled>Select Rope Dispatch Status</option>
                                                @if(isset($readinessstatus) && count($readinessstatus) > 0)
                                                    @foreach($readinessstatus as $item)
                                                        <option value="{{$item->id}}">{{$item->title}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                      </div>

                                        <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                                        <div class="form-group dispatch_date1">
                                            <label for="rope_dispatch_date">Rope Dispatch Date:</label>
                                            <input class="form-control" id="rope_dispatch_date" name="rope_dispatch_date" type="date" value="{{old('rope_dispatch_date')}}">
                                        </div>
                                        </div>

                                    <div class="row col-md-12">
                                 <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="form-group dispatch_date1">
                                            <label for="osg_assy_available_date">OSG Assy Available Date:</label>
                                            <input class="form-control" id="osg_assy_available_date" name="osg_assy_available_date" type="date" value="{{old('osg_assy_available_date')}}">
                                        </div>
                                    </div>

                                 <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="form-group d-flex flex-column">
                                            <label>OSG Assy Dispatch Status</label>
                                            <select class="form-control select2" name="osg_assy_dispatch_status" id="osg_assy_dispatch_status">
                                                <option selected disabled>Select OSG Assy Dispatch Status</option>
                                                @if(isset($readinessstatus) && count($readinessstatus) > 0)
                                                    @foreach($readinessstatus as $item)
                                                        <option value="{{$item->id}}">{{$item->title}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                 <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                                        <div class="form-group dispatch_date1">
                                            <label for="osg_assy_dispatch_date">OSG Assy Dispatch Date:</label>
                                            <input class="form-control" id="osg_assy_dispatch_date" name="osg_assy_dispatch_date" type="date" value="{{old('osg_assy_dispatch_date')}}">
                                        </div>
                                    </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <hr style="clear: both;">
                        <button class="btn btn-secondary prev-step">Previous</button>
                        <button class="btn btn-primary next-step">Next</button>
                    </div>

                        <div class="tab-pane" id="step7">
                    <div class="box box-primary">
                        <div class="box-body">

                            <hr style="clear: both;">
                            <div class="form-group col-sm-12">
                                <label for=""> 3rd LOT Dispatch Details</label>
                            </div>
                            <hr style="clear: both;">

                            <div class="row">

                                <div class="form-group col-sm-12 ckeck1">
                                    <label for="myCheckbox">Full Dispatched:</label>
                                    <input type="checkbox" id="myCheckbox" onclick="toggleFields_three()" name="is_check" checked>
                                </div>

                                <div class="form-group fullDispatch3 col-sm-3" id="fullDispatchedDate3">
                                    <label for="full_dispatched_date3">Full Dispatched Date:</label>
                                    <input class="form-control" id="full_dispatched_date3" name="full_dispatched_date3" type="date" value="{{old('full_dispatched_date3')}}">
                                </div>
                            </div>

                            <div id="otherFields3">
                                <div class="row">

                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="cabin_received_date">Cabin Received Date:</label>
                                            <input class="form-control" id="cabin_received_date" name="cabin_received_date" type="date" value="{{old('cabin_received_date')}}">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="form-group d-flex flex-column">
                                            <label>Cabin Dispatch Status</label>
                                            <select class="form-control w-100 select2" name="cabin_dispatch_status" id="cabin_dispatch_status">
                                                <option selected disabled>Select Cabin Dispatch Status</option>
                                                @if(isset($readinessstatus) && count($readinessstatus) > 0)
                                                    @foreach($readinessstatus as $item)
                                                        <option value="{{$item->id}}">{{$item->title}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="form-group dispatch_date1">
                                            <label for="cabin_dispatch_date">Cabin Dispatch Date:</label>
                                            <input class="form-control" id="cabin_dispatch_date" name="cabin_dispatch_date" type="date" value="{{old('cabin_dispatch_date')}}">
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                   <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                       <div class="form-group dispatch_date1">
                                           <label for="controller_available_date">Controller Available Date:</label>
                                           <input class="form-control" id="controller_available_date" name="controller_available_date" type="date" value="{{old('controller_available_date')}}">
                                       </div>
                                   </div>

                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="form-group d-flex flex-column">
                                            <label>Controller Dispatch Status</label>
                                            <select class="form-control select2" name="controller_dispatch_status" id="controller_dispatch_status">
                                                <option selected disabled>Select Controller Dispatch Status</option>
                                                @if(isset($readinessstatus) && count($readinessstatus) > 0)
                                                    @foreach($readinessstatus as $item)
                                                        <option value="{{$item->id}}">{{$item->title}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="form-group dispatch_date1">
                                            <label for="controller_dispatch_date">Controller Dispatch Date:</label>
                                            <input class="form-control" id="controller_dispatch_date" name="controller_dispatch_date" type="date" value="{{old('controller_dispatch_date')}}">
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="car_door_received_date">Car Door Received Date:</label>
                                            <input class="form-control" id="car_door_received_date" name="car_door_received_date" type="date" value="{{old('car_door_received_date')}}">
                                        </div>
                                    </div>


                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="form-group d-flex flex-column">
                                            <label>Car Door Dispatch Status</label>
                                            <select class="form-control select2" name="car_door_dispatch_status" id="car_door_dispatch_status">
                                                <option selected disabled>Select Car Door Dispatch Status</option>
                                                @if(isset($readinessstatus) && count($readinessstatus) > 0)
                                                    @foreach($readinessstatus as $item)
                                                        <option value="{{$item->id}}">{{$item->title}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                <div class="form-group dispatch_date2">
                                                    <label for="car_door__dispatch_date">Car Door Dispatch Date:</label>
                                                    <input class="form-control" id="car_door__dispatch_date" name="car_door__dispatch_date" type="date" value="{{old('car_door__dispatch_date')}}">
                                                </div>
                                            </div>
                                          </div>


                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="cop_lop_received_date">Cop And Lop Received Date:</label>
                                                    <input class="form-control" id="cop_lop_received_date" name="cop_lop_received_date" type="date" value="{{old('cop_lop_received_date')}}">
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                <div class="form-group d-flex flex-column">
                                                    <label>Cop And Lop Dispatch Status</label>
                                                    <select class="form-control select2" name="cop_lop_dispatch_status" id="cop_lop_dispatch_status">
                                                        <option selected disabled>Select Cop And Lop Dispatch Status</option>
                                                        @if(isset($readinessstatus) && count($readinessstatus) > 0)
                                                            @foreach($readinessstatus as $item)
                                                                <option value="{{$item->id}}">{{$item->title}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                <div class="form-group dispatch_date2">
                                                    <label for="cop_lop__dispatch_date">Cop And Lop Dispatch Date:</label>
                                                    <input class="form-control" id="cop_lop__dispatch_date" name="cop_lop__dispatch_date" type="date" value="{{old('cop_lop__dispatch_date')}}">
                                                </div>
                                            </div>
                                        </div>

                                            <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                <div class="form-group dispatch_date1">
                                                    <label for="harness_available_date">Harness Available Date:</label>
                                                    <input class="form-control" id="harness_available_date" name="harness_available_date" type="date" value="{{old('harness_available_date')}}">
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                <div class="form-group d-flex flex-column">
                                                    <label>Harness Dispatch Status</label>
                                                    <select class="form-control select2" name="harness_dispatch_status" id="harness_dispatch_status">
                                                        <option selected disabled>Select Harness Dispatch Status</option>
                                                        @if(isset($readinessstatus) && count($readinessstatus) > 0)
                                                            @foreach($readinessstatus as $item)
                                                                <option value="{{$item->id}}">{{$item->title}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>

                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="form-group dispatch_date1">
                                            <label for="harness_dispatch_date"> Harness Dispatch Date:</label>
                                            <input class="form-control" id="harness_dispatch_date" name="harness_dispatch_date" type="date" value="{{old('harness_dispatch_date')}}">
                                        </div>
                                    </div>
                                            </div>

                            </div>
                        </div>
                    </div>
                    <hr style="clear: both;">
                          
                               <button class="btn btn-secondary prev-step">Previous</button>
                            <button type="submit" class="btn btn-primary float-right" name="final_submission"  value="1">Submit</button>
                       </div>

                    </div>

               </form>

    </div>



@endsection

@section('scripts')

<script type="application/javascript">
function getJobDetails() {
    var jobNoId = $('#job_no').val();

    if (jobNoId) {
        $.ajax({
            url: "{{ url('job_wise_production/job_details') }}" + '/' + jobNoId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#payment_received_manufacturing_date').val(response.payment_received_manufacturing_date);
                    $('#crm_confirmation_date').val(response.crm_confirmation_date);
                    $('#addressu').val(response.addressu);
                    $('#specifications').val(response.specifications);

                    $('#crm_id').val(response.crm_id).trigger('change');
                    $('#customer_id').val(response.customer_id).trigger('change');
                }
                else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('AJAX error: ' + error);
            }
        });
    }
}
</script>

<!--for select2 dropdown--->
<script type="application/javascript">
    $('.select2').select2({
        placeholder: 'Select an option',
        width: '100%'
    });
</script>

<script>
    function toggleFields() {
        var isChecked = document.getElementById('myCheck').checked;
        var fullDispatchDate = document.getElementById('fullDispatchedDate1');
        var otherFields = document.getElementById('otherFields1');

        if (isChecked) {
            fullDispatchDate.style.display = 'block';
            otherFields.style.display = 'none';
        }
        else
        {
            fullDispatchDate.style.display = 'none';
            otherFields.style.display = 'block';
        }
    }

    window.onload = function() {
        toggleFields();
    }
</script>

<script>
    function toggleFields_two() {
        var isChecked2 = document.getElementById('is_checkedbox').checked;
        var fullDispatchDate2 = document.getElementById('fullDispatchedDate2');
        var otherFieldstwo = document.getElementById('otherFields2');

        if (isChecked2) {
            fullDispatchDate2.style.display = 'block';
            otherFieldstwo.style.display = 'none';
        } else {
            fullDispatchDate2.style.display = 'none';
            otherFieldstwo.style.display = 'block';
        }
    }
    window.onload = function() {
        toggleFields_two();
    }
</script>

<script>
    function toggleFields_three() {
        var isChecked3 = document.getElementById('myCheckbox').checked;
        var fullDispatchDate3 = document.getElementById('fullDispatchedDate3');
        var otherFields3 = document.getElementById('otherFields3');

        if (isChecked3) {
            fullDispatchDate3.style.display = 'block';
            otherFields3.style.display = 'none';
        } else {

            fullDispatchDate3.style.display = 'none';
            otherFields3.style.display = 'block';
        }
    }
    window.onload = function() {
        toggleFields_three();
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {

        document.querySelectorAll(".next-step").forEach(button => {
            button.addEventListener("click", function (event) {
                event.preventDefault();

                let activeTabContent = document.querySelector(".tab-pane.active");
                let nextTabContent = activeTabContent.nextElementSibling;

                let activeTabLink = document.querySelector(".nav-tabs .active a");
                let nextTabLink = activeTabLink.parentElement.nextElementSibling.querySelector("a");

                if (nextTabContent && nextTabLink) {

                    $(activeTabContent).removeClass('active');
                    $(activeTabLink).parent().removeClass('active');

                    $(nextTabContent).addClass('active');
                    $(nextTabLink).parent().addClass('active');

                }
            });
        });

        document.querySelectorAll(".prev-step").forEach(button => {
            button.addEventListener("click", function (event) {
                event.preventDefault();

                let activeTabContent = document.querySelector(".tab-pane.active");
                let prevTabContent = activeTabContent.previousElementSibling;

                let activeTabLink = document.querySelector(".nav-tabs .active a");
                let prevTabLink = activeTabLink.parentElement.previousElementSibling.querySelector("a");

                if (prevTabContent && prevTabLink) {

                    $(activeTabContent).removeClass('active');
                    $(activeTabLink).parent().removeClass('active');

                    $(prevTabContent).addClass('active');
                    $(prevTabLink).parent().addClass('active');

                }
            });
        });

        document.querySelector(".submit-step").addEventListener("click", function () {
            document.querySelector("form").submit();
        });

    });
</script>

@endsection

