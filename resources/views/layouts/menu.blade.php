
<li class="{{ Request::is('dashboard*') ? 'active' : '' }}">
    <a href="{{ route('dashboard.index') }}"><i class="fa fa-tachometer"></i><span>Dashboard</span></a>
</li>

<li class="{{ Request::is('customers*') ? 'active' : '' }}">
    <a href="{{ route('customers.index') }}"><i class="fa fa-user-circle-o"></i><span>Customers</span></a>
</li>

<li class="{{ Request::is('teams*') ? 'active' : '' }}">
    <a href="{{ route('teams.index') }}"><i class="fa fa-group"></i> <span>Technician Teams</span></a>
</li>

<li class="{{ Request::is('backupTeams*') ? 'active' : '' }}">
    <a href="{{ route('backupTeams.index') }}"><i class="fa fa-group"></i><span>Service Teams</span></a>
</li>

<li class="{{ Request::is('plans*') ? 'active' : '' }}">
    <a href="{{ route('plans.index') }}"><i class="fa fa-edit"></i> <span>Plans</span></a>
</li>

<li class="{{ Request::is('settings*') ? 'active' : '' }}">
    <a href="{{ url('settings') }}"><i class="fa fa-gear fa-spin"></i> <span>Settings</span></a>
</li>

{{--<li class="{{ Request::is('ticket/newReports*') ? 'active' : '' }}">--}}
    {{--<a href="{{ url('ticket/newReports') }}"><i class="fa fa-list-alt"> </i><span> Reports</span></a>--}}
{{--</li>--}}

<li class="{{ Request::is('quotes*') ? 'active' : '' }}">
    <a href="{{ url('quotes') }}"><i class="fa fa-thumbs-up"></i> <span>Generated Quotes</span></a>
</li>

@if (auth()->check())
    @if (auth()->user()->role == 1)
<li class="{{ Request::is('listUser*') ? 'active' : '' }}">
    <a href="{{ url('listUser') }}"><i class="fa fa-user"></i> <span>Add User</span></a>
</li>
@else
@endif

<li class="{{ Request::is('paymenthistory*') ? 'active' : '' }}">
    <a href="{{url('paymenthistory')}}"><i class="fa fa-product-hunt"></i> <span>Payment History</span></a>
</li>
<li class="{{ Request::is('paymentamc/amcpayment*') ? 'active' : '' }}">
    <a href="{{url('paymentamc/amcpayment')}}"><i class="fa fa-product-hunt"></i> <span>AMC payment</span></a>
</li>
<li></li>
@endif


{{----serive tickets historryyy--------}}

<div class="wrapper">
    <div class="nav-menu">
        <ul>
            <nav class='animated bounceInDown'>
                <li class="sub-menu" id="menu"><a href="#" id="menu-toggle" class="dcjq-parent"><i class="fa fa-list"></i><span class="lift-pages">Service Master</span>
                        <div class='fa @if(Request::is('service') || Request::is('services/History*')|| Request::is('servicesLists*')) fa-caret-down @else fa-caret-up @endif right' style="margin-left: 46px;"></div></a>
                    <ul class="list-menu" @if(Request::is('service') || Request::is('services/History*')||Request::is('servicesLists*'))
                    @else style="display: none;" @endif>

                        <li class="{{ Request::is('service') ? 'active' : '' }}">
                            <a href="{{ url('service') }}"><i class="fa fa-th-list"></i> <span>Service</span></a>
                        </li>
                        <li class="{{ Request::is('services/History*') ? 'active' : '' }}">
                            <a href="{{ url('services/History') }}"><i class="fa fa-history"></i> <span>Service History</span></a>
                        </li>
                        <li class="{{ Request::is('servicesLists*') ? 'active' : '' }}">
                            <a href="{{ route('servicesLists.index') }}"><i class="fa fa-edit"></i> <span>Service List</span></a>
                        </li>
                    </ul>
                </li>
            </nav>
        </ul>
    </div>
</div>


{{---ticeket raised and history ticket--------------}}

