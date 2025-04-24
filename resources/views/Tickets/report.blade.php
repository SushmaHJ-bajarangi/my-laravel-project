@extends('layouts.app')
@section('css')
    {{--<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">--}}
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" rel="stylesheet">
@endsection

@section('content')
    <section class="content-header">
        <div class="row">
            <div class="col-md-9 col-sm-8">
                <h1 class="report-title" style="font-size: 23px; margin-top: 6px;">Tickets Report</h1>
            </div>
            <div class="col-md-3 col-sm-4">
                <div class="form-group filter-group" style="margin-bottom: 0px;">
                    <strong class="filter">Filter :</strong>
                    <select class="form-control filter-menu" name="filter" id="filter">
                        <option selected="selected" value="12-month">12 Month</option>
                        <option value="9-month">9 Month</option>
                        <option value="6-month">6 Month</option>
                        <option value="3-month">3 Month</option>
                    </select>
                </div>
            </div>
        </div>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <div class='table-responsive'>
                    <table class="table table-bordered yajra-datatable display nowrap" id="example">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Unique Job Number</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Count</th>
                            <th>Assigned To</th>
                            <th>Raise Date</th>
                            <th>Close Date</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            {{--<div class="col-12 text-center Chart-title">--}}
                {{--<span>Tickets Status</span>--}}
            {{--</div>--}}
            <div class="col-md-12">
                {{--<canvas id="reportChart" height="100"></canvas>--}}
                {{--<div class="reportChart"></div>--}}
                <div id="chart-container">TicketsReport chart will render here</div>
                <div class="chart-container"></div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-sm-3">
                {!! Form::open(['url' => 'ticketReport/downloadReport']) !!}
                <div class="form-group filter-group" style="margin-top: 18px;">
                    <strong class="filter">Limit :</strong>
                    <select class="form-control filter-menu" name="filter" id="report-filter">
                        <option selected="selected" value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                        <option value="25">25</option>
                        <option value="30">30</option>
                        <option value="35">35</option>
                        <option value="40">40</option>
                        <option value="45">45</option>
                        <option value="50">50</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 download-button">
                <h1 class="button-top pull-left">
                    <button type="submit" class="btn btn-primary pull-left">Download CSV</button>
                </h1>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3/dist/chart.min.js"></script>
    <!-- Include fusioncharts core library file -->
    <script src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
    <script src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
    <script src="https://rawgit.com/fusioncharts/fusioncharts-jquery-plugin/develop/dist/fusioncharts.jqueryplugin.min.js"></script>

    <script type="text/javascript">
        var report = <?php echo json_encode($report) ?>;
        var unique = <?php echo json_encode($unique) ?>;

        $(function () {

            $('#example thead tr')
                .clone(true)
                .addClass('filters')
                .appendTo('#example thead');
            var table = $('#example').DataTable({
                processing: true,
                ajax: "{{ url('RaisedTickets/Report')}}",
                orderCellsTop: true,
                fixedHeader: true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        messageTop: 'Tickets Report List in Last Year'
                    },
                    {
                        extend: 'csv',
                        messageTop: 'Tickets Report List in Last Year'
                    },
                    {
                        extend: 'pdf',
                        messageBottom: null
                    },
                    {
                        extend: 'print',
                        messageBottom: null
                    }
                ],
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
                            $(cell).html('<input class="header_item1" type="text" placeholder="' + title + '" />');

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
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
                    {data: 'unique_job_number', orderable: true, name: 'unique_job_number', searchable: true},
                    {data: 'title_close', name: 'title_close', orderable: true, searchable: true},
                    {data: 'close_description', name: 'close_description', orderable: true, searchable: true},
                    {data: 'count', name: 'count', orderable: true, searchable: true},
                    {data: 'teamName', name: 'teamName', orderable: true, searchable: true},
                    {data: 'progress_date', name: 'progress_date', orderable: true, searchable: true},
                    {data: 'complete_date', name: 'complete_date', orderable: true, searchable: true},
                    {data: 'status', name: 'status', orderable: true, searchable: true},

                ]
            });

        });

        $(document).ready( function () {
            $(document).on('change','#filter', function (){
                $('#example').DataTable().clear().destroy();
                var filter = $('#filter').find(":selected").val();
                var table = $("#example").DataTable({
                    ajax: {
                        url : '{{url('ticketReport/reportFilter')}}',
                        type : "POST",
                        data: function (d) {
                            d.change_by = filter,
                            d._token = "{{ csrf_token() }}"
                        }
                    },
                    processing: true,
                    orderCellsTop: true,
                    fixedHeader: true,
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'excel',
                            messageBottom: null
                        },
                        {
                            extend: 'csv',
                            messageBottom: null
                        },
                        {
                            extend: 'pdf',
                            messageBottom: null
                        },
                        {
                            extend: 'print',
                            messageBottom: null
                        }
                    ],
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
                                $(cell).html('<input class="header_item1" type="text" placeholder="' + title + '" />');

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
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
                        {data: 'unique_job_number', orderable: true, name: 'unique_job_number', searchable: true},
                        {data: 'title_close', name: 'title_close', orderable: true, searchable: true},
                        {data: 'close_description', name: 'close_description', orderable: true, searchable: true},
                        {data: 'count', name: 'count', orderable: true, searchable: true},
                        {data: 'teamName', name: 'teamName', orderable: true, searchable: true},
                        {data: 'progress_date', name: 'progress_date', orderable: true, searchable: true},
                        {data: 'complete_date', name: 'complete_date', orderable: true, searchable: true},
                        {data: 'status', name: 'status', orderable: true, searchable: true},
                    ]
                });

            });
        });


        var chartData = [];
        $.each(unique, function (index, uniqueItem) {
            chartData.push({
                label: uniqueItem,
                value: report[index]
            });
        });

        $('#chart-container').insertFusionCharts({
            type: 'column2d',
            width: '100%',
            height: '400',
            dataFormat: 'json',
            dataSource: {
                // Chart Configuration
                "chart": {
                    "caption": "Top 10 Tickets Report",
                    "subCaption": "Last Year",
                    "xAxisName": "Tickets Report",
                    "exportEnabled": "1", //Export Your Chart
                    "theme": "fusion"
                },
                // Chart Data
                "data": chartData
            }
        });

        // $(function(){
        //     var Daydatas = report;
        //     var Dayuniqu = unique;
        //     var barCanvas = $("#reportChart");
        //     var barChart = new Chart(barCanvas,{
        //         type:'bar',
        //         data:{
        //             labels:Dayuniqu,
        //             datasets:[
        //                 {
        //                     label: 'Tickets Report',
        //                     data: Daydatas,
        //                     backgroundColor :'#c7254e',
        //                 }
        //             ]
        //         },
        //         options:{
        //             scales:{
        //                 yAxes:[{
        //                     ticks:{
        //                         beginAtZero: false
        //                     }
        //                 }]
        //             }
        //         }
        //     })
        // });

        $(document).ready( function () {
            $(document).on('change','#filter', function (){
                var filter = $('#filter').find(":selected").val();
                $("div#chart-container").remove();
                $("div.chart-container").append('<div  id="chart-container">TicketsReport chart will render here</div>');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type : "POST",
                    url : "{{url('/ticketReport/graphFilter')}}",
                    data: { change_by: filter },
                    success : function (response){
                        var Daydatas = response.report;
                        var Dayuniqu = response.unique;
                        var title = response.titleName;

                        var chartData = [];
                        $.each(Dayuniqu, function (index, uniqueItem) {
                            chartData.push({
                                label: uniqueItem,
                                value: Daydatas[index]
                            });
                        });

                        $('#chart-container').insertFusionCharts({
                            type: 'column2d',
                            width: '100%',
                            height: '400',
                            dataFormat: 'json',
                            dataSource: {
                                // Chart Configuration
                                "chart": {
                                    "caption": "Top 10 Tickets Report",
                                    "subCaption": title,
                                    "xAxisName": "Tickets Report",
                                    "exportEnabled": "1", //Export Your Chart
                                    "theme": "fusion"
                                },
                                // Chart Data
                                "data": chartData
                            }
                        });
                    }
                });
            });
        });

    </script>

@endsection