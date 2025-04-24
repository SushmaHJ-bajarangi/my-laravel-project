<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{config('app.name')}} </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/css/AdminLTE.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/css/skins/_all-skins.min.css">

    <!-- iCheck -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/square/_all.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">

    <link rel="stylesheet" href="{{asset('/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    {{--<link href="{{asset('images/logo.png')}}" rel="icon">--}}
    @yield('css')
    <style>
        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td
        {
            padding: 1px 8px  !important;
            line-height: 1 !important;
            vertical-align: middle !important;
        }
        .pricing-master>tbody>tr>td, .pricing-master>tbody>tr>th, .pricing-master>tfoot>tr>td, .pricing-master>tfoot>tr>th, .pricing-master>thead>tr>td
        {
            padding: 10px 10px  !important;
            line-height: 1 !important;
            vertical-align: middle !important;
            border: 1px solid;
        }
        .mt-10{
            margin-top: 20px;
        }
        .modalHeader{
            border-bottom: none !important;
            padding: 10px !important;
        }
        .filter-group {
            display: -webkit-box;
            margin-top: 3px;
        }
        .filter {
            display: -webkit-box;
            margin-top: 8px;
        }
        .filter-select {
            width: 18%;
            margin-left: 10px;
        }
        .filter-menu {
            width: 70%;
            margin-left: 10px;
        }
        .header_item1{
            height:30px;
            width: 100px;
            /*text-align: center;*/
            font-size: 12px;
            border:1px solid #ddd;
            border-radius:4px;
            display: inline-block;
            vertical-align: middle;
        }
        .panel.price,
        .panel.price>.panel-heading{
            border-radius:0px;
            -moz-transition: all .3s ease;
            -o-transition:  all .3s ease;
            -webkit-transition:  all .3s ease;
        }
        .panel.price:hover{
            box-shadow: 0px 0px 30px rgba(0,0,0, .2);
        }
        .panel.price:hover>.panel-heading{
            box-shadow: 0px 0px 30px rgba(0,0,0, .2) inset;
        }


        .panel.price>.panel-heading{
            box-shadow: 0px 5px 0px rgba(50,50,50, .2) inset;
            text-shadow:0px 3px 0px rgba(50,50,50, .6);
        }

        .price .list-group-item{
            border-bottom-:1px solid rgba(250,250,250, .5);
        }

        .panel.price .list-group-item:last-child {
            border-bottom-right-radius: 0px;
            border-bottom-left-radius: 0px;
        }
        .panel.price .list-group-item:first-child {
            border-top-right-radius: 0px;
            border-top-left-radius: 0px;
        }

        .price .panel-footer {
            color: #fff;
            border-bottom:0px;
            background-color:  rgba(0,0,0, .1);
            box-shadow: 0px 3px 0px rgba(0,0,0, .3);
        }


        .panel.price .btn{
            box-shadow: 0 -1px 0px rgba(50,50,50, .2) inset;
            border:0px;
        }

        /* green panel */


        .price.panel-green>.panel-heading {
            color: #fff;
            background-color: #57AC57;
            border-color: #71DF71;
            border-bottom: 1px solid #71DF71;
        }


        .price.panel-green>.panel-body {
            color: #fff;
            background-color: #65C965;
        }


        .price.panel-green>.panel-body .lead{
            text-shadow: 0px 3px 0px rgba(50,50,50, .3);
        }

        .price.panel-green .list-group-item {
            color: #333;
            background-color: rgba(50,50,50, .01);
            font-weight:600;
            text-shadow: 0px 1px 0px rgba(250,250,250, .75);
        }

        /* blue panel */


        .price.panel-blue>.panel-heading {
            color: #fff;
            background-color: #608BB4;
            border-color: #78AEE1;
            border-bottom: 1px solid #78AEE1;
        }


        .price.panel-blue>.panel-body {
            color: #fff;
            background-color: #73A3D4;
        }


        .price.panel-blue>.panel-body .lead{
            text-shadow: 0px 3px 0px rgba(50,50,50, .3);
        }

        .price.panel-blue .list-group-item {
            color: #333;
            background-color: rgba(50,50,50, .01);
            font-weight:600;
            text-shadow: 0px 1px 0px rgba(250,250,250, .75);
        }

        /* red price */


        .price.panel-red>.panel-heading {
            color: #fff;
            background-color: #D04E50;
            border-color: #FF6062;
            border-bottom: 1px solid #FF6062;
        }


        .price.panel-red>.panel-body {
            color: #fff;
            background-color: #EF5A5C;
        }




        .price.panel-red>.panel-body .lead{
            text-shadow: 0px 3px 0px rgba(50,50,50, .3);
        }

        .price.panel-red .list-group-item {
            color: #333;
            background-color: rgba(50,50,50, .01);
            font-weight:600;
            text-shadow: 0px 1px 0px rgba(250,250,250, .75);
        }

        /* grey price */


        .price.panel-grey>.panel-heading {
            color: #fff;
            background-color: #6D6D6D;
            border-color: #B7B7B7;
            border-bottom: 1px solid #B7B7B7;
        }


        .price.panel-grey>.panel-body {
            color: #fff;
            background-color: #808080;
        }



        .price.panel-grey>.panel-body .lead{
            text-shadow: 0px 3px 0px rgba(50,50,50, .3);
        }

        .price.panel-grey .list-group-item {
            color: #333;
            background-color: rgba(50,50,50, .01);
            font-weight:600;
            text-shadow: 0px 1px 0px rgba(250,250,250, .75);
        }

        /* white price */


        .price.panel-white>.panel-heading {
            color: #333;
            background-color: #f9f9f9;
            border-color: #ccc;
            border-bottom: 1px solid #ccc;
            text-shadow: 0px 2px 0px rgba(250,250,250, .7);
        }

        .panel.panel-white.price:hover>.panel-heading{
            box-shadow: 0px 0px 30px rgba(0,0,0, .05) inset;
        }

        .price.panel-white>.panel-body {
            color: #fff;
            background-color: #dfdfdf;
        }

        .price.panel-white>.panel-body .lead{
            text-shadow: 0px 2px 0px rgba(250,250,250, .8);
            color:#666;
        }

        .price:hover.panel-white>.panel-body .lead{
            text-shadow: 0px 2px 0px rgba(250,250,250, .9);
            color:#333;
        }

        .price.panel-white .list-group-item {
            color: #333;
            background-color: rgba(50,50,50, .01);
            font-weight:600;
            text-shadow: 0px 1px 0px rgba(250,250,250, .75);
        }

        .button-top {
            margin-top: 18px;
        }
        .download-button {
            margin-left: -38px;
        }
        @media (max-width: 1208px) {
            .download-button {
                margin-left: -27px;
            }
        }
        @media (max-width: 1035px) {
            .download-button {
                margin-left: -18px;
            }
        }
        @media (max-width: 960px) {
            .download-button {
                margin-left: -8px;
            }
        }

        @media (max-width: 767px) {
            .filter-menu {
                width: 23%;
                margin-left: 10px;
            }
            .download-button {
                margin-left: 45px;
            }
            .button-top {
                margin-top: 0px;
            }
        }

        @media (max-width: 516px) {
            .filter-menu {
                width: 38%;
                margin-left: 10px;
            }
        }
    </style>
