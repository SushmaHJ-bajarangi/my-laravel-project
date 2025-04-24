@extends('layouts.app')
@section('content')

<section class="content-header">
    <h1 class="pull-left">Payment History</h1>
</section>

<div class="content">
    <div class="clearfix"></div>
    <div class="box box-primary">
        <div class="box-body">
            <div class='table-responsive' id="table_assign">
                <table class="table table-bordered" id="example">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Customer Name</th>
                        <th>Job Number</th>
                        <th>Order Number</th>
                        <th>Payment Mode</th>
                        <th>Amount</th>
                        <th>Transaction for</th>
                    </tr>
                    </thead>
                    <tbody id="tBody">
                    @foreach($history as $key=>$item)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$item->customer_name}}</td>
                        <td>{{$item->unique_job_number}}</td>
                        <td>{{$item->order_id}}</td>
                        <td>{{$item->payment_mode}}</td>
                        <td>{{$item->amount}}</td>
                        <td>{{$item->transaction_for}}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
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
@endsection