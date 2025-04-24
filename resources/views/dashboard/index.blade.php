
@extends('layouts.app')
<style>

    .small-box .icon {
        top: 5px !important;
    }
    .teck{
        color:white;
    }#bar-chart *{
         font-family:open sans;
     }

    #chart-title{
        width:100%;
        text-align:center;
        font-size:18px;
        font-family:open sans;
    }

    #bar-chart{
        width:1200px;
        height:350px;
        margin:auto;
    }

</style>
@section('content')
    <section class="content-header">
        <h1 class="pull-right">
        </h1>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box btn-info">
                    <div class="inner">
                        <h3>{{$customers}}</h3>
                        <a href="{{url('customers')}}"><p class="teck">Customers</p></a>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{url('customers')}}" class="small-box-footer">More info <i class="glyphicon glyphicon-circle-arrow-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box btn-success">
                    <div class="inner">
                        <h3>{{$teams}}</h3>
                        <a href="{{url('teams')}}"><p class="teck">Teams</p></a>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{url('teams')}}" class="small-box-footer">More info <i class="glyphicon glyphicon-circle-arrow-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box btn-warning">
                    <div class="inner">
                        <h3>{{$customerproduct}}</h3>

                       <a href="{{url('customerProducts')}}"> <p class="teck">Customer Products</p></a>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{url('customerProducts')}}" class="small-box-footer">More info <i class="glyphicon glyphicon-circle-arrow-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box btn-danger">
                    <div class="inner">
                        <h3>{{$raisedtickets}}</h3>
                        <a href="{{url('tickets')}}"><p class="teck">Raised Tickets</p></a>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="{{url('tickets')}}" class="small-box-footer">More info <i class="glyphicon glyphicon-circle-arrow-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>

