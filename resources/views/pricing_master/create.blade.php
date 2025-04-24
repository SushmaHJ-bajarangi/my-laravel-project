@extends('layouts.app')
@section('css')

@endsection
@section('content')
    <section class="content-header">
        <h1>
            Pricing Master
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <form method="post" id="calculation-form">
                        @csrf
                    <div class="form-group col-sm-12">
                        <label>Type of elevator:</label>
                        <div class="clearfix" style="display: flex;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="elevator_type" id="passenger_lift"
                                       value="passenger_lift" checked>
                                <label class="form-check-label" for="passenger_lift">
                                    Passenger Lift
                                </label>
                            </div>
                            <div class="form-check col-md-offset-1">
                                <input class="form-check-input" type="radio" name="elevator_type" id="goods_lift"
                                       value="goods_lift">
                                <label class="form-check-label" for="goods_lift">
                                    Goods Lift
                                </label>
                            </div>
                        </div>
                        <div class="passenger-lift-div">
                            <div class="form-group col-sm-6">
                                <label for="type_of_elevator_p">Type Of Elevator:</label>
                                <select class="form-control" name="type_of_elevator_p" id="type_of_elevator_p">
                                    <option value="MR">MR</option>
                                    <option value="MRL">MRL</option>
                                </select>
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="no_of_passengers">No of Passengers:</label>
                                <select class="form-control" name="no_of_passengers" onchange="countPassengerWeight()" id="no_of_passengers">
                                    <?php for($i=3;$i<=30;$i++){ ?>
                                    <option value="{{$i}}">{{$i}}</option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group col-sm-4">
                                <label for="capacity_in_kg_p">Capacity in Kgs.:</label>
                                <input class="form-control" id="capacity_in_kg_p" name="capacity_in_kg_p" readonly type="text">
                            </div>

                            <div class="form-group col-sm-4">
                                <label for="no_of_stops_p">No. of Stops:</label>
                                <select class="form-control" name="no_of_stops_p" id="no_of_stops_p">
                                    <?php for($i=2;$i<=20;$i++){ ?>
                                    <option value="{{$i}}">{{$i}}</option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group col-sm-4">
                                <label for="area_of_installation_p">Area of Installation :</label>
                                <select class="form-control" name="area_of_installation_p" id="area_of_installation_p">
                                    <option value="blr">BLR</option>
                                    <option value="<=100"><=100 kms from BLR</option>
                                    <option value=">>100 & <=200">>100 and <=200kms from BLR</option>
                                    <option value=">>200 & <=300">>>200 and <=300kms from BLR</option>
                                    <option value=">300">>300 Kms from BLR </option>
                                </select>
                            </div>
                        </div>
                        <div class="goods-lift-div hidden">
                            <div class="form-group col-sm-6">
                                <label for="type_of_elevator_g">Type Of Elevator:</label>
                                <select class="form-control" name="type_of_elevator_g" id="type_of_elevator_g">
                                    <option value="MR">MR</option>
                                    <option value="MRL">MRL</option>
                                    <option value="Hydraulic">Hydraulic</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="capacity_in_kg_g">Capacity in kgs.</label>
                                <select class="form-control" name="capacity_in_kg_g" id="capacity_in_kg_g">
                                    <option value="500">500 kgs. (0.5 Tons)</option>
                                    <option value="1000">1000 kgs. (1 Ton)</option>
                                    <option value="1500">1500 kgs. (1.5 Tons)</option>
                                    <option value="2000">2000 kgs. (2 Tons)</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="no_of_stops_g">No. of Stops:</label>
                                <select class="form-control" name="no_of_stops_g" id="no_of_stops_g">
                                    <?php for($i=2;$i<=20;$i++){ ?>
                                    <option value="{{$i}}">{{$i}}</option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="area_of_installation_g">Area of Installation :</label>
                                <select class="form-control" name="area_of_installation_g" id="area_of_installation_g">
                                    <option value="blr">BLR</option>
                                    <option value="<=100"><=100 kms from BLR</option>
                                    <option value=">>100 & <=200">>100 and <=200kms from BLR</option>
                                    <option value=">>200 & <=300">>>200 and <=300kms from BLR</option>
                                    <option value=">300">>300 Kms from BLR </option>
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="basic_price">Basic price of previous year :</label>
                        <input class="form-control" id="basic_price" name="basic_price" type="number">
                    </div>
                        <div class="form-group col-sm-6">
                            <button type="button" onclick="calculatePrice()" class="btn btn-primary">Calculate</button>
                            <button type="button" id="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ url('pricing_master') }}" class="btn btn-default">Cancel</a>
                        </div>
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table pricing-master table-bordered">
                                <tbody>
                                <tr>
                                    <td colspan="2" class="text-bold">SILVER CARE AMC </td>
                                    <td colspan="2" class="text-bold">BIENNIAL SILVER CARE </td>
                                    <td colspan="2" class="text-bold">TRIENNIAL SILVER CARE</td>
                                    <td colspan="2" class="text-bold">QUINQUENNIAL SILVER CARE (5 Years)</td>
                                </tr>
                                <tr>
                                    <td>Basic Price  For 1 Year </td>
                                    <td class="b9">₹ 0</td>
                                    <input type="hidden" id="silver_care_amc_1_year" name="silver_care_amc_1_year">
                                    <td>Basic Price  For 2 Years</td>
                                    <td class="d9">₹ 0</td>
                                    <input type="hidden" id="biennial_silver_care_2_year" name="biennial_silver_care_2_year">
                                    <td>Basic Price  For 3 Years</td>
                                    <td class="f9">₹ 0</td>
                                    <input type="hidden" name="triennial_silver_care_3_year" id="triennial_silver_care_3_year">
                                    <td>Basic Price  For 5 Years</td>
                                    <td class="h9">₹ 0</td>
                                    <input type="hidden" name="quinquennial_silver_care_5_year" id="quinquennial_silver_care_5_year">
                                </tr>
                                <tr>
                                    <td>Final Offer Price  @18% GST  for 1 Year</td>
                                    <td class="b10">₹ 0</td>
                                    <input type="hidden" name="silver_care_amc_gst" id="silver_care_amc_gst">
                                    <td>Final Offer Price  @18% GST  for 2 Years</td>
                                    <td class="d10">₹ 0</td>
                                    <input type="hidden" name="biennial_silver_care_gst" id="biennial_silver_care_gst">
                                    <td>Final Offer Price  @18% GST  for 3 Years</td>
                                    <td class="f10">₹ 0</td>
                                    <input type="hidden" name="triennial_silver_care_gst" id="triennial_silver_care_gst">
                                    <td>Final Offer Price  @18% GST  for 5 Years</td>
                                    <td class="h10">₹ 0</td>
                                    <input type="hidden" name="quinquennial_silver_care_gst" id="quinquennial_silver_care_gst">
                                </tr>
                                <tr>
                                    <td>FINAL DISCOUNTED PRICE @18% GST</td>
                                    <td class="b11">₹ 0</td>
                                    <input type="hidden" name="silver_care_amc_discounted" id="silver_care_amc_discounted">
                                    <td>FINAL DISCOUNTED PRICE @18% GST</td>
                                    <td class="d11">₹ 0</td>
                                    <input type="hidden" name="biennial_silver_care_discounted" id="biennial_silver_care_discounted">
                                    <td>FINAL DISCOUNTED PRICE @18% GST</td>
                                    <td class="f11">₹ 0</td>
                                    <input type="hidden" name="triennial_silver_care_discounted" id="triennial_silver_care_discounted">
                                    <td>FINAL DISCOUNTED PRICE @18% GST</td>
                                    <td class="h11">₹ 0</td>
                                    <input type="hidden" name="quinquennial_silver_care_discounted" id="quinquennial_silver_care_discounted">
                                </tr>
                                <tr style="height: 15px;"><td colspan="8">&nbsp;</td></tr>

                                <tr>
                                    <td colspan="2" class="text-bold">GOLD CARE AMC </td>
                                    <td colspan="2" class="text-bold">BIENNIAL GOLD CARE AMC</td>
                                    <td colspan="2" class="text-bold">TRIENNIAL GOLD CARE AMC</td>
                                    <td colspan="2" class="text-bold">QUINQUENNIAL GOLD CARE (5 Years)</td>
                                </tr>
                                <tr>
                                    <td>Basic Price For 1 Year</td>
                                    <td class="b13">₹ 0</td>
                                    <input type="hidden" name="gold_care_amc_1_year" id="gold_care_amc_1_year">
                                    <td>Basic Price  For 2 Years</td>
                                    <td class="d13">₹ 0</td>
                                    <input type="hidden" name="biennial_gold_care_amc_2_year" id="biennial_gold_care_amc_2_year">
                                    <td>Basic Price  For 3 Years</td>
                                    <td class="f13">₹ 0</td>
                                    <input type="hidden" name="triennial_gold_care_amc_3_year" id="triennial_gold_care_amc_3_year">
                                    <td>Basic Price  For 5 Years</td>
                                    <td class="h13">₹ 0</td>
                                    <input type="hidden" name="quinquennial_gold_care_amc_5_year" id="quinquennial_gold_care_amc_5_year">
                                </tr>
                                <tr>
                                    <td>Final Offer Price  @18% GST for 1 Year</td>
                                    <td class="b14">₹ 0</td>
                                    <input type="hidden" name="gold_care_amc_gst" id="gold_care_amc_gst">
                                    <td>Final Offer Price  @18% GST  for 2 Years</td>
                                    <td class="d14">₹ 0</td>
                                    <input type="hidden" name="biennial_gold_care_amc_gst" id="biennial_gold_care_amc_gst">
                                    <td>Final Offer Price  @18% GST  for 3 Years</td>
                                    <td class="f14">₹ 0</td>
                                    <input type="hidden" name="triennial_gold_care_amc_gst" id="triennial_gold_care_amc_gst">
                                    <td>Final Offer Price  @18% GST  for 5 Years</td>
                                    <td class="h14">₹ 0</td>
                                    <input type="hidden" name="quinquennial_gold_care_amc_gst" id="quinquennial_gold_care_amc_gst">
                                </tr>
                                <tr>
                                    <td>FINAL DISCOUNTED PRICE @18% GST</td>
                                    <td class="b15">₹ 0</td>
                                    <input type="hidden" name="gold_care_amc_discounted" id="gold_care_amc_discounted">
                                    <td>FINAL DISCOUNTED PRICE @18% GST</td>
                                    <td class="d15">₹ 0</td>
                                    <input type="hidden" name="biennial_gold_care_amc_discounted" id="biennial_gold_care_amc_discounted">
                                    <td>FINAL DISCOUNTED PRICE @18% GST</td>
                                    <td class="f15">₹ 0</td>
                                    <input type="hidden" name="triennial_gold_care_amc_discounted" id="triennial_gold_care_amc_discounted">
                                    <td>FINAL DISCOUNTED PRICE @18% GST</td>
                                    <td class="h15">₹ 0</td>
                                    <input type="hidden" name="quinquennial_gold_care_amc_discounted" id="quinquennial_gold_care_amc_discounted">
                                </tr>

                                <tr style="height: 15px;"><td colspan="8">&nbsp;</td></tr>
                                <tr>
                                    <td colspan="2" class="text-bold">PLATINUM CARE AMC</td>
                                    <td colspan="2" class="text-bold">BIENNIAL PLATINUM CARE AMC</td>
                                    <td colspan="2" class="text-bold">TRIENNIAL PLATINUM CARE AMC</td>
                                    <td colspan="2" class="text-bold">QUINQUENNIAL PLATINUM CARE (5 Years)</td>
                                </tr>
                                <tr>
                                    <td>Basic Price For 1 Year </td>
                                    <td class="b17">₹ 0</td>
                                    <input type="hidden" name="platinum_care_amc_1_year" id="platinum_care_amc_1_year">
                                    <td>Basic Price  For 2 Years</td>
                                    <td class="d17">₹ 0</td>
                                    <input type="hidden" name="biennial_platinum_care_amc_2_year" id="biennial_platinum_care_amc_2_year">
                                    <td>Basic Price  For 3 Years</td>
                                    <td class="f17">₹ 0</td>
                                    <input type="hidden" name="triennial_platinum_care_amc_3_year" id="triennial_platinum_care_amc_3_year">
                                    <td>Basic Price  For 5 Years</td>
                                    <td class="h17">₹ 0</td>
                                    <input type="hidden" name="quinquennial_platinum_care_amc_5_year" id="quinquennial_platinum_care_amc_5_year">
                                </tr>
                                <tr>
                                    <td>Final Price  @18% GST for 1 Year</td>
                                    <td class="b18">₹ 0</td>
                                    <input type="hidden" name="platinum_care_amc_gst" id="platinum_care_amc_gst">
                                    <td>Final Price  @18% GST  for 2 Years</td>
                                    <td class="d18">₹ 0</td>
                                    <input type="hidden" name="biennial_platinum_care_gst" id="biennial_platinum_care_gst">
                                    <td>Final Price  @18% GST  for 3 Years</td>
                                    <td class="f18">₹ 0</td>
                                    <input type="hidden" name="triennial_platinum_care_gst" id="triennial_platinum_care_gst">
                                    <td>Final Price  @18% GST  for 5 Years</td>
                                    <td class="h18">₹ 0</td>
                                    <input type="hidden" name="quinquennial_platinum_care_gst" id="quinquennial_platinum_care_gst">
                                </tr>
                                <tr>
                                    <td>FINAL DISCOUNTED PRICE @18% GST</td>
                                    <td class="b19">₹ 0</td>
                                    <input type="hidden" name="platinum_care_amc_discounted" id="platinum_care_amc_discounted">
                                    <td>FINAL DISCOUNTED PRICE @18% GST</td>
                                    <td class="d19">₹ 0</td>
                                    <input type="hidden" name="biennial_platinum_care_amc_discounted" id="biennial_platinum_care_amc_discounted">
                                    <td>FINAL DISCOUNTED PRICE @18% GST</td>
                                    <td class="f19">₹ 0</td>
                                    <input type="hidden" name="triennial_platinum_care_amc_discounted" id="triennial_platinum_care_amc_discounted">
                                    <td>FINAL DISCOUNTED PRICE @18% GST</td>
                                    <td class="h19">₹ 0</td>
                                    <input type="hidden" name="quinquennial_platinum_care_amc_discounted" id="quinquennial_platinum_care_amc_discounted">
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script>
        $('input[type=radio][name=elevator_type]').change(function() {
            if (this.value == 'passenger_lift') {
                $('.passenger-lift-div').removeClass('hidden');
                $('.goods-lift-div').addClass('hidden');
            }else if (this.value == 'goods_lift') {
                $('.goods-lift-div').removeClass('hidden');
                $('.passenger-lift-div').addClass('hidden');
            }
        });

        function countPassengerWeight(){
            var total_passenger = $('#no_of_passengers').val();
            var total = 68 * total_passenger;
            $('#capacity_in_kg_p').val(total);
        }

        function calculatePrice(){
            let form = $('#calculation-form')[0];
            var formData = new FormData(form);
            var basic_price = $('#basic_price').val();
            formData.append("basic_price", basic_price);

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")
                }
            });

            $.ajax({
                url: "{{ url('/calculate_price') }}",
                type: 'POST',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function (response) {
                    if (response.success === true) {
                        $('.b9').text('₹' +response.data['passenger_b_9']);
                        $('#silver_care_amc_1_year').val(response.data['passenger_b_9']);
                        $('.b10').text('₹' +response.data['passenger_b_10']);
                        $('#silver_care_amc_gst').val(response.data['passenger_b_10']);
                        $('.b11').text('₹' +response.data['passenger_b_11']);
                        $('#silver_care_amc_discounted').val(response.data['passenger_b_11']);
                        $('.b14').text('₹' +response.data['passenger_b_14']);
                        $('#gold_care_amc_gst').val(response.data['passenger_b_14']);
                        $('.b13').text('₹' +response.data['passenger_b_13']);
                        $('#gold_care_amc_1_year').val(response.data['passenger_b_13']);
                        $('.b15').text('₹' +response.data['passenger_b_15']);
                        $('#gold_care_amc_discounted').val(response.data['passenger_b_15']);
                        $('.b18').text('₹' +response.data['passenger_b_18']);
                        $('#platinum_care_amc_gst').val(response.data['passenger_b_18']);
                        $('.b17').text('₹' +response.data['passenger_b_17']);
                        $('#platinum_care_amc_1_year').val(response.data['passenger_b_17']);
                        $('.b19').text('₹' +response.data['passenger_b_19']);
                        $('#platinum_care_amc_discounted').val(response.data['passenger_b_19']);
                        $('.d9').text('₹' +response.data['passenger_d_9']);
                        $('#biennial_silver_care_2_year').val(response.data['passenger_d_9']);
                        $('.d10').text('₹' +response.data['passenger_d_10']);
                        $('#biennial_silver_care_gst').val(response.data['passenger_d_10']);
                        $('.d11').text('₹' +response.data['passenger_d_11']);
                        $('#biennial_silver_care_discounted').val(response.data['passenger_d_11']);
                        $('.d13').text('₹' +response.data['passenger_d_13']);
                        $('#biennial_gold_care_amc_2_year').val(response.data['passenger_d_13']);
                        $('.d14').text('₹' +response.data['passenger_d_14']);
                        $('#biennial_gold_care_amc_gst').val(response.data['passenger_d_14']);
                        $('.d15').text('₹' +response.data['passenger_d_15']);
                        $('#biennial_gold_care_amc_discounted').val(response.data['passenger_d_15']);
                        $('.d17').text('₹' +response.data['passenger_d_17']);
                        $('#biennial_platinum_care_amc_2_year').val(response.data['passenger_d_17']);
                        $('.d18').text('₹' +response.data['passenger_d_18']);
                        $('#biennial_platinum_care_gst').val(response.data['passenger_d_18']);
                        $('.d19').text('₹' +response.data['passenger_d_19']);
                        $('#biennial_platinum_care_amc_discounted').val(response.data['passenger_d_19']);
                        $('.f9').text('₹' +response.data['passenger_f_9']);
                        $('#triennial_silver_care_3_year').val(response.data['passenger_f_9']);
                        $('.f10').text('₹' +response.data['passenger_f_10']);
                        $('#triennial_silver_care_gst').val(response.data['passenger_f_10']);
                        $('.f11').text('₹' +response.data['passenger_f_11']);
                        $('#triennial_silver_care_discounted').val(response.data['passenger_f_11']);
                        $('.f13').text('₹' +response.data['passenger_f_13']);
                        $('#triennial_gold_care_amc_3_year').val(response.data['passenger_f_13']);
                        $('.f14').text('₹' +response.data['passenger_f_14']);
                        $('#triennial_gold_care_amc_gst').val(response.data['passenger_f_14']);
                        $('.f15').text('₹' +response.data['passenger_f_15']);
                        $('#triennial_gold_care_amc_discounted').val(response.data['passenger_f_15']);
                        $('.f17').text('₹' +response.data['passenger_f_17']);
                        $('#triennial_platinum_care_amc_3_year').val(response.data['passenger_f_17']);
                        $('.f18').text('₹' +response.data['passenger_f_18']);
                        $('#triennial_platinum_care_gst').val(response.data['passenger_f_18']);
                        $('.f19').text('₹' +response.data['passenger_f_19']);
                        $('#triennial_platinum_care_amc_discounted').val(response.data['passenger_f_19']);
                        $('.h9').text('₹' +response.data['passenger_h_9']);
                        $('#quinquennial_silver_care_5_year').val(response.data['passenger_h_9']);
                        $('.h10').text('₹' +response.data['passenger_h_10']);
                        $('#quinquennial_silver_care_gst').val(response.data['passenger_h_10']);
                        $('.h11').text('₹' +response.data['passenger_h_11']);
                        $('#quinquennial_silver_care_discounted').val(response.data['passenger_h_11']);
                        $('.h13').text('₹' +response.data['passenger_h_13']);
                        $('#quinquennial_gold_care_amc_5_year').val(response.data['passenger_h_13']);
                        $('.h14').text('₹' +response.data['passenger_h_14']);
                        $('#quinquennial_gold_care_amc_gst').val(response.data['passenger_h_14']);
                        $('.h15').text('₹' +response.data['passenger_h_15']);
                        $('#quinquennial_gold_care_amc_discounted').val(response.data['passenger_h_15']);
                        $('.h17').text('₹' +response.data['passenger_h_17']);
                        $('#quinquennial_platinum_care_amc_5_year').val(response.data['passenger_h_17']);
                        $('.h18').text('₹' +response.data['passenger_h_18']);
                        $('#quinquennial_platinum_care_gst').val(response.data['passenger_h_18']);
                        $('.h19').text('₹' +response.data['passenger_h_19']);
                        $('#quinquennial_platinum_care_amc_discounted').val(response.data['passenger_h_19']);
                    }
                }
            });
        }


        $('#submit').click(function(e){
            e.preventDefault();
            let form = $('#calculation-form')[0];
            let data = new FormData(form);
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")
                }
            });
            $.ajax({
                url: "{{ url('/store_calculation') }}",
                data: data,
                type: "POST",
                dataType:"JSON",
                processData : false,
                contentType:false,
                success: function (response) {
                    if (response.errors) {
                        var errorMsg = '';
                        $.each(response.errors, function(field, errors) {
                            $.each(errors, function(index, error) {
                                errorMsg += error + '<br>';
                            });
                        });
                        toastr.options =
                            {
                                "closeButton": true,
                                "progressBar": true
                            };
                        toastr.error(errorMsg);

                    } else {
                        toastr.options =
                            {
                                "closeButton": true,
                                "progressBar": true
                            };
                        toastr.success(response.message);
                    }

                },error: function(xhr, status, error) {
                    toastr.options =
                        {
                            "closeButton": true,
                            "progressBar": true
                        };
                    toastr.error('Something went wrong');
                }
            });
        });

    </script>

@endsection