</head>

<body class="skin-blue sidebar-mini">
@if (!Auth::guest())
    <div class="wrapper">
        <!-- Main Header -->
        <header class="main-header">

            <!-- Logo -->
            <a href="{{url('dashboard')}}" class="logo">
                <img style="width: 150px" src="{{asset('images/logo.png')}}">
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account Menu -->
                        <li class="user user-menu">
                            <a class="fa fa-user">
                                {{Auth::user()->name}}
                            </a>
                        </li>
                        <li class="user user-menu">
                            <a class="fa fa-sign-out" href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Left side column. contains the logo and sidebar -->
        @include('layouts.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
            <button style="display: none" type="button" id="clickEventBtn" class="btn btn-info btn-lg" data-toggle="modal" data-target="#EventModal">Open Modal</button>

            <!-- Modal -->
            <div id="EventModal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header modalHeader">
                            {{--<button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                            <h4 class="modal-title">Assign Ticket</h4>
                        </div>
                        <div class="col-md-12">
                            <h3 id="techicianName"></h3>
                        </div>

                        <form method='post' id="assignTicket" action="{{url('assignTicket')}}">
                            <input type='hidden' name='_token' value='{{csrf_token()}}'>
                            <div id="AppendHtml" class=""></div>
                            <div class="modal-footer">
                                {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
                                <button type="submit" id="assignTicketData" class="btn btn-success">Save</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <!-- Main Footer -->
        <footer class="main-footer" style="max-height: 100px;text-align: center">
            <strong>Copyright © 2016 <a href="#">Company</a>.</strong> All rights reserved.
        </footer>

    </div>
@else
{{--    <nav class="navbar navbar-default navbar-static-top">--}}
{{--        <div class="container">--}}
{{--            <div class="navbar-header">--}}
{{--                <!-- Collapsed Hamburger -->--}}
{{--                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"--}}
{{--                        data-target="#app-navbar-collapse">--}}
{{--                    <span class="sr-only">Toggle Navigation</span>--}}
{{--                    <span class="icon-bar"></span>--}}
{{--                    <span class="icon-bar"></span>--}}
{{--                    <span class="icon-bar"></span>--}}
{{--                </button>--}}
{{--                <!-- Branding Image -->--}}
{{--                <a class="navbar-brand" href="{{ url('/') }}">--}}
{{--                   Teknix Elevators--}}
{{--                </a>--}}
{{--            </div>--}}

{{--            <div class="collapse navbar-collapse" id="app-navbar-collapse">--}}
{{--                <!-- Left Side Of Navbar -->--}}
{{--                <ul class="nav navbar-nav">--}}
{{--                    <li><a href="{{ url('/home') }}">Home</a></li>--}}
{{--                </ul>--}}

{{--                <!-- Right Side Of Navbar -->--}}
{{--                <ul class="nav navbar-nav navbar-right">--}}
{{--                    <!-- Authentication Links -->--}}
{{--                    <li><a href="{{ url('/login') }}">Login</a></li>--}}
{{--                    <li><a href="{{ url('/register') }}">Register</a></li>--}}
{{--                </ul>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </nav>--}}

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Teknix Elevators</a>
            </div>
            <ul class="nav navbar-nav">

                @if(Request::is('crm_production'))
                <li><a href="{{ url('job_wise_production') }}">Job Wise Production</a></li>
                @else
                <li><a href="{{ url('crm_production') }}">CRM Production</a></li>
                @endif

                <li><a href="{{url('crm')}}">CRM</a></li>
                <li><a href="{{url('stage_of_materials')}}">Request for Production</a></li>
                <li><a href="{{url('priority')}}">Standard / Non standard</a></li>
                <li><a href="{{url('dispatch_status')}}">Dispatch status</a></li>
                <li><a href="{{url('dispatch_stage_lot_status')}}">Dispatch stages lot</a></li>
                <li><a href="{{url('dispatch_payment_status')}}">Dispatch Payment status</a></li>
                <li><a href="{{url('manufacture_status')}}">Manufacture Status</a></li>
                <li><a href="{{url('manufacture_stages')}}">Manufacturing -Stage / Lot</a></li>

            </ul>
        </div>
    </nav>
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- jQuery 3.1.1 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/js/adminlte.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyDsHS7O5uo6Ebb2A6UhJSvGTGG8U3Ma9EU&libraries=places" type="text/javascript"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<!--    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>-->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
    <!---select2 jquery--->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
            toastr.info("{{ Session::get('message') }}");
            break;

        case 'warning':
            toastr.warning("{{ Session::get('message') }}");
            break;

        case 'success':
            toastr.success("{{ Session::get('message') }}");
            break;

        case 'error':
            toastr.error("{{ Session::get('message') }}");
            break;
    }
    @endif


{{-- javascript code --}}
    $(document).ready(function() {
            $("#lat_area").addClass("d-none");
            $("#long_area").addClass("d-none");
        });
    google.maps.event.addDomListener(window, 'load', initialize);
    function initialize() {
        var input = document.getElementById('autocomplete');
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();
            $('#latitude').val(place.geometry['location'].lat());
            $('#longitude').val(place.geometry['location'].lng());
    // --------- show lat and long ---------------
            $("#lat_area").removeClass("d-none");
            $("#long_area").removeClass("d-none");
        });
    }
   $(".contact_number").keypress(function (e) {
        var maxLength = 10;
        var textlen = maxLength - $(this).val().length;
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
           //display error message
           toastr.clear();
           $(this).addClass('invalid');
           $(this).addClass('invalid');
           toastr.error('Enter numbers only');
           return false;
       }
       else{

            $('#contact_number').text(textlen);
            $(this).removeClass('invalid');
       }
   });

    //
    $(".list-menu li").click(function(){
        $(this).addClass('active');
        $(this).parent().parent().find('.dcjq-parent').addClass('active');
    });

    $("body").on("click", ".overlay01", function () {
        setTimeout(
            function () {
                $(".sub-menu").toggleClass("active");
            }, 500);
    });
    $(".sub-menu a").click(function () {
        $(this).parent(".sub-menu").children("ul").slideToggle("100");
        $(this).find(".right").toggleClass("fa-caret-up fa-caret-down");
    });



    $('.name').keypress(function (e) {
        var maxLength = 50;
        var textlen = maxLength - $(this).val().length;
        var regex = new RegExp("^[a-zA-Z]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        else
        {
            e.preventDefault();
            $('#name').text(textlen);
            toastr.error('Please Enter Characters only');
            return false;
        }
    });


    $(".price").keypress(function (e) {
        // var maxLength = 6;
        // var textlen = maxLength - $(this).val().length;
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {

            $(this).addClass('invalid');
            toastr.clear();
            toastr.error('Enter numbers only');
            return false;
        }
        else{

            // $('#price').text(textlen);
            $(this).removeClass('invalid');
        }
    });


    var pusher = new Pusher('{{env('PUSHER_APP_KEY')}}', {
        cluster:'{{env('PUSHER_APP_CLUSTER')}}',
        encrypted: true
    });

    jQuery( document ).ready( function( $ ) {
        var html = '';
        var channel3 = pusher.subscribe('assign_ticket_notification_admin');
        channel3.bind('assign_ticket_notification_admin', function(data) {
            html +="<input type='hidden' name='id' value='"+data.data.ticketId+"'>" +
                "<div class='col-md-12'>" +
                "<label>Assigned To</label>" +
                "<select id='assigned_to' name='assigned_to' class='form-control select2'>" +
                "<option selected disabled>Select Team Leader</option>";
                if(data.data.teams.length > 0){
                    $.each( data.data.teams, function( key, value ) {
                        html+='<option value="'+value.id+'">'+value.title+'_'+value.name+'_'+value.zone+'</option>';
                    });
                }
        html +="</select>" +
                "</div>" +
            "<div class='col-md-12 mt-10'>" +
            "<label>Priority Status (Is Urgent) :</label>" +
            "<div class='clearfix'></div>" +
            "<label class='radio-inline'>" +
            "<input type='radio' name='is_urgent' value='yes'>Yes" +
            "</label>" +
            "<label class='radio-inline'>" +
            "<input type='radio' name='is_urgent' checked value='no'>No" +
            "</label>" +
            "</div>";
            $('#AppendHtml').html(html);
            $('#techicianName').html(data.data.technicianName.name + ' has declined the ticket, Assign Now');
            $('#clickEventBtn').click();
        });
        $( "#assignTicketData" ).click(function( event ) {
            var assigned_to = $('#assigned_to').val();
            if(assigned_to ==null)
            {
                event.preventDefault();
                toastr.error('Assign Team Leader');
            }
            else
            {
                $( "#assignTicket" ).submit();
            }
        });
    });
</script>

    @yield('scripts')
</body>
</html>
