<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\customer_products;
use App\Models\customers;
use App\Models\Services;
use App\Models\team;
use App\Models\BackupTeam;
use App\Models\servicenote;
use App\Models\Zone;
use App\Models\activity;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Response;
use DataTables;
use Carbon\Carbon;

class ServicesController extends AppBaseController
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = DB::table('services')
            ->join('customers', 'services.customer_id', '=', 'customers.id')
            ->select('services.id', 'services.date', 'services.customer_id', 'services.unique_job_number', 'services.date', 'services.status', 'services.image', 'services.assign_team_id', 'services.service_type', 'customers.name as customerName')
            ->groupBy('unique_job_number')->where('status', '!=', 'Completed')->where('services.is_deleted', '=', '0')
            ->get();
        foreach ($data as $item) {
            $team = BackupTeam::where('id', $item->assign_team_id)->first();
            if (!empty($team)) {
                $item->team_name = $team->name;
            } else {
                $item->team_name = 'Team Deleted';
            }
        }

        $years = [];

        for ($i = 0; $i < 5; $i++) {
            $years[] = date("Y", strtotime("-$i year"));
        }
        $technicians = customers::all();

        return view('services.index', compact('data', 'years', 'technicians'));
    }

    public function services_data(Request $request)
    {

        if ($request->technician == 'all' ) {
            $data = Services::join('customers', 'services.customer_id', '=', 'customers.id')
                ->where('services.date',"like", "__-__-".$request->year)->where('services.date','like','__-'. $request->month.'-____')
                ->select('services.id', 'services.date', 'services.customer_id', 'services.unique_job_number', 'services.date', 'services.status', 'services.image', 'services.assign_team_id', 'services.service_type', 'customers.name as customerName')
                ->groupBy('unique_job_number')->where('status', '!=', 'Completed')->where('services.is_deleted', '=', '0')
                ->get();
        } else {
            $data = Services::join('customers', 'services.customer_id', '=', 'customers.id')
                ->where('services.date',"like", "__-__-".$request->year)->where('services.date','like','__-'. $request->month.'-____')->where('services.customer_id', $request->technician)
                ->select('services.id', 'services.date', 'services.customer_id', 'services.unique_job_number', 'services.date', 'services.status', 'services.image', 'services.assign_team_id', 'services.service_type', 'customers.name as customerName')
                ->groupBy('unique_job_number')->where('status', '!=', 'Completed')->where('services.is_deleted', '=', '0')
                ->get();
        }

        foreach ($data as $item) {
            $team = BackupTeam::where('id', $item->assign_team_id)->first();
            if (!empty($team)) {
                $item->team_name = $team->name;
            } else {
                $item->team_name = 'Team Deleted';
            }
        }

        return response()->json([
            'data' => $data,
        ]);
    }

    public function getServices(Request $request)
    {
        $service = Services::where('unique_job_number', $request->unique_job_number)->where('status', '!=', 'Completed')->get();
        foreach ($service as $item) {
            $customer = customers::where('id', $item->customer_id)->first();
            $team = BackupTeam::where('id', $item->assign_team_id)->first();
            $item['customer_name'] = $customer->name;
            $item['technician_name'] = $team->name ?? 'Team Deleted';

        }
        return Response::json($service);
    }

    public function editServices(Request $request)
    {
        $editservice = Services::where('id', $request->service_id)->first();
        $customer = customers::where('id', $editservice->customer_id)->first();
        $team = BackupTeam::where('id', $editservice->assign_team_id)->first();
        $editservice['customer_name'] = $customer->name;
        $editservice['technician_name'] = $team->name;
        return Response::json($editservice);
    }

    public function serviceHistoryDetails(Request $request)
    {
        $serviceHistory = Services::where('unique_job_number', $request->unique_job_number)->where('status', 'Completed')->get();

        foreach ($serviceHistory as $item) {
            $customer = customers::where('id', $item->customer_id)->first();
            $team = BackupTeam::where('id', $item->assign_team_id)->first();

            $item->customer_name = $customer->name;
            $item->technician_name = $team->name;
            if ($item->complete_service !== "" && $item->complete_service !== null) {
                $item['complete_service'] = $item->complete_service;
            } else {
                $item['complete_service'] = $item->date;
            }
        }


        return Response::json($serviceHistory);
    }

    public function editteam()
    {
        $team = BackupTeam::get();
        foreach ($team as $item) {
            $zone = Zone::where('id', $item->zone)->first();
            $item['zone_name'] = $zone->title;
        }
        return Response::json($team);
    }


    public function deleteService($id)
    {
        Services::where('id', $id)->update(['is_deleted' => '1']);

        $entry['t_name'] = "Services";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Deleted";
        activity::create($entry);
        $notification = array(
            'message' => 'Service deleted successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function updateServices(Request $request)
    {
        $date = date('d-m-Y', strtotime($request->date));
        Services::where('id', $request->service_id)->update(['date' => $date, 'assign_team_id' => $request->team_id]);

        $entry['t_name'] = "Services";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Updated";
        activity::create($entry);
        $notification = array(
            'message' => 'Service updated successfully',
            'alert-type' => 'success'
        );
        return $notification;


    }

    public function finishservice(Request $request)
    {
//        $service=Services::where('status','Assigned')->where('is_deleted',0)->get();
//        return $service;
//        if(!empty($service))
//        {
//            foreach ($service as $services)
//            {
//                $date_less=strtotime('01-05-2022')*1000;
//                $date= strtotime($services->date) * 1000;
//                if($date_less > $date)
//                {
//                    $customer_details=customers::where('id',$services->customer_id)->first();
//                    $signature_image='no_img.png';
//                    $authname=$customer_details->name;
//                    $auth_number=$customer_details->contact_number;
//                    Services::where('id', $services->id)->update(['status'=>'Completed','authname'=>$authname,'auth_number'=>$auth_number]);
//                    $entry['t_name'] = "Services";
//                    $entry['change_by'] = Auth::user()->name;
//                    $entry['activity'] = "Completed";
//                    activity::create($entry);
//                }
//
//            }
//
//        }

    }

    public function completeService(Request $request)
    {
        $service = Services::where('id', $request->service_id)->where('is_deleted', 0)->first();
        if (!empty($service)) {
            $customer_details = customers::where('id', $service->customer_id)->first();
            $signature_image = 'no_img.png';
            $authname = $customer_details->name;
            $auth_number = $customer_details->contact_number;
            $date = date('d-m-Y');
            Services::where('id', $request->service_id)->update(['status' => 'Completed', 'authname' => $authname, 'auth_number' => $auth_number, 'complete_service' => $date]);

            $entry['t_name'] = "Services";
            $entry['change_by'] = Auth::user()->name;
            $entry['activity'] = "Completed";
            activity::create($entry);
            $notification = array(
                'message' => 'Service updated successfully',
                'alert-type' => 'success'
            );
            return $notification;
        }

    }

    public function serviceHistory(Request $request)
    {
        $service_history = DB::table('services')
            ->join('customers', 'services.customer_id', '=', 'customers.id')
            ->select('services.id', 'services.customer_id', 'services.unique_job_number', 'services.date', 'services.complete_service', 'services.status', 'services.image', 'services.assign_team_id', 'services.service_type', 'customers.name as customerName')
            ->groupBy('unique_job_number')->where('status', '=', 'Completed')->where('services.is_deleted', '=', '0')
            ->get();
        foreach ($service_history as $item) {
            $customer = customers::where('id', $item->customer_id)->first();
            if ($customer->name !== "" && $customer->name !== null) {
                $item->customer_name = $customer->name;
            } else {
                $item->customer_name = '-';
            }

            $BackupTeam = BackupTeam::where('id', $item->assign_team_id)->first();
            if ($BackupTeam !== "" && $BackupTeam !== null) {
                $item->technician_name = $BackupTeam->name;
            } else {
                $item->technician_name = '-';
            }


        }
        return view('services.history', compact('service_history'));
    }

    public function customerNote(Request $request)
    {
        $notes = servicenote::orderBy('id', 'DESC')->where('is_deleted', 0)->get();
        return view('services.customer_note', compact('notes'));
    }

    public function editCustomerNote(Request $request, $id)
    {
        $edit_note = servicenote::find($id);
        return view('services.edit_note', compact('edit_note'));
    }

    public function updateNote(Request $request, $id)
    {
        $note = servicenote::where('id', $id)->first();
        if ($id != $note->id) {
            $notification = array(
                'message' => 'servicenote not found',
                'alert-type' => 'warning'
            );
            return redirect(url('customer/note'))->with($notification);
        }
        $update = ['service_id' => $request->service_id, 'description' => $request->description];
        servicenote::where('id', $id)->update($update);

        $entry['t_name'] = "ServiceNote";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Updated";
        activity::create($entry);
        $notification = array(
            'message' => 'servicenote updated successfully.',
            'alert-type' => 'success'
        );
        return redirect(url('customer/note'))->with($notification);

    }

    public function destroy($id)
    {
        servicenote::where('id', $id)->update(['is_deleted' => '1']);

        $entry['t_name'] = "ServiceNote";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Deleted";
        activity::create($entry);
        $notification = array(
            'message' => 'servicenote deleted successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }
}