<!--        <div class="row">-->
<!--            <div class="col-md-4 col-lg-4 grid-margin stretch-card">-->
<!--                <div class="card">-->
<!--                    <div class="card-body">-->
<!--                        <h6 class="card-title">Daily Sales</h6>-->
<!--                        <div class="w-75 mx-auto">-->
<!--                            <div class="d-flex justify-content-between text-center">-->
<!--                            </div>-->
<!--                            <div id="dashboard-donut-chart" style="height:250px"><svg height="250" version="1.1" width="226.548" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="overflow: hidden; position: relative; left: -0.0149116px; top: -0.0416822px;"><desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.2.0</desc><defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs><path fill="none" stroke="#03a9f3" d="M113.274,193.84933333333333A68.84933333333333,68.84933333333333,0,0,0,178.53444503308828,146.9386648301055" stroke-width="2" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path><path fill="#03a9f3" stroke="#ffffff" d="M113.274,196.84933333333333A71.84933333333333,71.84933333333333,0,0,0,181.3780649437037,147.89460719445154L206.42530103194005,156.31475997124812A98.274,98.274,0,0,1,113.274,223.274Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#00c292" d="M178.53444503308828,146.9386648301055A68.84933333333333,68.84933333333333,0,0,0,51.538441859469685,94.5212933095637" stroke-width="2" opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 1;"></path><path fill="#00c292" stroke="#ffffff" d="M181.3780649437037,147.89460719445154A71.84933333333333,71.84933333333333,0,0,0,48.8484132788745,93.19323222829482L20.670662789204528,79.28193996434555A103.274,103.274,0,0,1,211.16466754963244,157.90799724515824Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#dddddd" d="M51.538441859469685,94.5212933095637A68.84933333333333,68.84933333333333,0,0,0,113.25237034437535,193.84932993575495" stroke-width="2" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path><path fill="#dddddd" stroke="#ffffff" d="M48.8484132788745,93.19323222829482A71.84933333333333,71.84933333333333,0,0,0,113.25142786659478,196.84932978771087L113.24312631286398,223.2739951503725A98.274,98.274,0,0,1,25.15404375686316,81.4953750997937Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="113.274" y="115" text-anchor="middle" font-family="&quot;Arial&quot;" font-size="15px" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: Arial; font-size: 15px; font-weight: 800;" font-weight="800" transform="matrix(1.0725,0,0,1.0725,-8.2306,-9.1028)" stroke-width="0.9323649950616805"><tspan dy="5.71875" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">In-Store Sales</tspan></text><text x="113.274" y="135" text-anchor="middle" font-family="&quot;Arial&quot;" font-size="14px" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: Arial; font-size: 14px;" transform="matrix(1.5049,0,0,1.5049,-57.1922,-64.3121)" stroke-width="0.6644944516528846"><tspan dy="4.765625" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">48%</tspan></text></svg></div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-md-6 col-lg-4 grid-margin stretch-card">-->
<!--                <div class="card">-->
<!--                    <div class="card-body">-->
<!--                        <h6 class="card-title">Total Revenue</h6>-->
<!--                        <div class="w-75 mx-auto">-->
<!--                            <div class="d-flex justify-content-between text-center mb-5">-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div id="morris-line-example" style="height: 250px; position: relative; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"><svg height="250" version="1.1" width="254" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="overflow: hidden; position: relative; left: -0.342306px; top: -0.0327558px;"><desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.2.0</desc><defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs><text x="32.53125" y="211.65625" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="3.8125" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">0</tspan></text><text x="32.53125" y="164.9921875" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="3.8046875" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">25</tspan></text><text x="32.53125" y="118.328125" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="3.8125" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">50</tspan></text><text x="32.53125" y="71.6640625" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="3.8046875" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">75</tspan></text><text x="32.53125" y="25" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="3.8125" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">100</tspan></text><text x="229.182" y="224.15625" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,6.6719)"><tspan dy="3.8125" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2011</tspan></text><text x="155.56203970427163" y="224.15625" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,6.6719)"><tspan dy="3.8125" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2009</tspan></text><text x="81.84123014786418" y="224.15625" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,6.6719)"><tspan dy="3.8125" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2007</tspan></text><path fill="none" stroke="#fb9678" d="M45.03125,211.65625C54.23374503696604,175.25828125,72.63873511089814,68.86421875,81.84123014786418,66.06437500000001C91.04372518483022,63.26453125000001,109.44871525876232,182.73346827975377,118.65121029572836,189.2575C127.87891764786417,195.79940577975376,146.33433235213582,138.88840030779753,155.56203970427163,118.328125C164.76453474123767,97.82402530779754,183.16952481516978,28.499804687500003,192.37201985213582,25C201.57451488910186,21.5001953125,219.97950496303395,73.99726562500001,229.182,90.3296875" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#dadada" d="M45.03125,118.328125C54.23374503696604,106.662109375,72.63873511089814,66.99765625,81.84123014786418,71.6640625C91.04372518483022,76.33046875,109.44871525876232,146.33932968536251,118.65121029572836,155.659375C127.87891764786417,165.00495468536252,146.33433235213582,155.67214218536253,155.56203970427163,146.32656250000002C164.76453474123767,137.00651718536253,183.16952481516978,91.02964843750001,192.37201985213582,80.99687500000002C201.57451488910186,70.96410156250002,219.97950496303395,69.79750000000001,229.182,66.06437500000001" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><circle cx="45.03125" cy="211.65625" r="4" fill="#fb9678" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="81.84123014786418" cy="66.06437500000001" r="4" fill="#fb9678" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="118.65121029572836" cy="189.2575" r="4" fill="#fb9678" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="155.56203970427163" cy="118.328125" r="4" fill="#fb9678" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="192.37201985213582" cy="25" r="4" fill="#fb9678" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="229.182" cy="90.3296875" r="4" fill="#fb9678" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="45.03125" cy="118.328125" r="4" fill="#dadada" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="81.84123014786418" cy="71.6640625" r="4" fill="#dadada" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="118.65121029572836" cy="155.659375" r="4" fill="#dadada" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="155.56203970427163" cy="146.32656250000002" r="4" fill="#dadada" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="192.37201985213582" cy="80.99687500000002" r="4" fill="#dadada" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="229.182" cy="66.06437500000001" r="4" fill="#dadada" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle></svg></div>-->
<!--                        <div class="w-75 mx-auto">-->
<!--                            <div class="d-flex justify-content-between text-center mt-5">-->
<!---->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!---->
<!--            <div class="col-md-6 col-lg-4 grid-margin stretch-card">-->
<!--                <div class="card">-->
<!--                    <div class="card-body">-->
<!--                        <h6 class="card-title">Total Revenue</h6>-->
<!--                        <div class="w-75 mx-auto">-->
<!--                            <div class="d-flex justify-content-between text-center mb-5">-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div id="morris-line-example" style="height: 250px; position: relative; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"><svg height="250" version="1.1" width="254" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="overflow: hidden; position: relative; left: -0.342306px; top: -0.0327558px;"><desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.2.0</desc><defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs><text x="32.53125" y="211.65625" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="3.8125" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">0</tspan></text><text x="32.53125" y="164.9921875" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="3.8046875" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">25</tspan></text><text x="32.53125" y="118.328125" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="3.8125" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">50</tspan></text><text x="32.53125" y="71.6640625" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="3.8046875" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">75</tspan></text><text x="32.53125" y="25" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="3.8125" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">100</tspan></text><text x="229.182" y="224.15625" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,6.6719)"><tspan dy="3.8125" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2011</tspan></text><text x="155.56203970427163" y="224.15625" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,6.6719)"><tspan dy="3.8125" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2009</tspan></text><text x="81.84123014786418" y="224.15625" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,6.6719)"><tspan dy="3.8125" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2007</tspan></text><path fill="none" stroke="#fb9678" d="M45.03125,211.65625C54.23374503696604,175.25828125,72.63873511089814,68.86421875,81.84123014786418,66.06437500000001C91.04372518483022,63.26453125000001,109.44871525876232,182.73346827975377,118.65121029572836,189.2575C127.87891764786417,195.79940577975376,146.33433235213582,138.88840030779753,155.56203970427163,118.328125C164.76453474123767,97.82402530779754,183.16952481516978,28.499804687500003,192.37201985213582,25C201.57451488910186,21.5001953125,219.97950496303395,73.99726562500001,229.182,90.3296875" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#dadada" d="M45.03125,118.328125C54.23374503696604,106.662109375,72.63873511089814,66.99765625,81.84123014786418,71.6640625C91.04372518483022,76.33046875,109.44871525876232,146.33932968536251,118.65121029572836,155.659375C127.87891764786417,165.00495468536252,146.33433235213582,155.67214218536253,155.56203970427163,146.32656250000002C164.76453474123767,137.00651718536253,183.16952481516978,91.02964843750001,192.37201985213582,80.99687500000002C201.57451488910186,70.96410156250002,219.97950496303395,69.79750000000001,229.182,66.06437500000001" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><circle cx="45.03125" cy="211.65625" r="4" fill="#fb9678" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="81.84123014786418" cy="66.06437500000001" r="4" fill="#fb9678" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="118.65121029572836" cy="189.2575" r="4" fill="#fb9678" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="155.56203970427163" cy="118.328125" r="4" fill="#fb9678" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="192.37201985213582" cy="25" r="4" fill="#fb9678" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="229.182" cy="90.3296875" r="4" fill="#fb9678" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="45.03125" cy="118.328125" r="4" fill="#dadada" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="81.84123014786418" cy="71.6640625" r="4" fill="#dadada" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="118.65121029572836" cy="155.659375" r="4" fill="#dadada" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="155.56203970427163" cy="146.32656250000002" r="4" fill="#dadada" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="192.37201985213582" cy="80.99687500000002" r="4" fill="#dadada" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="229.182" cy="66.06437500000001" r="4" fill="#dadada" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle></svg></div>-->
<!--                        <div class="w-75 mx-auto">-->
<!--                            <div class="d-flex justify-content-between text-center mt-5">-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
        <div class="box box-primary">
            <div class="box-body">
                <div class='table-responsive' id="table_assign">
                    <table class="table table-bordered" id="example">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Customer Name</th>
                            <th>Job Number</th>
                            <th>Expiry Date</th>
                            <th>Plan</th>
                            <th>Amount</th>
                        </tr>
                        </thead>
                        <tbody id="tBody">
                        @if(count($amc_details) > 0)
                        @foreach($amc_details as $key=>$item)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$item->customer_name}}</td>
                            <td>{{$item->unique_job_number}}</td>
                            <td>{{$item->end_date}}</td>
                            <td>{{$item->plan_name}}</td>
                            <td>{{$item->price}}</td>
                        </tr>
                        @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center Chart-title">
                <span>Tickets Status</span>
            </div>
            <div class="col-md-6">
                <canvas id="barChart"></canvas>

            </div>
            <div class="col-md-6">
                <canvas id="dayChart"></canvas>

            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center Chart-title">
                <span>Service Status</span>
            </div>
            <div class="col-md-6">
                <canvas id="ServiceChart"></canvas>

            </div>
            <div class="col-md-6">
                <canvas id="ServiceDayChart"></canvas>

            </div>
        </div>
    </div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3/dist/chart.min.js"></script>
