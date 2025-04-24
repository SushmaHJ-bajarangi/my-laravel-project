<?php
$date = date('Y-m-d');
$starting_date =  date('Y-m-01');
?>
@extends('layouts.app')
@section('content')
    <section class="content-header">
        <h1 class="pull-left">Reports</h1>
    </section>
    <div>
        <div class="content">
            <div class="clearfix"></div>
            <div class="box box-primary">
                <div class="box-body">
                    <div class="col-md-12">
                       <div class="row">
                           <div class="col-md-3">
                               <input class="form-control" type="date" placeholder="Form Date" value="{{date('Y-m-d', strtotime($starting_date))}}" id="StartDate">
                           </div>
                           <div class="col-md-3">
                               <input class="form-control" type="date" placeholder="To Date" value="{{date('Y-m-d', strtotime($date))}}" id="EndDate">
                           </div>
                           <div class="col-md-3">
                               <select class="form-control" id="technicianId">
                                   <option value="all" selected>All</option>
                                   @if(isset($technicians))
                                       @foreach($technicians as $technician)
                                            <option value="{{$technician->id}}">{{$technician->name}}</option>
                                       @endforeach
                                   @endif
                               </select>
                           </div>
                           <div class="col-md-3">
                               <button class="btn btn-success" type="button" onclick="filterData()">Filter</button>
                           </div>
                       </div>
                        <div class='table-responsive' style="margin-top: 20px">
                            <table class="table table-bordered yajra-datatable" id="myTable">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Customer Name</th>
                                    <th>Unique Job Number</th>
                                    <th>technician Name</th>
                                    <th>Zone</th>
                                </tr>
                                </thead>
                                <tbody id="appendData">
                                @if(count($reports) > 0)
                                    @foreach($reports as $k=>$report)
                                        @php($zone = App\Models\Zone::where('id',$report->getechnicianName->zone)->first())
                                        <tr>
                                            <td>{{$k+1}}</td>
                                            <td>{{$report->getCustomer->name}}</td>
                                            <td>{{$report->unique_job_number}}</td>
                                            <td>{{$report->getechnicianName->name}}</td>
                                            <td>{{$zone->title}}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td>No data available</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
@section('scripts')
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#myTable').DataTable();
        });

        function filterData(){
            var StartDate = $('#StartDate').val();
            var EndDate = $('#EndDate').val();
            var technicianId = $('#technicianId').val();
            $.ajax({
                method: 'get',
                url: '{{url('getReports')}}',
                data: {StartDate:StartDate,EndDate:EndDate,technicianId:technicianId},
                success: function(response){
                    var html = '';
                    $.each(response, function (key, val) {
                        html+='<tr>\n' +
                            '                                            <td>'+key+'</td>\n' +
                            '                                            <td>'+val.customer_id+'</td>\n' +
                            '                                            <td>'+val.unique_job_number+'</td>\n' +
                            '                                            <td>'+val.assigned_to+'</td>\n' +
                            '                                            <td>'+val.zone+'</td>\n' +
                            '                                        </tr>';
                    });
                 $('#appendData').html(html)
                },
            });
        }
    </script>
@endsection