@extends('layouts.app')
@section('css')
    <style>
        .select2-results__option {
            padding-right: 20px;
            vertical-align: middle;
        }
        .select2-results__option:before {
            content: "";
            display: inline-block;
            position: relative;
            height: 20px;
            width: 20px;
            border: 2px solid #e9e9e9;
            border-radius: 4px;
            background-color: #fff;
            margin-right: 20px;
            vertical-align: middle;
        }
        .select2-results__option[aria-selected=true]:before {
            font-family:fontAwesome;
            content: "\f00c";
            color: #fff;
            background-color: #f77750;
            border: 0;
            display: inline-block;
            padding-left: 3px;
        }
        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #fff;
        }
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #eaeaeb;
            color: #272727;
        }
        .select2-container--default .select2-selection--multiple {
            margin-bottom: 10px;
        }


        .select2-selection .select2-selection--multiple:after {
            content: 'hhghgh';
        }
        /* select with icons badges single*/
        .select-icon .select2-selection__placeholder .badge {
            display: none;
        }
        .select-icon .placeholder {
            display: none;
        }
        .select-icon .select2-results__option:before,
        .select-icon .select2-results__option[aria-selected=true]:before {
            display: none !important;
            /* content: "" !important; */
        }
        .select-icon  .select2-search--dropdown {
            display: none;
        }
        .select2-container{
            width: 100% !important;
        }
        .select2-container--default .select2-selection--multiple {
            background-color: white;
            border: 1px solid #dadee7;
            border-radius: 0px;
            cursor: text;
            margin-bottom: 0 !important;
            min-height: 35px !important;
        }
    </style>
@endsection
@section('content')
    <section class="content-header">
        <h1 class="pull-left">Reports</h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-10">
                        <div class="col-md-5">
                            <select class="single-select2 form-control" onchange="getColumnNames(this.value)">
                                <option disabled selected>Select Table</option>
                                @if(isset($tableNames) && count($tableNames) > 0)
                                    @foreach($tableNames as $key => $tbn)
                                        <option value="{{$tbn->Tables_in_svjde7oj_teknix}}">{{$tbn->Tables_in_svjde7oj_teknix}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-5">
                            <select class="js-select2 form-control" id="columnNames"></select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>

        $(".js-select2").select2({
            closeOnSelect : false,
            width: "100%",
            placeholder : "Select Column",
            allowHtml: true,
            allowClear: true,
            tags: true,
            multiple : true
        });


        $('.single-select2').select2({
            width: "100%",
            allowHtml: true,
            placeholder: "Select Table",
            allowClear: true,
            tags: true
        });



        function getColumnNames(val){
            $.ajax({
                url: "{{url('getColumnNames')}}"+'/'+val,
                type: "get",
                success: function(data){
                    var html = '';
                    $.each(data, function (key, val) {
                       html+='<option value="'+val+'">'+val+'</option>';
                    });
                    $("#columnNames").html(html);
                }
            });
        }
    </script>
@endsection