<div class="wrapper">
    <div class="nav-menu">
        <ul>
            <nav class='animated bounceInDown'>
                <li class="sub-menu" id="menu"><a href="#" id="menu-toggle" class="dcjq-parent"><i class="fa fa fa-hand-o-up"></i>  <span class="lift-pages">Ticket Master</span>
                        <div class='fa @if(Request::is('tickets*') || Request::is('ticketHistory*')|| Request::is('cancelTicket*')) fa-caret-down @else fa-caret-up @endif right' style="margin-left: 53px;"></div></a>
                    <ul class="list-menu" @if(Request::is('tickets*') || Request::is('ticketHistory*')|| Request::is('cancelTicket*'))
                    @else style="display: none;" @endif>
                        <li class="{{ Request::is('tickets*') ? 'active' : '' }}">
                            <a href="{{ url('tickets') }}"><i class="fa fa-hand-o-right"></i> <span>Raise Tickets</span></a>
                        </li>
                        <li class="{{ Request::is('ticketHistory*') ? 'active' : '' }}">
                            <a href="{{ url('ticketHistory') }}"><i class="fa fa-history"></i> <span>Tickets History</span></a>
                        </li>
                        <li class="{{ Request::is('cancelTicket*') ? 'active' : '' }}">
                            <a href="{{ url('cancelTicket') }}"><i class="fa fa-remove"></i> <span>Closed Reasons</span></a>
                        </li>
                    </ul>
                </li>
            </nav>
        </ul>
    </div>
</div>


{{--customer products ,product models------}}
<div class="wrapper">
    <div class="nav-menu">
        <ul>
            <nav class='animated bounceInDown'>
                <li class="sub-menu" id="menu"><a href="#" id="menu-toggle" class="dcjq-parent"><i class="fa fa-shopping-bag"></i> <span class="lift-pages">Product Master</span>
                        <div class='fa @if(Request::is('customerProducts*') || Request::is('productsModels*')) fa-caret-down @else fa-caret-up @endif right' style="margin-left: 39px;"></div></a>
                    <ul class="list-menu" @if(Request::is('customerProducts*') || Request::is('productsModels*'))
                    @else style="display: none;" @endif>
                        <li class="{{ Request::is('customerProducts*') ? 'active' : '' }}">
                            <a href="{{ route('customerProducts.index') }}"><i class="fa fa-shopping-bag"></i> <span>Customer Projects</span></a>
                        </li>
                        <li class="{{ Request::is('productsModels*') ? 'active' : '' }}">
                            <a href="{{ route('productsModels.index') }}"><i class="fa fa-product-hunt"></i> <span>Products Models</span></a>
                        </li>
                        <li class="{{ Request::is('customer/note*') ? 'active' : '' }}">
                            <a href="{{ url('customer/note') }}"><i class="fa fa-edit"></i> <span>Customer Note</span></a>
                        </li>
                    </ul>
                </li>
            </nav>
        </ul>
    </div>
</div>


{{--parts ,parts requests------}}
<div class="wrapper">
    <div class="nav-menu">
        <ul>
            <nav class='animated bounceInDown'>
                <li class="sub-menu" id="menu"><a href="#" id="menu-toggle" class="dcjq-parent"><i class="fa fa-cogs"></i><span class="lift-pages">Parts Master</span>
                        <div class='fa @if(Request::is('parts*') || Request::is('Request*') )) fa-caret-down @else fa-caret-up @endif right' style="margin-left: 56px;"></div></a>
                    <ul class="list-menu" @if(Request::is('parts*') || Request::is('Request*'))
                    @else style="display: none;" @endif>
                        <li class="{{ Request::is('parts*') ? 'active' : '' }}">
                            <a href="{{ route('parts.index') }}"><i class="fa fa-cogs"></i> <span>Parts</span></a>
                        </li>
                        <li class="{{ Request::is('Request*') ? 'active' : '' }}">
                            <a href="{{route('Request.index')}}"><i class="fa fa-edit"></i> <span>Part Requests</span></a>
                        </li>
                    </ul>
                </li>
            </nav>
        </ul>
    </div>
</div>