<script>
    $(function(){
        var datas = <?php echo json_encode($datas) ?>;
        console.log(datas);
        var barCanvas = $("#barChart");
        var barChart = new Chart(barCanvas,{
            type:'bar',
            data:{
                labels:['','jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','dec'],
                datasets:[
                    {
                        label: 'Complete  Tickets',
                        data: datas,
                        backgroundColor :'rgb(125, 147, 165)',
                     }
                ]
            },
        options:{
                scales:{
                    yAxes:[{
                        ticks:{
                            beginAtZero: false
                        }
                    }]
                }
        }
        })
    });

    $(function(){
        var Daydatas = <?php echo json_encode(array_reverse($dayData)) ?>;
        console.log(Daydatas);
        var barCanvas = $("#dayChart");
        var barChart = new Chart(barCanvas,{
            type:'bar',
            data:{
                labels:[],
                datasets:[
                    {
                        label: 'Complete  Tickets',
                        data: Daydatas,
                        backgroundColor : '#0b62a4',
                     }
                ]
            },
        options:{
                scales:{
                    yAxes:[{
                        ticks:{
                            beginAtZero: false
                        }
                    }]
                }
        }
        })
    });

    $(function(){
        var datas = <?php echo json_encode($Servicedatas) ?>;
        console.log(datas);
        var barCanvas = $("#ServiceChart");
        var barChart = new Chart(barCanvas,{
            type:'bar',
            data:{
                labels:['','jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','dec'],
                datasets:[
                    {
                        label: 'Complete Service',
                        data: datas,
                        backgroundColor : '#123c57',
                    }
                ]
            },
            options:{
                scales:{
                    yAxes:[{
                        ticks:{
                            beginAtZero: false
                        }
                    }]
                }
            }
        })
    });

    $(function(){
        var Daydatas = <?php echo json_encode(array_reverse($ServiceDayData)) ?>;
        console.log(Daydatas);
        var barCanvas = $("#ServiceDayChart");
        var barChart = new Chart(barCanvas,{
            type:'bar',
            data:{
                labels:[],
                datasets:[
                    {
                        label: 'Complete  Service',
                        data: Daydatas,
                        backgroundColor :'#c7254e',
                    }
                ]
            },
            options:{
                scales:{
                    yAxes:[{
                        ticks:{
                            beginAtZero: false
                        }
                    }]
                }
            }
        })
    });

    $(document).ready(function() {
        $('#example').DataTable(
            {
                "pagingType": "full_numbers",
                "paging": true,
                "lengthMenu": [10, 25, 50, 75, 100],
            }
        );
    });
</script>
@endsection
