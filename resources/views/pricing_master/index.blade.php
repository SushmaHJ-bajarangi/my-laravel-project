@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Pricing Master</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{{ url('pricing_master/create') }}">Add New</a>
        </h1>
    </section>
@endsection

@section('scripts')

<script>
    $(document).ready(function() {
        $('#example').DataTable();
    } );
</script>

@endsection