{{---master anouncement,holdreason--------------}}
<div class="wrapper">

    <div class="nav-menu">
        <ul>
            <nav class='animated bounceInDown'>
                <li class="sub-menu" id="menu"><a href="#" id="menu-toggle" class="dcjq-parent"><i class="fa fa-user"> </i><span class="lift-pages">Master</span>
                        <div class='fa @if(Request::is('announcements*') || Request::is('forwardReasons*') || Request::is('holdReasons*') || Request::is('problems*') ||  Request::is('noOfFloors*') ||  Request::is('passengerCapacities*')|| Request::is('closeTickets*')||  Request::is('productStatuses*') || Request::is('paymen/history*')) fa-caret-down @else fa-caret-up @endif right' style="margin-left: 97px;"></div></a>
                    <ul class="list-menu" @if(Request::is('announcements*') || Request::is('forwardReasons*') || Request::is('holdReasons*') || Request::is('problems*') || Request::is('noOfFloors*') ||  Request::is('passengerCapacities*') ||  Request::is('closeTickets*') ||  Request::is('productStatuses*') || Request::is('paymen/history*') )
                    @else style="display: none;" @endif>
                        <li class="announcements @if(Request::is('announcements*')) active @endif">
                            <a href="{{ route('announcements.index') }}"><i class="fa fa-bullhorn"></i> <span>announcements</span></a>
                        </li>
                        <li class="forwardReasons @if(Request::is('forwardReasons*')) active @endif">
                            <a href="{{ route('forwardReasons.index') }}" ><i class="fa fa-forward"></i> <span>Forward  Reasons</span></a>
                        </li>
                        <li class="holdReasons @if(Request::is('holdReasons*')) active @endif">
                            <a href="{{ route('holdReasons.index') }}"><i class="fa fa-edit"></i> <span>Hold Reasons</span></a>
                        </li>
                        <li class="problems @if(Request::is('problems*')) active @endif">
                            <a href="{{ route('problems.index') }}"><i class="fa fa-wrench"></i> <span>Customer Problems</span></a>
                        </li>

                        <li class="{{ Request::is('noOfFloors*') ? 'active' : '' }}">
                            <a href="{{ url('noOfFloors') }}"><i class="fa fa-hand-o-right"></i> <span>No of Floors</span></a>
                        </li>

                        <li class="{{ Request::is('passengerCapacities*') ? 'active' : '' }}">
                            <a href="{{ route('passengerCapacities.index') }}"><i class="fa fa-edit"></i> <span>passengerCapacities</span></a>
                        </li>

                        <li class="{{ Request::is('closeTickets*') ? 'active' : '' }}">
                            <a href="{{ route('closeTickets.index') }}"><i class="fa fa-close"></i> <span>Close Tickets</span></a>
                        </li>

                        <li class="{{ Request::is('productStatuses*') ? 'active' : '' }}">
                            <a href="{{ route('productStatuses.index') }}"><i class="fa fa-arrow-right"></i> <span>Product Status</span></a>
                        </li>
                        <li class="{{ Request::is('technicianAssists*') ? 'active' : '' }}">
                            <a href="{{ route('technicianAssists.index') }}"><i class="fa fa-male"></i> <span>Technician  Assist</span></a>
                        </li>
                        <li class="{{ Request::is('zones*') ? 'active' : '' }}">
                            <a href="{{ route('zones.index') }}"><i class="fa fa-map-marker"></i> <span>Zones</span></a>
                        </li>
                        <li class="{{ Request::is('activity*') ? 'active' : '' }}">
                            <a href="{{ url('/activity') }}"><i class="fa fa-bar-chart-o"></i> <span>Activity</span></a>
                        </li>
                    </ul>
                </li>
            </nav>
        </ul>
    </div>
</div>


{{----production--------}}
@if(\Auth::user()->email == 'admin@gmail.com')
    <li class="{{ Request::is('teams*') ? 'active' : '' }}">
        <a href="{{ url('pricing_master') }}"><i class="fa fa-group"></i> <span>Pricing Master</span></a>
    </li>

