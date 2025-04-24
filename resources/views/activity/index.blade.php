@extends('layouts.app')

@section('content')

<section class="content-header">
    <h1 class="pull-left">Activity</h1>
</section>

<div class="content">
    <div class="clearfix"></div>

    <div class="container">
        <div class="row">
            <div class="form-group filter-group">
                <strong class="filter">Filter :</strong>
                <select class="form-control filter-select" name="filter" id="filter">
                    <option selected="selected" value="All">All</option>
                    @foreach($users as $user)
                    <option value="{{$user->name}}">{{$user->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="box box-primary">
        <div class="box-body">
            <div class='table-responsive' id="table_assign">
                <table class="table table-bordered" id="example">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Table Name</th>
                        <th>Changed By</th>
                        <th>Activity</th>
                    </tr>
                    </thead>
                    <tbody id="tBody">
                    @foreach($activity as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->t_name}}</td>
                        <td>{{$item->change_by}}</td>
                        <td>{{$item->activity}}</td>
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
<script>
    $(document).ready( function () {
        $(document).on('change','#filter', function (){
            // var filter = $('#filter').val();
            var filter = $('#filter').find(":selected").val();
            // console.log(filter);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type : "POST",
                url : "{{url('/activity/filter')}}",
                data: { change_by: filter },
                success : function (response){
                    // console.log(response);
                    var trHTML = '';
                    $.each(response, function (i, data) {
                        // console.log(data);
                        trHTML += '<tr>';
                        trHTML += '<td>'+data.id+'</td>';
                        trHTML += '<td>'+data.t_name+'</td>';
                        trHTML += '<td>'+data.change_by+'</td>';
                        trHTML += '<td>'+data.activity+'</td>';
                        trHTML += '</tr>';
                    });
                    $('#tBody').html(trHTML);
                }
            });
        });
    });

    $(document).ready(function() {
        $("#example").DataTable(
            {
                "pagingType": "full_numbers",
                "paging": true,
                "lengthMenu": [10, 25, 50, 75, 100],
            });
    });
</script>
@endsection