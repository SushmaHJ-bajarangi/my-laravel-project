@extends('layouts.app')
@section('content')

    <section class="content-header">
        <h1 class="pull-left">Import Crm Production</h1>
    </section>

    <br>
    <div class="content">
        <div class="clearfix"></div>


        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">

                <form action="{{ route('crmimport') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="file" name="import_file" accept=".xls,.xlsx" class="form-control">

                    <br>

                    <button class="btn btn-success">Upload</button>
                    <a href="{{ url('crm_production') }}"  class="btn btn-default">Cancel</a>

                    <a href="{{ asset('downloads/crmproductionsampletemplate.xlsx') }}" class="btn btn-info" download>Download Sample Excel Sheet</a>
                </form>

            </div>
        </div>

        <div class="text-center">
        </div>
    </div>
@endsection