<div class="wrapper">
    <div class="nav-menu">
        <ul>
            <nav class='animated bounceInDown'>
                <li class="sub-menu" id="menu"><a href="#" id="menu-toggle" class="dcjq-parent"><i class="fa fa-list"></i><span class="lift-pages">Production Master</span>
                        <div class='fa @if(Request::is('manufacture_production') || Request::is('manufacture') || Request::is('production_request') || Request::is('stage_of_materials*') || Request::is('priority*') || Request::is('dispatch_status*') || Request::is('manufacture_status*') || Request::is('manufacture_stages*') || Request::is('crm*') || Request::is('dispatch_payment_status*') || Request::is('dispatch_stage_lot_status*') || Request::is('job_wise_production*') || Request::is('car_bracket*') || Request::is('car_bracket_readiness_status*') || Request::is('cwt_bracket*') || Request::is('ld_opening*') || Request::is('ld_finish*') || Request::is('machine_channel*') || Request::is('car_frame*') || Request::is('machine*')  || Request::is('cwt_frame*') || Request::is('controller*') || Request::is('car_door_opening*') || Request::is('cop_and_lop*') || Request::is('harness*') || Request::is('rope_available*') || Request::is('osg_assy_available*') || Request::is('job_wise_production*') ) fa-caret-down @else fa-caret-up @endif right' style="margin-left: 69px;"></div></a>
                    <ul class="list-menu" @if(Request::is('manufacture_production') || Request::is('manufacture') || Request::is('production_request') || Request::is('stage_of_materials*') || Request::is('priority*') || Request::is('dispatch_status*') || Request::is('manufacture_status*') || Request::is('manufacture_stages*') || Request::is('crm*') || Request::is('dispatch_payment_status*') || Request::is('dispatch_stage_lot_status*') || Request::is('job_wise_production*')  || Request::is('car_bracket*') || Request::is('car_bracket_readiness_status*') || Request::is('cwt_bracket*') || Request::is('ld_opening*') || Request::is('ld_finish*') || Request::is('machine_channel*')  || Request::is('car_frame*') || Request::is('machine*') || Request::is('cwt_frame*') || Request::is('controller*') || Request::is('car_door_opening*') || Request::is('cop_and_lop*') || Request::is('harness*') || Request::is('rope_available*') || Request::is('osg_assy_available*')  || Request::is('job_wise_production*') )
                    @else style="display: none;" @endif>

{{--                        <li class="{{ Request::is('manufacture_production') ? 'active' : '' }}">--}}
{{--                            <a href="{{ url('manufacture_production') }}"><i class="fa fa-th-list"></i> <span>Manufacture & Dispatch Traction</span></a>--}}
{{--                        </li>--}}
{{--                        <li class="{{ Request::is('production_request') ? 'active' : '' }}">--}}
{{--                            <a href="{{ url('production_request') }}"><i class="fa fa-th-list"></i> <span>Production Request</span></a>--}}
{{--                        </li>--}}
{{--                        <li class="{{ Request::is('manufacture') ? 'active' : '' }}">--}}
{{--                            <a href="{{ url('manufacture') }}"><i class="fa fa-th-list"></i> <span>Production Status - Factory</span></a>--}}
{{--                        </li>--}}

