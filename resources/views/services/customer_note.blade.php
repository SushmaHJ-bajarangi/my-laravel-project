@extends('layouts.app')
@section('content')
<div class="content">
    <div class="box box-primary">
        <div class="box-body">
            <h2 class="mb-4">Customer Note</h2>
            <div class='table-responsive'>
                <table class="table table-bordered yajra-datatable" id="myTable">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Service Id</th>
                        <th>Description</th>
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
                    @foreach($notes as $k=>$note)
                    <tr>
                        <td>{{$k+1}}</td>
                        <td>{{$note->service_id}}</td>
                        <td>{{$note->description}}</td>
                        <td>
                            @if (auth()->check())
                            @if (auth()->user()->role == 1)
                            <form method="post" action="{{url('destroy/note',$note->id)}}">
<!--                                <a href="{{url('edit/customer/note',$note->id)}}"  class='btn btn-default btn-xs'>-->
<!--                                    <i class="glyphicon glyphicon-edit"></i>-->
<!--                                </a>-->
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></button>
                            </form>
                            @else
                        <td></td>
                        @endif
                        @endif
                        </td>
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
<link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
<script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready( function () {
        $('#myTable').DataTable();
    } );
</script>
@endsection