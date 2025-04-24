@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <h2 class="mb-4">Service</h2>
                <div class="row" style="margin-bottom: 10px">
                    <label class="control-label col-md-1" for="technician">Technician</label>
                    <div class="col-sm-6 col-md-2">
                        <select id="technician" class="form-control technician">
                            <option value="all" selected> All </option>
                            @foreach($technicians as $technician)
                                <option value="{{$technician->id}}">{{$technician->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <label class="control-label col-md-1" for="technician">Month</label>
                    <div class="col-sm-6 col-md-2">
                        <select id="month" class="form-control month">
                            <option value="" selected disabled>All Months</option>
                            <option value="01">January</option>
                            <option value="02">February</option>
                            <option value="03">March</option>
                            <option value="04">April</option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    </div>

                    <label class="control-label col-md-1" for="technician">Year</label>
                    <div class="col-sm-6 col-md-2">
                        <select id="year" class="form-control year">
                            <option value="" selected disabled>All Years</option>
                            @foreach($years as $year)
                                <option value="{{$year}}">{{$year}}</option>
                            @endforeach
                        </select>
                    </div>

                    <button class="btn btn-primary" id="filter">Filter</button>
                </div>

                <div class='table-responsive'>
                <table class="table table-bordered" id="example">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Customer Name</th>
                        <th>Job Number</th>
                        <th>Assign To</th>
                        <th>Service Date</th>
                        <th>Service Details</th>
                    </tr>
                    </thead>
                    <tbody id="service-data">
                    @foreach($data as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->customerName}}</td>
                        <td>{{$item->unique_job_number}}</td>
                        <td>{{$item->team_name}}</td>
                        <td>{{$item->date}}</td>
                        <td><button type="button" class="btn btn-danger" data-toggle="modal" onclick="service_data('{{$item->unique_job_number}}')" data-target="#myModal">
                            View
                        </button>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Service Details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Customer Name</th>
                        <th>Job Number</th>
                        <th>Service Date</th>
                        <th>Technician Name</th>
                        <th>Edit Service</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody id="servicedata">
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
<div class="modal" id="editservice">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Service Details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="control-label col-sm-6">Job number : <span id="job_number"></span></div>
                <div class="control-label col-sm-6">Customer Name : <span id="customer_name"></span></div>
                <hr>
                <form class="form-horizontal" method="POST" id="serviceeditform">
                    @csrf
                    <input type = 'hidden' id="service_id"  name="service_id" class="form-control"  />
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="pwd">Edit Date:</label>
                        <div class="col-sm-8">
                            <div class = 'input-group date' id='datetimepicker3'>
                            <input type = 'text' id="service_date"  name="service_date" class="form-control"  />
                            <span class = "input-group-addon">
                                <span class = "glyphicon glyphicon-time"></span>
                            </span>
                        </div>
                            <div class="col-sm-12 dateerror"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4">Select Team:</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="serviceteam">
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                            <button  class="btn btn-success">Submit</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript">
        var table;
        $("#filter").click(function () {

            var selectedTechnician = $('.technician').find(":selected").val();
            var selectedMonth = $('.month').find(":selected").val();
            var selectedYear = $('.year').find(":selected").val();

            if(selectedMonth == ''  || selectedYear == ''){
                alert('please select Month and Year both value');
            } else {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: '{{ url('services_data') }}',
                    data: {'month': selectedMonth, 'year': selectedYear, 'technician': selectedTechnician},
                    success: function (response) {

                        if ($.fn.DataTable.isDataTable("#example")) {
                            $('#example').DataTable().clear().destroy();
                        }

                        let trHTML = '';

                        $.each(response.data, function (i, item) {
                            trHTML += '<tr><td>'+item.id+'</td>';
                            trHTML += '<td>'+item.customerName+'</td>';
                            trHTML += '<td>'+item.unique_job_number+'</td>';
                            trHTML += '<td>'+item.team_name+'</td>';
                            trHTML += '<td>'+item.date+'</td>';
                            trHTML += '<td><button type="button" class="btn btn-danger" data-toggle="modal" onclick="service_data('+item.unique_job_number+')"  data-target="#myModal">View</button></td>';
                            trHTML += '</tr>';
                        });
                        $('#service-data').html(trHTML);

                        table = $('#example').DataTable({
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
                                        $(cell).html('<input type="text" placeholder="' + title + '" />');

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
                            dom: 'Bfrtip',
                            buttons: [
                                'excel',
                            ]
                        });
                    }
                });
            }


        });

        $(function () {
            $("#datetimepicker3").datetimepicker({
                format: "DD-MM-YYYY",
            });
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        function service_data(unique_job_number) {
            $('#servicedata').empty();
            $.ajax({
                url: "{{ url('getServices') }}",
                type: 'POST',
                data: {
                    unique_job_number: unique_job_number,
                },
                success: function (response) {
                    console.log(response);
                    let trHTML = '';
                    $.each(response, function (i, item) {
                        trHTML += '<tr id="complete_'+item.id+'">';
                        trHTML += '<td>'+(parseInt(i)+1)+'</td>';
                        trHTML += '<td>'+item.customer_name+'</td>';
                        trHTML += '<td>'+item.unique_job_number+'</td>';
                        trHTML += '<td>'+item.date+'</td>';
                        trHTML += '<td>'+item.technician_name+'</td>';
                        trHTML += '<td><button type="button" class="btn btn-danger" data-toggle="modal" onclick="editServices('+item.id+')" data-target="#editservice">Edit Service</button></td>';
                        trHTML += '<td><button type="button" class="btn btn-danger" data-toggle="modal" onclick="completeService('+item.id+')">Complete</button></td>';
                        trHTML += '</tr>';
                    });
                    $('#servicedata').html(trHTML);

                },
                error: function (response) {
                    $('#errormessage').html(response.message);
                }
            });
        }

        function  editServices(service_id) {
            $.ajax({
                url: "{{ url('editServices') }}",
                type: 'POST',
                data: {
                    service_id: service_id,
                },
                success: function (response) {
                    $('#service_date').val(response.date);
                    $('#service_id').val(response.id);
                    $('#customer_name').text(response.customer_name);
                    $('#job_number').text(response.unique_job_number);
                    $.ajax({
                        url: "{{ url('editteam') }}",
                        type: 'get',
                        success: function (data) {
                            let optionHTML = '';
                            $.each(data, function (i, item) {

                                if(response.assign_team_id ==item.id)
                                {
                                    optionHTML += '<option selected value='+item.id+' >'+item.name+' '+item.title+' '+item.zone_name+ '</option>';
                                }
                                else
                                {
                                    optionHTML += '<option  value='+item.id+' >'+item.name+' '+item.title+' '+item.zone_name+ '</option>';
                                }

                            });
                            $('#serviceteam').html(optionHTML);

                        },
                        error: function (response) {
                            $('#errormessage').html(response.message);
                        }
                    });
                },
                error: function (response) {
                    $('#errormessage').html(response.message);
                }
            });
        }

        $(document).ready( function () {
            $('#example thead tr')
                .clone(true)
                .addClass('filters')
                .appendTo('#example thead');

            table = $('#example').DataTable({
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
                            $(cell).html('<input type="text" placeholder="' + title + '" />');

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
                dom: 'Bfrtip',
                buttons: [
                     'excel',
                ]
            });
        } );
        $('#serviceeditform').submit(function() {
            event.preventDefault();
            var date = $('#service_date').val();
            var service_id = $('#service_id').val();
            var team_id = $('#serviceteam').find(":selected").val();
            if(date == ''){
                toastr.clear();
                toastr.error('Please select assign date');
            }
            else{
                $.ajax({
                    url: '{{url('/updateServices')}}',
                    type: "POST",
                    data: { "_token": "{{ csrf_token() }}",service_id:service_id, date:date, team_id:team_id },
                    success: function( response ) {
                        toastr.success('service updated successfully');
                        window.location.href = '{{url('/service')}}';

                    },
                    error:function (e) {
                        console.log(e);
                    }
                });
            }
        });
        function completeService(service_id){
            if(confirm('Are you sure ? you want to complete this service'))
            {
                $.ajax({
                    url: '{{url('/completeService')}}',
                    type: "POST",
                    data: { "_token": "{{ csrf_token() }}",service_id:service_id},
                    success: function( response ) {
                        toastr.success('service completed successfully');
                        $('#complete_'+service_id).fadeOut();
                    },
                    error:function (e) {
                        console.log(e);
                    }
                });
            }
            else {

            }

        }
    </script>
@endsection