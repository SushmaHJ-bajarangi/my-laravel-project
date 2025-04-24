@extends('layouts.app')
@section('content')

    <section class="content-header">
        <h1 class="pull-left"> Production Request</h1>

        <h1 class="pull-right" style="margin-right: 10px;">
            <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px;margin-right: 5px" href="{{ url('production_request/exportproduction') }}">Export</a>
        </h1>

        <h1 class="pull-right" style="margin-right: 10px;">
            <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{{ url('production_request/importExportproduction') }}">Import</a>
        </h1>
        <h1 class="pull-right" style="margin-right: 10px;">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{{ url('production_request/create') }}">Add New</a>
        </h1>
    </section>

    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('production_request.table')
            </div>
        </div>
        <div class="text-center">

        </div>
    </div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.0/css/buttons.dataTables.css">
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.colVis.min.js"></script>

<script>
    $(document).ready(function() {

        new DataTable('#example', {
            layout: {
                topStart: {
                    buttons: ['colvis']
                }
            },
            // columnDefs: [
            //     { targets: 17, visible: false }  // Hide column 17
            // ]
        });
    } );

</script>

@endsection