{{--                        <li class="{{ Request::is('stage_of_materials*') ? 'active' : '' }}">--}}
{{--                            <a href="{{ url('stage_of_materials') }}"><i class="fa fa-history"></i> <span>Stage Of Materials</span></a>--}}
{{--                        </li>--}}
{{--                        <li class="{{ Request::is('priority*') ? 'active' : '' }}">--}}
{{--                            <a href="{{ url('priority') }}"><i class="fa fa-edit"></i> <span>Priority</span></a>--}}
{{--                        </li>--}}
{{--                        <li class="{{ Request::is('dispatch_status*') ? 'active' : '' }}">--}}
{{--                            <a href="{{ url('dispatch_status') }}"><i class="fa fa-edit"></i> <span>Dispatch status</span></a>--}}
{{--                        </li>--}}
{{--                        <li class="{{ Request::is('manufacture_status*') ? 'active' : '' }}">--}}
{{--                            <a href="{{ url('manufacture_status') }}"><i class="fa fa-edit"></i> <span>Manufacture Status</span></a>--}}
{{--                        </li>--}}
{{--                        <li class="{{ Request::is('manufacture_stages*') ? 'active' : '' }}">--}}
{{--                            <a href="{{ url('manufacture_stages') }}"><i class="fa fa-edit"></i> <span>Manufacture Stages</span></a>--}}
{{--                        </li>--}}
{{--                        <li class="{{ Request::is('crm*') ? 'active' : '' }}">--}}
{{--                            <a href="{{ url('crm') }}"><i class="fa fa-edit"></i> <span>CRM</span></a>--}}
{{--                        </li>--}}
{{--                        <li class="{{ Request::is('dispatch_payment_status*') ? 'active' : '' }}">--}}
{{--                            <a href="{{ url('dispatch_payment_status') }}"><i class="fa fa-edit"></i> <span>Dispatch Payment Status</span></a>--}}
{{--                        </li>--}}
{{--                        <li class="{{ Request::is('dispatch_stage_lot_status*') ? 'active' : '' }}">--}}
{{--                            <a href="{{ url('dispatch_stage_lot_status') }}"><i class="fa fa-edit"></i> <span>Dispatch Stage/Lot Status</span></a>--}}
{{--                        </li>--}}

                        <li class="{{ Request::is('crm_production') ? 'active' : '' }}">
                            <a href="{{ url('crm_production') }}"><i class="fa fa-th-list"></i> <span>CRM Production Request</span></a>
                        </li>

{{--                        <li class="{{ Request::is('car_bracket') ? 'active' : '' }}">--}}
{{--                            <a href="{{ url('car_bracket') }}"><i class="fa fa-th-list"></i> <span>Car Bracket</span></a>--}}
{{--                        </li>--}}
{{--                        <li class="{{ Request::is('car_bracket_readiness_status') ? 'active' : '' }}">--}}
{{--                            <a href="{{ url('car_bracket_readiness_status') }}"><i class="fa fa-th-list"></i> <span>Car Bracket Readiness Status</span></a>--}}
{{--                        </li>--}}
{{--                        <li class="{{ Request::is('cwt_bracket') ? 'active' : '' }}">--}}
{{--                            <a href="{{ url('cwt_bracket') }}"><i class="fa fa-th-list"></i> <span>Cwt Bracket</span></a>--}}
{{--                        </li>--}}
{{--                        <li class="{{ Request::is('ld_opening') ? 'active' : '' }}">--}}
{{--                            <a href="{{ url('ld_opening') }}"><i class="fa fa-th-list"></i> <span>LD Opening</span></a>--}}
{{--                        </li>--}}
{{--                        <li class="{{ Request::is('ld_finish') ? 'active' : '' }}">--}}
{{--                            <a href="{{ url('ld_finish') }}"><i class="fa fa-th-list"></i> <span>LD Finish</span></a>--}}
{{--                        </li>--}}
{{--                        <li class="{{ Request::is('machine_channel') ? 'active' : '' }}">--}}
{{--                            <a href="{{ url('machine_channel') }}"><i class="fa fa-th-list"></i> <span>Machine Channel</span></a>--}}
{{--                        </li>--}}
{{--                        <li class="{{ Request::is('machine') ? 'active' : '' }}">--}}
{{--                            <a href="{{ url('machine') }}"><i class="fa fa-th-list"></i> <span>Machine</span></a>--}}
{{--                        </li>--}}
{{--                        <li class="{{ Request::is('car_frame') ? 'active' : '' }}">--}}
{{--                            <a href="{{ url('car_frame') }}"><i class="fa fa-th-list"></i> <span>Car Frame</span></a>--}}
{{--                        </li>--}}
{{--                        <li class="{{ Request::is('cwt_frame') ? 'active' : '' }}">--}}
{{--                            <a href="{{ url('cwt_frame') }}"><i class="fa fa-th-list"></i> <span>Cwt Frame</span></a>--}}
{{--                        </li>--}}
{{--                        <li class="{{ Request::is('controller') ? 'active' : '' }}">--}}
{{--                            <a href="{{ url('controller') }}"><i class="fa fa-th-list"></i> <span>Controller</span></a>--}}
{{--                        </li>--}}
{{--                        <li class="{{ Request::is('car_door_opening') ? 'active' : '' }}">--}}
{{--                            <a href="{{ url('car_door_opening') }}"><i class="fa fa-th-list"></i> <span>Car Door Opening</span></a>--}}
{{--                        </li>--}}
{{--                        <li class="{{ Request::is('cop_and_lop') ? 'active' : '' }}">--}}
{{--                            <a href="{{ url('cop_and_lop') }}"><i class="fa fa-th-list"></i> <span>Cop And Lop</span></a>--}}
{{--                        </li>--}}
{{--                        <li class="{{ Request::is('harness') ? 'active' : '' }}">--}}
{{--                            <a href="{{ url('harness') }}"><i class="fa fa-th-list"></i> <span>Harness</span></a>--}}
{{--                        </li>--}}
{{--                        <li class="{{ Request::is('rope_available') ? 'active' : '' }}">--}}
{{--                            <a href="{{ url('rope_available') }}"><i class="fa fa-th-list"></i> <span>Rope Available</span></a>--}}
{{--                        </li>--}}
{{--                        <li class="{{ Request::is('osg_assy_available') ? 'active' : '' }}">--}}
{{--                            <a href="{{ url('osg_assy_available') }}"><i class="fa fa-th-list"></i> <span>OSG Assy Available</span></a>--}}
{{--                        </li>--}}

                        <li class="{{ Request::is('job_wise_production') ? 'active' : '' }}">
                            <a href="{{ url('job_wise_production') }}"><i class="fa fa-th-list"></i> <span>Job Wise Production And Dispatch Status</span></a>
                        </li>

                    </ul>
                </li>
            </nav>
        </ul>
    </div>
