@extends('layouts.app')
@section('css')
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection
@section('content')
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <h2 class="mb-4">Service History</h2>
                <div class='table-responsive'>
                    <table class="table table-bordered " id="example">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Customer Name</th>
                            <th>Customer Unique Job Number</th>
                            <th>Assign To</th>
                            <th>Service Details</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($service_history as $key=>$item)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$item->customer_name}}</td>
                                <td>{{$item->unique_job_number}}</td>
                                <td>{{$item->technician_name}}</td>
                                <td><button type="button" class="btn btn-danger" data-toggle="modal" onclick="servicehistory('{{$item->unique_job_number}}')" data-target="#servicehistory">Service Details</button></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="servicehistory">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Service History Details</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Date</th>
                            <th>Complete Service</th>
                            <th>Technician Name</th>
                            <th>Job Number</th>
                            <th>status</th>
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
@endsection
@section('scripts')

    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready( function () {
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
            });
        } );
    </script>
    <script type="text/javascript">
        function servicehistory(unique_job_number) {
            $.ajax({
                url: '{{url('/serviceHistoryDetails')}}',
                type: "POST",
                data: { "_token": "{{ csrf_token() }}",unique_job_number:unique_job_number},
                success: function( response ) {
                    console.log(response);
                    let trHTML = '';
                    $.each(response, function (i, item) {
                        trHTML += '<tr>';
                        trHTML += '<td>'+(parseInt(i)+1)+'</td>';
                        trHTML += '<td>'+item.date+'</td>';
                        trHTML += '<td>'+item.complete_service+'</td>';
                        trHTML += '<td>'+item.technician_name+'</td>';
                        trHTML += '<td>'+item.unique_job_number+'</td>';
                        trHTML += '<td>'+item.status+'</td>';
                        trHTML += '</tr>';
                    });
                    $('#servicedata').html(trHTML);
                },
                error:function (e) {
                    console.log(e);
                }
            });
        }

        $(".table").on("click", "#toggle_icon", function(ev) {
            const $row = $(this).closest("tr");
            $row.siblings().removeClass("rowcolorbg"); // Other <tbody> TR elements
            $row.addClass("rowcolorbg");
        });

    </script>
@endsection