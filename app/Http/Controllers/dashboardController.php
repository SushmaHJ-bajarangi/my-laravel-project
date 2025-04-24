<?php

namespace App\Http\Controllers;

use App\DataTables\LopTypeDataTable;
use App\Http\Requests;
use App\Models\LopType;
use App\Repositories\LopTypeRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\customers;
use App\Models\RaiseTickets;
use App\Models\customer_products;
use App\Models\team;
use App\Models\plans;
use App\Models\GenerateQuoteDetails;
use DB;
use Carbon\Carbon;

class dashboardController extends AppBaseController
{

    public function  __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $now = date('Y-m-d');

        $pending_tickets = RaiseTickets::where('status','=','Pending')->where('is_deleted',0)->groupBy('date')->get()->toJSON();

        $customers = customers::where('is_deleted',0)->count();
        $charts = customers::where('is_deleted',0)->get();
        $pendingRaisedtickets = RaiseTickets::where("status","Pending")->where('is_deleted',0)->count();
        $acceptedRaisedtickets = RaiseTickets::Where("status","Accepted")->where('is_deleted',0)->count();
        $raisedtickets = $pendingRaisedtickets+$acceptedRaisedtickets;
        $customerproduct = customer_products::where('is_deleted',0)->orderBy('ordered_date', 'DESC')->count();
        $teams = team::where('is_deleted',0)->count();
        $reservations =  RaiseTickets::where('progress_date','=',$now)->first();
        $date = \Carbon\Carbon::today()->subDays(7);
        $users = RaiseTickets::where('created_at','>=',$date)->get();
        $tickets = RaiseTickets ::where('status','=','Completed')->select(DB::raw("COUNT(*) as count"))->whereYear('created_at',date('Y'))->groupBy(DB::raw("Month(created_at)"))->where('is_deleted',0)->pluck('count');
        $months = RaiseTickets:: where('status','=','Completed')->select(DB::raw("Month(created_at) as month"))->whereYear('created_at',date('Y'))->groupBy(DB::raw("Month(created_at)"))->where('is_deleted',0)->pluck('month');

//        $tickets_report = RaiseTickets::where('status','=','Completed')->select(DB::raw("COUNT(*) as count"))->whereYear('created_at',date('Y'))->groupBy('unique_job_number')->orderBy('count', 'DESC')->where('is_deleted',0)->pluck('count')->take(10);
//        $tickets_report_ids = RaiseTickets:: where('status','=','Completed')->select('unique_job_number')->whereYear('created_at',date('Y'))->groupBy('unique_job_number')->where('is_deleted',0)->pluck('unique_job_number')->take(10);
//        $Count_unique_job = [];
//        foreach ($tickets_report_ids as $index=>$unique_job_number){
//            $Count_unique_job[$unique_job_number] = $tickets_report[$index];
//        }

        $datas = array(0,0,0,0,0,0,0,0,0,0,0,0,0);
         foreach ($months as $index=>$month){
            $datas[$month]=$tickets[$index];
         }

        $dayCount =   RaiseTickets::orderBy("date","DESC")->where('status','=','Completed')->select(DB::raw("COUNT(*) as count"))->groupBy(DB::raw('Date(created_at)'))->whereMonth('created_at',"=",date('m'))->limit(7)->where('is_deleted',0)->pluck('count');
        $days =   RaiseTickets:: where('status','=','Completed')->select(DB::raw('date(created_at) as date'))->groupBy(DB::raw('Date(created_at)'))->whereMonth('created_at',"=",date('m'))->where('is_deleted',0)->limit(7)->orderBy("date","DESC")->pluck('date');
        $dayData = [];
        foreach ($days as $index=>$day){
            $dayData[$day]=$dayCount[$index];
        }



        $Service =DB::table('services')->where('status','=','Completed')->select(DB::raw("COUNT(*) as count"))->whereYear('created_at',date('Y'))->groupBy(DB::raw("Month(created_at)"))->where('is_deleted',0)->pluck('count');
        $Servicemonths =   DB::table('services')->where('status','=','Completed')->select(DB::raw("Month(created_at) as month"))->whereYear('created_at',date('Y'))->groupBy(DB::raw("Month(created_at)"))->where('is_deleted',0)->pluck('month');
        $Servicedatas = array(0,0,0,0,0,0,0,0,0,0,0,0);
        foreach ($Servicemonths as $index=>$month){
            $Servicedatas[$month]=$Service[$index];
        }

        $ServiceCount =  DB::table('services')->orderBy("date","DESC")->where('status','=','Completed')->select(DB::raw("COUNT(*) as count"))->groupBy(DB::raw('Date(updated_at)'))->whereMonth('updated_at',"=",date('m'))->limit(7)->where('is_deleted',0)->pluck('count');
        $Servicedays =  DB::table('services')-> where('status','=','Completed')->select(DB::raw('date(updated_at) as date'))->groupBy(DB::raw('Date(updated_at)'))->whereMonth('updated_at',"=",date('m'))->where('is_deleted',0)->limit(7)->orderBy("date","DESC")->pluck('date');

//        return $Servicedays;
        $ServiceDayData = [];
        foreach ($Servicedays as $index=>$day){
            $ServiceDayData[$day]=$ServiceCount[$index];
        }


        $expire_amc = GenerateQuoteDetails::where('amc_status','active')->get();
        $amc_details=[];
//        return $expire_amc;
        if(count($expire_amc) > 0)
            foreach ($expire_amc as $item)
            {
                $end_date=date_create(date('Y-m-d',strtotime($item->end_date)));
                $today_date=date_create(date('Y-m-d'));
                $diff=date_diff($today_date,$end_date);
                $days=$diff->format("%R%a");
                if($days <= 30)
                {
                    $customer_details=customers::where('id',$item->customer_id)->first();
                    $item['customer_name']=$customer_details->name;
                    $plan_details = plans::where('id',$item->plan)->first();
                    if(isset($plan_details->title)){
                        $item['plan_name']=$plan_details->title;
                    }

                    $amc_details[]=$item;
                }
            }

        return view('dashboard.index',compact('users','customers','pending_tickets','charts','raisedtickets','customerproduct','teams','reservations','datas','dayData','amc_details','ServiceDayData','Servicedatas'));
    }

}