</div>
@endif

<div class="wrapper">
    <div class="nav-menu">
        <ul>
            <nav class='animated bounceInDown'>
                <li class="sub-menu" id="menu"><a href="#" id="menu-toggle" class="dcjq-parent"><i class="fa fa-list"></i><span class="lift-pages">PDF</span>
                        <div class='fa @if(Request::is('vantage_advertising') || Request::is('mr_charanjiv_khattar')|| Request::is('jayanthilal') || Request::is('jayasheela')) fa-caret-down @else fa-caret-up @endif right' style="margin-left: 46px;"></div></a>
                    <ul class="list-menu" @if(Request::is('vantage_advertising') || Request::is('mr_charanjiv_khattar')||Request::is('jayanthilal') || Request::is('jayasheela'))
                    @else style="display: none;" @endif>

                        <li class="{{ Request::is('vantage_advertising') ? 'active' : '' }}">
                            <a href="{{ url('vantage_advertising') }}"><i class="fa-caret-right" ></i> <span>vantage_advertising pdf</span></a>
                        </li>
                        <li class="{{ Request::is('mr_charanjiv_khattar') ? 'active' : '' }}">
                            <a href="{{ url('mr_charanjiv_khattar') }}"><i class = "fa-caret-right" ></i> <span>mr_charanjiv_khattar pdf</span></a>
                        </li>
                        <li class="{{ Request::is('jayanthilal') ? 'active' : '' }}">
                            <a href="{{ url('jayanthilal') }}"><i class = "fa-caret-right" ></i> <span>jayanthilal pdf</span></a>
                        </li>
                        <li class="{{ Request::is('jayasheela') ? 'active' : '' }}">
                            <a href="{{ url('jayasheela') }}"><i class = "fa-caret-right" ></i> <span>jayasheela pdf</span></a>
                        </li>

                    </ul>
                </li>
            </nav>
        </ul>
    </div>
</div>

<li class="{{ Request::is('ticketReport*') ? 'active' : '' }}">
    <a href="{{ url('ticketReport') }}"><i class="fa fa-history"></i> <span>Tickets Report</span></a>
</li>
