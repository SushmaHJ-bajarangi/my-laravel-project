<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Response;
use App\Models\RaiseTickets;
use App\Models\team;
use App\Models\Zone;
use App\Models\customers;
use DateTime;

use Carbon\Carbon;

class ReportsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tableNames = DB::select('SHOW TABLES');
        return view('Reports.index',compact('tableNames'));

    }

    public function getColumnNames($val){
        $data = DB::getSchemaBuilder()->getColumnListing($val);
        return response()->json($data);
    }

    public function ticketReports(){
        return view('Reports.ticketreports');
    }

    public function filterTickets(Request $request){
        $id=$request->days;

        $dteStart = RaiseTickets::where('status','=','Completed')->where('is_deleted','=',0)->get();
        foreach ($dteStart as $dteStarts){
            $start_date = $dteStarts->date;
            $enddate=$dteStarts->progress_date;
            $dteStart = new DateTime($start_date);
            $dteEnd   = new DateTime($enddate);
            $diff=date_diff($dteStart,$dteEnd);
            $days= $diff->format("%R%a days");
        }

    $days_canceled = RaiseTickets::where($id,'=',$days)->where('is_deleted','=',0)->get();
        return $days_canceled;


    }

    public function newReports(){
        $technicians = team::where('is_deleted','0')->get();
        $reports = RaiseTickets::where('status','Pending')->where('is_deleted','0')->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))->get();
        return view('Reports.Reports',compact('reports','technicians'));
    }

    public function getReports(Request $request){
        if($request->technicianId == 'all'){
            $tickets = RaiseTickets::whereDate('created_at', '>=', $request->StartDate)->whereDate('created_at', '<=', $request->EndDate)->where('is_deleted',0)->get();
        }
        else{
            $tickets = RaiseTickets::whereDate('created_at', '>=', $request->StartDate)->whereDate('created_at', '<=', $request->EndDate)->where('assigned_to',$request->technicianId)->where('is_deleted',0)->get();
        }
        foreach ($tickets as $ticket){
            $zone = Zone::where('id',$ticket->getechnicianName->zone)->first();
            $customerName = customers::where('id',$ticket->customer_id)->first();
            $Tname = team::where('id',$ticket->assigned_to)->first();
            $ticket['zone'] = $zone->title;
            $ticket['customer_id'] = $customerName->name;
            $ticket['assigned_to'] = $Tname->name;
        }
        return $tickets;
    }
//    public function dateUpdate()
//    {
//        $tickets = RaiseTickets::where('status','Pending')->get();
//        foreach ($tickets as $ticket)
//        {
//                $tickets = RaiseTickets::where('id',$ticket['id'])->update(['complete_date'=>'']);
//        }
//    }


}
