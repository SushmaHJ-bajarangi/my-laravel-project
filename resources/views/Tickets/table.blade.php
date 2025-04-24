@extends('layouts.app')
@section('css')
    <style>
        .signature_image
        {
            height: 100px;
            width: 100px;
        }
        .select2-container {
            min-width: 400px;
        }

        .select2-results__option {
            padding-right: 20px;
            vertical-align: middle;
        }
        .select2-results__option:before {
            content: "";
            display: inline-block;
            position: relative;
            height: 20px;
            width: 20px;
            border: 2px solid #e9e9e9;
            border-radius: 4px;
            background-color: #fff;
            margin-right: 20px;
            vertical-align: middle;
        }
        .select2-results__option[aria-selected=true]:before {
            font-family:fontAwesome;
            content: "\f00c";
            color: #fff;
            background-color: #f77750;
            border: 0;
            display: inline-block;
            padding-left: 3px;
        }
        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #fff;
        }
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #eaeaeb;
            color: #272727;
        }
        .select2-container--default .select2-selection--multiple {
            margin-bottom: 10px;
        }
        .select2-container--default.select2-container--open.select2-container--below .select2-selection--multiple {
            border-radius: 4px;
        }
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: #f77750;
            border-width: 2px;
        }
        .select2-container--default .select2-selection--multiple {
            border-width: 2px;
        }
        .select2-container--open .select2-dropdown--below {

            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);

        }
        .select2-selection .select2-selection--multiple:after {
            content: 'hhghgh';
        }
        /* select with icons badges single*/
        .select-icon .select2-selection__placeholder .badge {
            display: none;
        }
        .select-icon .placeholder {
            /* 	display: none; */
        }
        .select-icon .select2-results__option:before,
        .select-icon .select2-results__option[aria-selected=true]:before {
            display: none !important;
            /* content: "" !important; */
        }
        .select-icon  .select2-search--dropdown {
            display: none;
        }
        .input_filed
        {
            height:35px;
            width:50px;
            text-align: right;

        }
        input[type=number]::-webkit-inner-spin-button, input[type=number]::-webkit-outer-spin-button
        {
            visibility: hidden;
        }
        .minus, .plus{
            width:35px;
            height:35px;
            background:#f2f2f2;
            border-radius:4px;
            padding:8px 5px 8px 5px;
            border:1px solid #ddd;
            display: inline-block;
            vertical-align: middle;
            text-align: center;
        }
        .header_item{
            height:30px;
            width: 70px;
            /*text-align: center;*/
            font-size: 12px;
            border:1px solid #ddd;
            border-radius:4px;
            display: inline-block;
            vertical-align: middle;
        }
    </style>
