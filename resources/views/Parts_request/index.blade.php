@extends('layouts.app')

@section('css')
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Parts Request</h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <div class='table-responsive' id="table_assign">
                    <table class="table table-bordered yajra-datatable" id="table">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Unique Job Number</th>
                            <th>Customer</th>
                            <th>Price</th>
                            <th>Team</th>
                            <th>Parts</th>
                            <th>Final Price</th>
                            <th>Raised Ticket</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Pay Here</th>
                            <th>Admin Status</th>
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

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Example select</label>
                        <select class="form-control" id="payment_method">
                            <option value="" disabled  selected hidden>select payment Method</option>
                            <option value="Cheque">Cheque</option>
                            <option value="Cash">Cash</option>
                            <option value="NEFT">NEFT</option>
                            <option value="Online">Online</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="paymentFinal" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
        $(function () {

            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('getParts') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
                    {data: 'unique_job_number', orderable: true, name: 'unique_job_number', searchable: true},
                    {data: 'customer_id', name: 'customer_id', orderable: true, searchable: true},
                    {data: 'amt', name: 'amt', orderable: true, searchable: true},
                    {data: 'technician_user_id', name: 'technician_user_id', orderable: true, searchable: true},
                    {data: 'parts_id', name: 'parts_id', orderable: true, searchable: true},
                    {data: 'final_price', name: 'final_price', orderable: true, searchable: true},
                    {data: 'ticket_id', name: 'ticket_id', orderable: false, searchable: true},
                    {data: 'date', name: 'date', orderable: false, searchable: false},
                    {data: 'status', name: 'status', orderable: false, searchable: false},
                    {data: 'payment', name: 'payment', orderable: false, searchable: false},
                    {data: 'admin_status', name: 'admin_status', orderable: false, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });


        $("#table").on("click", "#parts", function(ev) {
            const $row = $(this).closest("tr");
            $row.siblings().removeClass("rowcolorbg"); // Other <tbody> TR elements
            $row.addClass("rowcolorbg");
        });
        function Paymentnow(id) {
            $('#myModal').modal('show');
            $("#paymentFinal").on("click", function(ev) {
                var payment_method = $( "#payment_method option:selected" ).val();
                if(payment_method =='')
                {
                    toastr.clear();
                    toastr.error('Please select payment method');
                }
                else {
                    $.ajax({
                        type:'POST',
                        url:'{{url('partspayment')}}',
                        data:{_token: "{{ csrf_token() }}",parts_id:id,payment_method:payment_method
                        },
                        success: function( msg ) {
                            toastr.clear();
                            toastr.success('Parts payment done successfully');
                            location.reload();

                        }
                    });
                }

            });
            }
        function adminstatus(id) {
                $.ajax({
                    type:'POST',
                    url:'{{url('adminstatus')}}',
                    data:{_token: "{{ csrf_token() }}",parts_id:id,
                    },
                    success: function( msg ) {
                        toastr.clear();
                        toastr.success('Parts payment status by admin changed successfully');
                        location.reload();

                    }
                });
            }
    </script>
@endsection