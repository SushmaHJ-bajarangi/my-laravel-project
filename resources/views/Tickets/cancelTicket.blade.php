@extends('layouts.app')
@section('css')
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection
@section('content')
    <section class="content-header">
        <h1 class="pull-left">Canceled Tickets</h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <div class='table-responsive'>
                    <table class="table table-bordered yajra-datatable">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Unique Job Number</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Assigned To</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
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
                ajax: "{{ url('cancelTicket/History')}}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
                    {data: 'unique_job_number', orderable: true, name: 'unique_job_number', searchable: true},
                    {data: 'title', name: 'title', orderable: true, searchable: true},
                    {data: 'description', name: 'description', orderable: true, searchable: true},

                    {data: 'image', render: function (data, type, full, meta) {
                            if(data == null){
                                var path = "{{ url('/images/no_img.png')}}";
                            }
                            else {
                                var path = "{{ url('/images/products')}}"+'/'+data;
                            }
                            return "<img src='"+path+"' class='raise_ticket_image'>";
                        }},
                    {data: 'teamName', name: 'teamName', orderable: true, searchable: true},
                    {data: 'progress_date', name: 'progress_date', orderable: true, searchable: true},
                    {data: 'status', name: 'status', orderable: true, searchable: true},

                ]
            });

        });




    </script>
@endsection