@endsection
@section('content')
    <section class="content-header">
        <h1 class="pull-left">Raise Tickets</h1>
        <h1 class="pull-right">
            <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{{ url('createTicket') }}">Add New</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <div class='table-responsive' id="table_assign">
                    <table class="table table-bordered " id="example">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Unique Job Number</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>zone</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Assigned To</th>
                            <th>Parts</th>
                            <th>Cancel</th>
                            <th>Ticket Status</th>
                            <th>Ticket Punches</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tickets as $key=>$item)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$item->unique_job_number}}</td>
                                <td>{{$item->title}}</td>
                                <td>{{$item->description}}</td>
                                @if($item->signature_image =='')
                                    <td><img class="signature_image" src="{{asset('images/no_img.png')}}"></td>
                                @else
                                    <td><img class="signature_image" src="{{asset('signature/'.$item->signature_image)}}"></td>
                                @endif
                                <td>{{$item->zone}}</td>
                                <td>{{$item->date}}</td>
                                <td>{{$item->status}}</td>
                                @if(empty($item->assigned_to) || $item->assigned_to =='')
                                    <td><button class="btn btn-info" data-toggle="modal" data-target="#assignedTeam" onclick="assignedTeam({{$item->id}})" >Assigned to</button></td>
                                @else
                                    <td><button class="btn btn-success" data-toggle="modal" data-target="#forwardTeam" onclick="forwardTeam('{{$item->id}}','{{$item->assigned_to}}')">Forward</button></td>
                                @endif
                                <td><button class="btn btn-warning" data-toggle="modal" data-target="#myModal" onclick="openParts({{$item->id}})"  >Parts Purchase</button></td>
                                <td><button class="btn btn-danger" onclick="removeTicket({{$item->id}})">Cancel</button></td>
                                <td><button class="btn btn-info" onclick="ticketStatus({{$item->id}})">View</button></td>
                                <td><button class="btn btn-info" onclick="ticketPunches({{$item->id}})">Punches</button></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Parts</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" id="target" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="ticket_id">
                        <input type="hidden" id="parts_id">
                        <input type="hidden" id="input_data">
                        <select  class="js-select2" multiple="multiple" name="parts[]" autofocus   class="form-control select_parts"  id="parts">
                            <?php
                            $parts_details = App\Models\partDetails::where('is_deleted',0)->get();
                            if(isset($parts_details) && count($parts_details) > 0){
                                foreach($parts_details as $item) {
                                    $part_name = App\Models\parts::where('id',$item->part_id)->where('is_deleted',0)->first();
                                    echo '<option  type="hidden" value="'.$part_name->title.'='.$item->id.'='.$item->description.'='.$item->price.'='.$part_name->GST.'">'.$part_name->title.' '.$item->description.','.$item->price.'</option>';
                                }
                            }
                            ?>
                        </select>
                        <div class='table-responsive'>
                            <table class='table table-bordered'>
                                <thead>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                </thead>
                                <tbody id="parts_detials">
                                <tr>
                                    <td class="cards_total" type="hidden"></td>
                                    <td class="gst_total" type="hidden"></td>
                                </tr>
                                <input type="hidden" name="parts" id="parts_price">
                                </tbody>
                            </table>

                            <div class='col-md-6'></div>
                            <div class='card parts_requests col-md-6'>
                                <div class='col-md-6'>
                                    <h5>CGST</h5>
                                </div>
                                <div class='col-md-6'>
                                    <h5 id="cgst"> ₹</h5>
                                </div>
                                <br>
                                <div class='col-md-6'>
                                    <h5> SGST</h5>
                                </div>
                                <div class='col-md-6'>
                                    <h5 id="sgst"> ₹</h5>
                                </div>
                                <hr>
                                <div class='col-md-6'>
                                    <h4 >Total</h4>
                                </div>
                                <div class='col-md-6'>
                                    <h5 id="price" class="price">Rs</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4"></div>
                        <div class="modal-footer">
                            <input type='submit' class='btn btn-primary'>
                            <a href="{{url('tickets')}}"><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="assignedTeam" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Assigned Team</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="POST" id="assigneddata" >
                        @csrf
                        <input type = 'hidden' id="ticket_id" value=""  name="ticket_id" class="form-control"  />
                        <div class="form-group">
                            <label class="control-label col-sm-4">Select Team:</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="myselect">
                                </select>
                            </div>
                        </div>
                        <label class="control-label col-sm-4">Is Urgent ?:</label>
                        <input type="radio" name="urgent" value="yes">
                        <lable>Yes</lable>
                        <input type="radio"  name="urgent" value="no" checked>
                        <lable>No</lable>
                        <div class="modal-footer">
                            <button  class="btn btn-success">Submit</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="forwardTeam" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Forward Team</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="POST" id="forwardticket" >
                        @csrf
                        <input type = 'hidden' id="forward_ticket_id" value=""  name="forward_ticket_id" class="form-control"  />
                        <div class="form-group">
                            <label class="control-label col-sm-4">Select Team:</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="forwardTeamdata">
                                </select>
                            </div>
                        </div>
                        <label class="control-label col-sm-4">Is Urgent ?:</label>
                        <input type="radio" name="urgent" value="yes">
                        <lable>Yes</lable>
                        <input type="radio"  name="urgent" value="no" checked>
                        <lable>No</lable>
                        <div class="modal-footer">
                            <button  class="btn btn-success">Submit</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ticketStatus" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Ticket Status</h4>
                </div>
                <div class="modal-body">
                    <div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Reason</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ticketPunches" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Ticket Punches</h4>
                </div>
                <div class="modal-body">
                    <div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th>Distance</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="GST" value="">
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).on( 'click', '.minus', function () {
            var $input = $(this).parent().find('input');
            console.log($input);
            var count = parseInt($input.val()) - 1;
            count = count < 1 ? 1 : count;
            $input.val(count);
            $input.change();
            var titles = $('input[name^=quantity]').map(function (idx, elem) {
                return $(elem).val();
            }).get();
            var gst_price=0;
            $.each(titles, function (key, val) {
                var final_price = $('#original_price_' + key + '').val();
                var each_price = final_price * val;
                var plus_price = $('#price_' + key + '').text(each_price);
                gst_price += parseInt($('#original_price_' + key + '').val())*val;
                gst_cal=(gst_price*$('#GST' + key + '').val())/100;
            });
            var cgst=$('#cgst').text(gst_cal+' '+'INR');
            var sgst=$('#sgst').text(gst_cal+' '+'INR');
            var price =2*parseInt(gst_cal)+gst_price;
            $('#price').text(price+' '+'INR');

        });
        $(document).on('click', '.plus', function () {
            var $input = $(this).parent().find('input');
            $input.val(parseInt($input.val()) + 1);
            $input.change();
            var titles = $('input[name^=quantity]').map(function (idx, elem) {
                return $(elem).val();
            }).get();
            var gst_price=0;
            var gst_cal = 0;
            $.each(titles, function (key, val) {
                var final_price = $('#original_price_' + key + '').val();
                var each_price = final_price * val;
                var plus_price = $('#price_' + key + '').text(each_price);
                gst_price += parseInt($('#original_price_' + key + '').val())*val;
                gst_cal=(gst_price*$('#GST' + key + '').val())/100;
            });
            var cgst=$('#cgst').text(gst_cal+' '+'INR');
            var sgst=$('#sgst').text(gst_cal+' '+'INR');
            var price =2*parseInt(gst_cal)+gst_price;
            $('#price').text(price+' '+'INR');
            return false;
        });
        function openParts(id){
            var ticket_id =$('#ticket_id').val(id);
            var final_data1=[];
            $('#parts').change(function() {
                var final_data=$('#parts').val();
                var final_data1 = final_data.toString().split(',');
                var final_amount=0;
                var html = '';
                var sum =0;
                var parts_id =[];


                for(var i=0; i<final_data1.length; i++)
                {
                    var final_array=final_data1[i].split('=');
                    if(final_array != '')
                    {

                        parts_id.push(final_array[1].toString());
                        sum +=parseInt(final_array[3]);
                        html+='<tr>';
                        html+='<td>' + final_array[0] + '</td>' +
                            '<td>' + final_array[2] + '</td>' +
                            '<input type="hidden" id="original_price_'+i+'" value="'+final_array[3]+'">'+
                            '<input type="hidden" id="GST'+i+'" value="'+final_array[4]+'">'+
                            '<td>'+'<div class="number">'+
                            '<span class="minus">-</span>'+
                            '<input type="number" id="quantity_'+i+'" name="quantity[]" readonly value="1"/>'+
                            '<span class="plus" data-id="'+i+'">+</span>'+
                            '</div>'+'</td>' +
                            '<td class="match_total" id="price_'+i+'">' + final_array[3] + '</td>';
                        html+='</tr>';
                    }
                    else
                    {
                        parts_id ='';
                        sum +=parseInt(final_array[3]);
                        html+='<tr>';
                        html+='<center>'+'<td colspan="3">' + 'No Parts Data'+ '</td>'+'</center>';
                        html+='</tr>';
                    }
                }


                $('#parts_detials').html(html);
                $('#price').html((sum*final_array[4]/100)+sum+' '+'INR');
                $('#price').val((sum*final_array[4]/100)+sum);
                $('#cgst').html(sum*final_array[4]/100+' '+'INR');
                $('#sgst').html(sum*final_array[4]/100+' '+'INR');
                $('#parts_id').val(parts_id.join(','));


            });
            $( "#target" ).submit(function() {
            event.preventDefault();
            var titles = $('input[name^=quantity]').map(function(idx, elem) {
                return $(elem).val();
            }).get();
                var quantity=titles.join(',');
                $.ajax({
                url: '{{url('storeParts')}}',
                method:"POST",
                data: {'ticket_id': id, "_token": "{{ csrf_token() }}",parts_id:$('#parts_id').val(),amt:$('#price').val(),'quantity':quantity},
                success: function (res) {
                toastr.clear();
                toastr.success('Parts added successfully ' ,{timeOut: 3000});
                window.location.reload();

                },
                    error:function(e)
                {
                    toastr.clear();
                    toastr.warning('Please select any parts', {timeOut: 3000});
                }
            });
        });
        }
        function assignedTeam(id) {
            $.ajax({
                url: '{{url('getTechnicianTeam')}}',
                method: "GET",
                success: function (res) {
                    var opts='<option selected disabled>select technician here</option>';
                    $.each(res, function (key, val) {
                        opts += "<option value='"+val.id+"' >"+val.name+' '+val.zone_name+' '+val.title+"</option>";
                    });
                    $("#myselect").html(opts);
                    $('#ticket_id').val(id);
                },
                error: function (e) {
//                    toastr.clear();
//                   clear toastr.warning('Please select any parts', {timeOut: 3000});
                }
            });
        }
        function forwardTeam(id,team_id) {
            $.ajax({
                url: '{{url('getTechnicianTeamforward')}}',
                method: "GET",
                success: function (res) {
                    var opts='<option selected disabled>select technician here</option>';
                    $.each(res, function (key, val) {
                        if(team_id == val.id)
                        {
                            opts += "<option value='"+val.id+"' selected>"+val.name+' '+val.zone_name+' '+val.title+"</option>";
                        }
                        else {
                            opts += "<option value='"+val.id+"' >"+val.name+' '+val.zone_name+' '+val.title+"</option>";
                        }

                    });
                    $("#forwardTeamdata").html(opts);
                    $('#forward_ticket_id').val(id);
                },
                error: function (e) {
                }
            });
        }
        $(document).ready( function () {
            function submitService(id) {
                var customer_id = $('#customer_id_' + id).val();
                var date = $('#date_' + id).val();
                var customer_unique_job_number = $('#customer_unique_job_number_' + id).val();
                var assign_team_id = $('#assign_team_id_' + id).val();
                if (assign_team_id == null) {
                    toastr.clear();
                    toastr.error('Assign Team Leader');
                }
                else {
                    $('#postService_' + id).submit();
                }
            }
            $("#table").on("click", "#assign", function(ev) {
                const $row = $(this).closest("tr");
                $row.siblings().removeClass("rowcolorbg"); // Other <tbody> TR elements
                $row.addClass("rowcolorbg");
            });
            $(".table").on("click", "#forward", function(ev) {
                const $row = $(this).closest("tr");
                $row.siblings().removeClass("rowcolorbg"); // Other <tbody> TR elements
                $row.addClass("rowcolorbg");
            });
            function cancelsubmit(id){
                $("#cancel").attr("disabled", true);

                var assigned_to = $('#assigned_to').val();
                $.ajax({
                    url: "{{ url('getData') }}",
                    type: "POST",
                    data: {'id':id,'_token':'{{csrf_token()}}',
                        assigned_to:assigned_to,
                    },
                    success: function(data)
                    {
                        window.location.reload()
                    }
                });
            }
            function partssubmit(id){
                var title = $('#select2').val();

                if(title == null){
                    toastr.clear();
                    toastr.error('Field  Required');
                }
            }
            $(".js-select2").select2({
                closeOnSelect : false,
                placeholder : "Select parts ..",
                // allowHtml: true,
                allowClear: true,
                tags: true // создает новые опции на лету
            });
            $('#example thead tr')
                .clone(true)
                .addClass('filters')
                .appendTo('#example thead');

            var table = $('#example').DataTable({
                orderCellsTop: true,
                fixedHeader: true,
                initComplete: function () {
                    var api = this.api();

                    // For each column
                    api
                        .columns()
                        .eq(0)
                        .each(function (colIdx) {
                            // Set the header cell to contain the input element
                            var cell = $('.filters th').eq(
                                $(api.column(colIdx).header()).index()
                            );
                            var title = $(cell).text();
                            $(cell).html('<input class="header_item" " type="text" placeholder="' + title + '" />');

                            // On every keypress in this input
                            $(
                                'input',
                                $('.filters th').eq($(api.column(colIdx).header()).index())
                            )
                                .off('keyup change')
                                .on('keyup change', function (e) {
                                    e.stopPropagation();

                                    // Get the search value
                                    $(this).attr('title', $(this).val());
                                    var regexr = '({search})'; //$(this).parents('th').find('select').val();

                                    var cursorPosition = this.selectionStart;
                                    // Search the column for that value
                                    api
                                        .column(colIdx)
                                        .search(
                                            this.value != ''
                                                ? regexr.replace('{search}', '(((' + this.value + ')))')
                                                : '',
                                            this.value != '',
                                            this.value == ''
                                        )
                                        .draw();

                                    $(this)
                                        .focus()[0]
                                        .setSelectionRange(cursorPosition, cursorPosition);
                                });
                        });
                },
            });
        } );
        $('#assigneddata').submit(function() {
            event.preventDefault();
            var is_urgent = $('input[name="urgent"]:checked').val();
            var assigned_to = $('#myselect').val();
            var id = $('#ticket_id').val();
            if(assigned_to == null)
            {
                toastr.error('Please select technician!!');
            }
            else
            {
                $.ajax({
                    url: '{{url('/assignTicket')}}',
                    type: "POST",
                    data: {"_token": "{{ csrf_token() }}", id: id, assigned_to: assigned_to,is_urgent:is_urgent},
                    success: function (response) {
                        toastr.success('Ticket Assign successfully !!');
                        window.location.href = '{{url('/tickets')}}';
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
            }

        });
        $('#forwardticket').submit(function() {
            event.preventDefault();
            var is_urgent = $('input[name="urgent"]:checked').val();
            var assigned_to = $('#forwardTeamdata').val();
            var id = $('#forward_ticket_id').val();
            if(assigned_to ==null)
            {
                toastr.error('Please select technician!!');
            }
            else
            {
                $.ajax({
                    url: '{{url('/forwardTicket')}}',
                    type: "POST",
                    data: {"_token": "{{ csrf_token() }}", id: id, forward_by: assigned_to,is_urgent:is_urgent},
                    success: function (response) {
                        toastr.success('Ticket Forward successfully !!');
                        window.location.href = '{{url('/tickets')}}';
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
            }
        });
        function removeTicket(id) {
            let text = "Are you sure you want to delete ticket ?.";
            if (confirm(text) == true) {
                $.ajax({
                    url: '{{url('/removeticket')}}',
                    type: "POST",
                    data: {"_token": "{{ csrf_token() }}", id: id},
                    success: function (response) {
                        toastr.success('Ticket delete successfully !!');
                        window.location.href = '{{url('/tickets')}}';
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
            } else {

            }
        }

        function ticketStatus(ticket_id){
            $('#ticketStatus').modal('show');
            $('#ticketStatus').find('tbody').html('');
            $.ajax({
                url: '{{url('/ticketStatus')}}',
                type: "POST",
                data: {"_token": "{{ csrf_token() }}", ticket_id: ticket_id},
                success: function (response) {
                    if(response.length > 0){
                        var html = '';
                        $(response).each(function(index, value) {
                            html+=' <tr>' +
                                        '<td style="padding: 10px !important;">'+value.get_technician.name+'</td>' +
                                        '<td style="padding: 10px !important;">'+value.status+'</td>' +
                                        '<td style="padding: 10px !important;">'+value.reason+'</td>' +
                                        '<td style="padding: 10px !important;">'+value.date+'</td>' +
                                    '</tr>';
                        });
                        $('#ticketStatus').find('tbody').html(html);
                    }
                },
                error: function (e) {
                    console.log(e);
                }
            });
        }

        function ticketPunches(ticket_id){
            $('#ticketPunches').modal('show');
            $('#ticketPunches').find('tbody').html('');
            $.ajax({
                url: '{{url('/ticketPunches')}}',
                type: "POST",
                data: {"_token": "{{ csrf_token() }}", ticket_id: ticket_id},
                success: function (response) {
                    if(response.length > 0){
                        var html = '';
                        $(response).each(function(index, value) {
                            html+=' <tr>' +
                                        '<td style="padding: 10px !important;">'+value.get_technician.name+'</td>' +
                                        '<td style="padding: 10px !important;">'+value.type+'</td>' +
                                        '<td style="padding: 10px !important;">'+value.latitude+'</td>' +
                                        '<td style="padding: 10px !important;">'+value.longitude+'</td>' +
                                        '<td style="padding: 10px !important;">'+value.distance+'</td>' +
                                        '<td style="padding: 10px !important;">'+value.date+'</td>' +
                                        '<td style="padding: 10px !important;">'+value.time+'</td>' +
                                    '</tr>';
                        });
                        $('#ticketPunches').find('tbody').html(html);
                    }
                },
                error: function (e) {
                    console.log(e);
                }
            });
        }
    </script>
@endsection