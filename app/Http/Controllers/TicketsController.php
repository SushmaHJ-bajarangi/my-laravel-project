<?php

namespace App\Http\Controllers;

use App\DataTables\teamDataTable;
use App\Http\Requests;
use App\Models\customer_products;
use App\Models\customers;
use App\Models\TicketStatus;
use App\Models\Helpers;
use App\Models\problems;
use App\Models\RaiseTickets;
use App\Models\PartsRequest;
use App\Models\parts;
use App\Models\partDetails;
use App\Models\Zone;
use App\Models\activity;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Response;
use App\Models\team;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ticketsReportExport;
use Edujugon\PushNotification\PushNotification;
use App\Models\Punches;

class TicketsController extends AppBaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function tickets()
    {
        $tickets = RaiseTickets::where('status','!=','Completed')->orderBy('id', 'desc')->where('is_deleted', '=', '0')->get();
        foreach ($tickets as $item)
        {
            $product_details=customer_products::where('unique_job_number',$item->unique_job_number)->first();
            $zone=Zone::where('id','1')->first();
            $item['zone']=$zone->title;
        }
        return view('Tickets.table',compact('tickets'));
    }


    public function getTickets(Request $request)
    {
        if ($request->ajax()) {
            $data =RaiseTickets::select('raise_tickets.id', 'raise_tickets.unique_job_number', 'raise_tickets.description', 'raise_tickets.title', 'raise_tickets.image', 'raise_tickets.progress_date', 'raise_tickets.status', 'raise_tickets.is_urgent', 'raise_tickets.assigned_to as teamName')
                ->where('status','!=','Completed')->orderBy('id', 'desc')->where('is_deleted', '=', '0')
                ->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    if (auth()->check()) {
                        if (auth()->user()->role == 1) {
                            $actionBtn = '';
                            $actionBtn .= '<div class=\'plan-btn-group\'>
                                        <a href="' . url('editTicket/' . $row->id) . '" class="edit btn btn-default btn-xs"><i class="glyphicon glyphicon-edit"></i></a>
                                        <form method="post" action="' . url('deleteTicket/' . $row->id) . '">
                                             <input type="hidden" name="_token" value="' . csrf_token() . '">
                                             <button type="submit" onclick="return confirm(\'Are you sure?\')" class="delete btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></button>
                                        </form>
                                    </div>';
                        }
                        else{
                            $actionBtn = '';
                        }
                    }
                    return $actionBtn;
                })
                ->addColumn('cancel', function ($row) {
                    if($row->teamName == ''){
                        $actionBtn = '';
                        $actionBtn .= '<div class=\'plan-btn-group\'>
                                        <form method="post" action="' . url('removeticket/' . $row->id) . '">
                                             <input type="hidden" name="_token" value="' . csrf_token() . '">
                                             <button type="submit" onclick="return confirm(\'Are you sure?\')" class="delete btn btn-danger" style="margin-top: 30px;">Cancel</button>
                                        </form>
                                    </div>';
                        return $actionBtn;
                    }
                    else{
                        $html = "<button type=\"button\" data-target='".$row->id ."'  class='btn btn-danger' id='cancel' name =\"cancel\" onclick =\"cancelsubmit($row->id)\" style='margin-top: 33px;'>Cancel</button>";
                    }
                    return $html;
                })
                ->addColumn('parts',function($parts){
                    $tickets = RaiseTickets::where('id',$parts->id)->where('is_deleted',0)->first();
                    if(empty($tickets->assigned_to) && $tickets->assigned_to == "" ){
                        $html=' NOT ASSIGNED';

                    }
                    else{
                        $html = '<button type="button" class="btn btn-warning parts" id="parts_'.$parts->id.'"   data-lan="'.$parts->id.'"   data-toggle="modal" data-target="#myModal_'.$parts->id.'" style="margin-top:34px;" onclick="openParts('.$parts->id.')">View</button>';

                    }
                    return $html;
                })

                ->addColumn('zone', function ($data) {
                    $html = '';
                    $customer_products = customer_products::where('unique_job_number', $data->unique_job_number)->where('is_deleted',0)->first();
                    $teams = team::where('zone', $customer_products->zone)->where('is_deleted', 0)->first();
                    $zones = Zone::where('id', $teams->zone)->where('is_deleted', 0)->get();
                    if(!empty($zones)){
                        foreach ($zones as $team) {
                            if ($data->teamName == $team->id) {
                                $selected = 'selected';
                            } else {
                                $selected = '';
                            }
                            $html = "<option $selected value=" . $team->id . ">" . $team->title . "</option>";

                        }
                    }
                    else{
                        $html = '';
                    }
                    return $html;
                })
                ->editColumn('teamName',function ($ticket){
                    $teamName = team::where('id',$ticket->teamName)->where('is_deleted',0)->first();
                    $customer_products = customer_products::where('unique_job_number',$ticket->unique_job_number)->where('is_deleted',0)->first();
                    $teams = team::where('is_deleted',0)->get();
                    if($ticket->is_urgent == 'yes'){
                        $Schecked = 'checked';
                    }
                    else{
                        $Schecked = '';
                    }
                    if($ticket->is_urgent == 'no'){
                        $Nchecked = 'checked';
                    }
                    else{
                        $Nchecked = '';
                    }
                    if(!empty($ticket->teamName) || $ticket->teamName != ''){
                        $html ="<p>".$teamName->title."</p>";
                    }
                    else{
                        $html ="<p>NOT ASSIGNED</p>";
                    }
                    if(empty($ticket->teamName) || $ticket->teamName == '') {
                        $html .= "<button data-toggle='modal' data-target='#address" . $ticket->id . "' class='btn btn-warning assign' id='assign'>Assign Now</button>
                                <div id='address" . $ticket->id . "' class=\"modal fade\" role=\"dialog\">
                                    <div class=\"modal-dialog\">
                                        <div class=\"modal-content\"><br>
                                            <div class='model-heading'><h4>Customer Details</h4></div>
                                              <br>
                                               <div class='card assigned'>
                                               <br>
                                                 <div class='col-sm-6 '>
                                                   <div class='unique_number'><label>Unique Job Number </label>:" . $ticket->unique_job_number . "</div>
                                                     </div>
                                                        <div class='col-md-6'>
                                                          <div class='name'><label>Cutomer Name </label>: " . $customer_products->getCustomer->name . "</div>
                                                            </div>
                                                        <br><br>
                                                     <div class='col-sm-12'>
                                                    <div class='address'><label>Customer Address </label>: " . $customer_products->address . "</div>
                                                  </div>
                                                  <br><br>

                                                  <div class='col-md-6'>";
                        if (!empty($ticket->teamName) || $ticket->teamName != '') {
                            $html .= "<div class='zone'><label>Zone</label> :" . $teamName->zone . "</div>";
                        } else {
                            $html .= "Not Assigned Zone";
                        }
                        $html .= "</div>

                                             </div>
                                             <br>
                                  <div class='model-heading'><h4>Assigned Ticket</h4></div>
                                     <div class=\"modal-body\">
                                        <div class=\"panel panel-warning\">
                                           <div class=\"panel-heading\"></div>
                                              <form method='post' action=" . url('assignTicket') . ">
                                                 <input type='hidden' name='_token' value='" . csrf_token() . "'>
                                                    <input type='hidden' name='id' value='" . $ticket->id . "'>
                                                       <div class=\"panel-body\">
                                                          <div class='col-md-12'>
                                                            <label>Assigned To</label>
                                                              <select name=\"assigned_to\" class=\"form-control select2\" required>
                                                                <option selected disabled>Select Team Leader</option>";
                                                                        if (isset($teams) && count($teams) > 0) {
                                                                            foreach ($teams as $team) {
                                                                                if ($ticket->teamName == $team->id) {
                                                                                    $selected = 'selected';
                                                                                } else {
                                                                                    $selected = '';
                                                                                }
                                                                                $html .= "<option $selected value=" . $team->id . ">" . $team->title . "_" . $team->name . "_" . $team->zone . "</option>";
                                                                            }
                                                                        }
                                                                        $html .= "</select>
                                                                        </div>
                                                                        <br><br><br><br>
                                                                        <div class='col-md-12'>
                                                                            <label>Priority Status (Is Urgent) :</label>
                                                                            <div class=\"clearfix\"></div>
                                                                            <label class=\"radio-inline\">
                                                                                <input type=\"radio\" $Schecked name=\"is_urgent\" value=\"yes\">Yes
                                                                            </label>
                                                                            <label class=\"radio-inline\">
                                                                                <input type=\"radio\" $Nchecked name=\"is_urgent\"  value=\"no\">No
                                                                            </label>
                                                                            <br><br>
                                                                        </div>
                                                                        <br><br><br>
                                                                        <div class='col-md-12 text-center'>
                                                                          <button type='submit' class='btn btn-primary'>Save</button>
                                                                             </div>
                                                                         </div>
                                                                    </form>
                                                            </div>
                                             </div>
                                            <div class=\"modal-footer\">
                                                <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>";
                    }
                    else{

                        $html .= "<button data-toggle='modal' data-target='#forward" . $ticket->id . "' class='btn btn-primary forward' id='forward' name =\"forward\">Forward</button>
                                    <div id='forward" . $ticket->id . "' class=\"modal fade\" role=\"dialog\">
                                        <div class=\"modal-dialog\">
                                            <div class=\"modal-content\"><br>
                                                <div class='model-heading'><h4>Customer Details</h4></div>
                                                 <div class='card assignes'>
                                                 <br><br>
                                                 <div class='col-sm-6 '>
                                                       <div class='unique_number'><label>Unique Job Number </label>:" . $ticket->unique_job_number . "</div>
                                                         </div>
                                                            <div class='col-md-6'>
                                                              <div class='name'><label>Cutomer Name </label>: " . $customer_products->getCustomer->name . "</div>
                                                                </div>
                                                            <br><br>
                                                         <div class='col-sm-12'>
                                                        <div class='address'><label>Customer Address </label>: " . $customer_products->address . "</div>
                                                      </div>

                                                        <br><br><br>
                                                <div class='col-md-6'>";
                        if (!empty($ticket->teamName) || $ticket->teamName != '') {
                            $html .= "<div class='zone'><label>Zone</label> :" . $teamName->zone . "</div>";
                        } else {
                            $html .= "Not Assigned Zone";
                        }
                        $html .="</div>
                                                                     </div>
                                                 <br><br>
                                      <div class='model-heading'><h4>Forward Ticket</h4></div>
                                         <div class=\"modal-body\">
                                            <div class=\"panel panel-primary\">
                                               <div class=\"panel-heading\"></div>
                                                  <form method='post' action=" . url('forwardTicket') . ">
                                                     <input type='hidden' name='_token' value='" .csrf_token() . "'>
                                                        <input type='hidden' name='id' value='" . $ticket->id . "' >
                                                           <div class=\"panel-body\">
                                                              <div class='col-md-12'>
                                                                <label>Assign To</label>
                                                                  <select name=\"forward_by\" class=\"form-control select2\" required>
                                                                    <option selected disabled>Select Team Leader</option>";
                        if (isset($teams) && count($teams) > 0) {
                            foreach ($teams as $team) {
                                if ($ticket->teamName == $team->id) {
                                    $selected = 'selected';
                                } else {
                                    $selected = '';
                                }
                                $html .= "<option $selected value=" . $team->id . ">" . $team->title . "_" . $team->zone . "_" . $team->name . "</option>";
                            }
                        }
                        $html .= "</select>
                                                            </div>
                                                            <br><br><br><br>
                                                            <div class='col-md-12'>
                                                                <label>Priority Status (Is Urgent) :</label>
                                                                <div class=\"clearfix\"></div>
                                                                <label class=\"radio-inline\">
                                                                    <input type=\"radio\" $Schecked name=\"is_urgent\" value=\"yes\">Yes
                                                                </label>
                                                                <label class=\"radio-inline\">
                                                                    <input type=\"radio\" $Nchecked name=\"is_urgent\"  value=\"no\">No
                                                                </label>
                                                                <br><br>
                                                            </div>
                                                            <br><br><br>
                                                            <div class='col-md-12 text-center'>
                                                                <button type='submit' class='btn btn-primary'>Save</button>
                                                            </div>
                                                        </div>
                                                        </form>
                                                     </div>
                                                 </div>
                                                <div class=\"modal-footer\">
                                                    <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>";


                    }
                    return $html;
                })

                ->rawColumns(['action', 'teamName', 'zone', 'cancel','parts'])->make(true);
        }
    }


    public function storeParts(Request $request){
        $ticket=RaiseTickets::where('id',$request->ticket_id)->first();
        $input['amt'] = $request->amt;
        $input['final_price'] = $request->amt;
        $input['unique_job_number'] = $ticket->unique_job_number;
        $input['parts_id'] = $request->parts_id;
        $input['technician_user_id'] = $ticket->assigned_to;
        $input['customer_id'] = $ticket->customer_id;
        $input['ticket_id'] = $request->ticket_id;
        $input['quantity'] = $request->quantity;
        $input['date'] = date('d-m-Y');
        PartsRequest::create($input);

        $entry['t_name'] = "Tickets";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Parts Added";
        activity::create($entry);
        $msg = "Parts added for customer";
        return response()->json(array('msg'=> $msg,'status_data'=>'success'), 200);

    }



    public function getData(Request $request){
        $id = $request->id;
        RaiseTickets::where('id',$id)->update(['ic_canceled'=>'1','assigned_to'=>'']);

        $entry['t_name'] = "Tickets";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Canceled";
        activity::create($entry);
        $notification = array(
            'message' => 'Ticket Canceled successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function removeticket(Request $request){
        $tickets=RaiseTickets::where('id',$request->id)->where('is_deleted',0)->first();
        RaiseTickets::where('id',$request->id)->update(['is_deleted'=>'1','ic_canceled'=>'1']);
        PartsRequest::where('ticket_id',$request->id)->update(['is_deleted'=>'1']);
        $customer_details = customers::where('id',$tickets->customer_id)->where('is_deleted',0)->first();
        $customer_address = customer_products::where('unique_job_number',$tickets->unique_job_number)->where('is_deleted',0)->first();
        if(isset($tickets->assigned_to)) {
            $team_details = team::where('id', $tickets->assigned_to)->first();
            if (isset($team_details->device_token)) {
                $push = new PushNotification('fcm');
                $push->setMessage([
                    'notification' => [
                        'title' => "Ticket Resolved no need to go for that ticket",
                        'body' => 'This ticket is done so no need to go for ticket site',
                        'image'=> '',
                        'sound' => 'default',
                        "content_available"=> true,
                    ],
                    'data' => [
                        'data_notification' => "ticket_cancel",
                        'unique_job_number' => $tickets->unique_job_number,
                        'title' => $tickets->title,
                        'body' => $tickets->description,
                        'image'=> $tickets->image,
                        'assigned_to'=> $tickets->assigned_to,
                        'customer_name'=> $customer_details->name,
                        'customer_address'=> $customer_address->address,
                        'click_action'=>'FLUTTER_NOTIFICATION_CLICK',
                    ],
                    'click_action'=>'FLUTTER_NOTIFICATION_CLICK'
                ])
                    ->setApiKey('AAAAfOmmId0:APA91bFAFAjNjvpC3-Oua0JrJmCO07MHwLVpPbNNr-uhdUGWyE1_4GXyxFTOdozcls7gsh9yUx1vPtUXCyRPupll3pjdDveNW39zHoMQ2jfDicq7TpHF75b2D2YC5bKm12ftyC7o4FI2')
                    ->setDevicesToken($team_details->device_token)
                    ->send();
                $r=$push->getFeedback();

                $entry['t_name'] = "Tickets";
                $entry['change_by'] = Auth::user()->name;
                $entry['activity'] = "Canceled";
                activity::create($entry);
                $notification = array(
                    'message' => 'Ticket Canceled successfully',
                    'alert-type' => 'success'
                );
                return redirect()->to('tickets')->with($notification);
            }
            else{
                $entry['t_name'] = "Tickets";
                $entry['change_by'] = Auth::user()->name;
                $entry['activity'] = "Canceled";
                activity::create($entry);
                $notification = array(
                    'message' => 'Ticket Canceled successfully',
                    'alert-type' => 'success'
                );
                return redirect()->to('tickets')->with($notification);
            }
        }
        $entry['t_name'] = "Tickets";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Canceled";
        activity::create($entry);
        $notification = array(
            'message' => 'Ticket Canceled successfully',
            'alert-type' => 'success'
        );
        return redirect()->to('tickets')->with($notification);

    }


    public function deleteTicket($id){
        RaiseTickets::where('id',$id)->forceDelete();
        $entry['t_name'] = "Tickets";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Deleted";
        activity::create($entry);
        $notification = array(
            'message' => 'Ticket deleted successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function deleteParts(Request $request){
        PartsRequest::where('id',$request->parts_id)->forceDelete();
        $entry['t_name'] = "parts_request";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Deleted";
        activity::create($entry);
        $notification = array(
            'message' => 'Ticket deleted successfully',
            'alert-type' => 'success'
        );
        return redirect('Request');
    }

    public function editTicket($id){
        $ticket = RaiseTickets::where('id',$id)->where('is_deleted',0)->first();
        if($ticket){
            $customer = customers::where('is_deleted', '0')->get();
            $customer_products = customer_products::where('is_deleted', '0')->get();
            $teams = team::where('is_deleted', '0')->get();
            $problems = problems::where('is_deleted',0)->get();

            return view('Tickets.edit',compact('ticket','id','customer','teams','customer_products','problems'));
        }
        else{
            $notification = array(
                'message' => 'Ticket Not Found',
                'alert-type' => 'error'
            );
            return redirect()->to('tickets')->with($notification);
        }
    }

    public function updateTicket(Request $request){
        $ticket = RaiseTickets::where('id',$request->id)->where('is_deleted',0)->first();
        RaiseTickets::where('id',$request->id)->update(['progress_date'=>$request->progress_date,'assigned_to'=>$request->assigned_to,'is_urgent'=>$request->is_urgent,'description'=>$request->description,'title'=>$request->title]);
        $deviceToken = team::where('id',$request->assigned_to)->where('is_deleted',0)->first();
        $ticket = RaiseTickets::where('id',$request->id)->where('is_deleted',0)->first();
        $customer_details = customers::where('id',$ticket->customer_id)->where('is_deleted',0)->first();
        $customer_address = customer_products::where('unique_job_number',$ticket->unique_job_number)->where('is_deleted',0)->first();
        if(empty($ticket->image)){
            $ticket->image = asset('images/no_img.png');
        }
        else{
            $ticket->image = asset('images/products/'.$ticket->image);
        }

        if($request->is_urgent == 'yes'){
            $push = new PushNotification('fcm');
            $push->setMessage([
                'notification' => [
                    'title' => $ticket->title,
                    'body' => $ticket->description,
                    'image'=> $ticket->image,
                    'sound' => 'default',
                    "content_available"=> true,
                ],
                'data' => [
                    'data_notification' => "ticket_assign",
                    'unique_job_number' => $ticket->unique_job_number,
                    'id' => $request->id,
                    'title' => $ticket->title,
                    'body' => $ticket->description,
                    'image'=> $ticket->image,
                    'assigned_to'=> $ticket->assigned_to,
                    'customer_name'=> $customer_details->name,
                    'customer_address'=> $customer_address->address,
                    'click_action'=>'FLUTTER_NOTIFICATION_CLICK',

                ],

                'click_action'=>'FLUTTER_NOTIFICATION_CLICK'
            ])
                ->setApiKey('AAAAfOmmId0:APA91bFAFAjNjvpC3-Oua0JrJmCO07MHwLVpPbNNr-uhdUGWyE1_4GXyxFTOdozcls7gsh9yUx1vPtUXCyRPupll3pjdDveNW39zHoMQ2jfDicq7TpHF75b2D2YC5bKm12ftyC7o4FI2')
                ->setDevicesToken($deviceToken->device_token)
                ->send();
            $push->getFeedback();

        }

        $entry['t_name'] = "Tickets";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Updated";
        activity::create($entry);
        $notification = array(
            'message' => 'Ticket updated successfully',
            'alert-type' => 'success'
        );
        return redirect()->to('tickets')->with($notification);
    }

    public function createTicket(){

        $teams = team::where('is_deleted',0)->get();
        $customers = customer_products::where('is_deleted',0)->get();
        foreach ($customers as $item)
        {
            $team = Zone::where('id',$item->zone)->where('is_deleted',0)->first();
            $item['zone']=$team->title;
        }
        $problems = problems::where('is_deleted',0)->get();
        return view('Tickets.create',compact('teams','customers','problems'));
    }


    public function storeTicket(Request $request){
        $input = $request->except('image');
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $input['image'] = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/products');
            $image->move($destinationPath, $input['image']);
        }
        $product_details=customer_products::where('unique_job_number',$request->unique_job_number)->where('is_deleted',0)->first();
        $input['title'] =  $request->title;
        $input['description'] = $request->description;
        $input['status'] = $request->status;
        $input['hold_reason'] = $request->hold_reason;
        $input['forward_reason'] = $request->forward_reason;
        $input['assigned_to'] = $request->assigned_to;
        $input['customer_id'] = $product_details->customer_id;
        $input['unique_job_number'] = $request->unique_job_number;
        $input['date'] = date('d-m-Y H:i:s');
        $input['progress_date'] = date('d-m-Y');
        $input['is_urgent'] = $request->is_urgent;
        $input['parts'] = $request->parts;
        $Id = RaiseTickets::create($input);
        $customer_details = customers::where('id',$product_details->customer_id)->where('is_deleted',0)->first();
        $customer_address = customer_products::where('unique_job_number',$request->unique_job_number)->where('is_deleted',0)->first();

        $deviceToken = team::where('id',$request->assigned_to)->where('is_deleted',0)->first();
        $ticket = RaiseTickets::where('id',$Id->id)->where('is_deleted',0)->first();
        if(empty($ticket->image)){
            $ticket->image = asset('images/no_img.png');
        }
        else{
            $ticket->image = asset('images/products/'.$ticket->image);
        }
//        if(empty($customer_address)){
//            $customer_address->name = 'CustomerDeleted';
//            $customer_address->address = 'CustomerDeleted';
//        }
//        if($request->is_urgent == 'yes' ){
            $push = new PushNotification('fcm');
            $push->setMessage([
                'notification' => [
                    'title' => $ticket->title,
                    'body' => $ticket->description,
                    'image'=> $ticket->image,
                    'sound' => 'default',
                    "content_available"=> true,
                ],
                'data' => [
                    'data_notification' => "ticket_assign",
                    'unique_job_number' => $ticket->unique_job_number,
                    'id' =>$Id->id,
                    'title' => $ticket->title,
                    'body' => $ticket->description,
                    'image'=> $ticket->image,
                    'assigned_to'=> $ticket->assigned_to,
//                    'customer_name'=> $customer_details->name,
                    'customer_address'=> $customer_address->address,
                    'click_action'=>'FLUTTER_NOTIFICATION_CLICK',
                ],
                'click_action'=>'FLUTTER_NOTIFICATION_CLICK'
            ])
                ->setApiKey('AAAAfOmmId0:APA91bFAFAjNjvpC3-Oua0JrJmCO07MHwLVpPbNNr-uhdUGWyE1_4GXyxFTOdozcls7gsh9yUx1vPtUXCyRPupll3pjdDveNW39zHoMQ2jfDicq7TpHF75b2D2YC5bKm12ftyC7o4FI2')
                ->setDevicesToken($deviceToken->device_token)
                ->send();
            $push->getFeedback();

//        }

        $entry['t_name'] = "Tickets";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Created";
        activity::create($entry);
        $notification = array(
            'message' => 'Ticket created successfully',
            'alert-type' => 'success'
        );
        return redirect()->to('tickets')->with($notification);
    }

    public function getProducts($val){
        $products = customer_products::where('customer_id',$val)->where('is_deleted',0)->get();
        ?><option selected="selected" disabled>Select Customer Unique Job Number</option><?php
        foreach($products as $m)
        {
            ?>
            <option value="<?php echo $m->unique_job_number; ?>"><?php echo $m->unique_job_number; ?></option>
            <?php
        }
    }


    public function getZone(Request $request,$val){
        $products = customer_products::where('id',$val)->where('is_deleted',0)->first();
        $teams = team::get();
        ?><option selected="selected" disabled>Select Team Member</option><?php
        foreach($teams as $m)
        {
            ?>
            <option value="<?php echo $m->id; ?>"><?php echo $m->title;?>  <?php echo $m->name;?> _ <?php echo $m->zone;?></option>
            <?php
        }
    }

    public function assignTicket(Request $request){
        RaiseTickets::where('id',$request->id)->update(['assigned_to'=>$request->assigned_to,'is_urgent'=>$request->is_urgent]);
        $deviceToken = team::where('id',$request->assigned_to)->where('is_deleted',0)->first();
        $ticket = RaiseTickets::where('id',$request->id)->where('is_deleted',0)->first();
        $customer_details = customers::where('id',$ticket->customer_id)->where('is_deleted',0)->first();
        $customer_address = customer_products::where('unique_job_number',$ticket->unique_job_number)->where('is_deleted',0)->first();
        if(empty($ticket->image)){
            $ticket->image = asset('images/no_img.png');
        }
        else{
            $ticket->image = asset('images/products/'.$ticket->image);
        }
//        if($request->is_urgent == 'yes'){
        $push = new PushNotification('fcm');
        $push->setMessage([
            'notification' => [
                'title' => $ticket->title,
                'body' => $ticket->description,
                'image'=> $ticket->image,
                'sound' => 'default',
                "content_available"=> true,
            ],
            'data' => [
                'data_notification' => "ticket_assign",
                'unique_job_number' => $ticket->unique_job_number,
                'id' =>$ticket->id,
                'title' => $ticket->title,
                'body' => $ticket->description,
                'image'=> $ticket->image,
                'assigned_to'=> $ticket->assigned_to,
                'customer_name'=> $customer_details->name,
                'customer_address'=> $customer_address->address,
                'click_action'=>'FLUTTER_NOTIFICATION_CLICK',
            ],
            'click_action'=>'FLUTTER_NOTIFICATION_CLICK'
        ])
            ->setApiKey('AAAAfOmmId0:APA91bFAFAjNjvpC3-Oua0JrJmCO07MHwLVpPbNNr-uhdUGWyE1_4GXyxFTOdozcls7gsh9yUx1vPtUXCyRPupll3pjdDveNW39zHoMQ2jfDicq7TpHF75b2D2YC5bKm12ftyC7o4FI2')
            ->setDevicesToken($deviceToken->device_token)
            ->send();
        $push->getFeedback();

//        }
        $entry['t_name'] = "Tickets";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Updated";
        activity::create($entry);
        $notification = array(
            'message' => 'Ticket updated successfully',
            'alert-type' => 'success'
        );
        return redirect()->to('tickets')->with($notification);
    }
    public function forwardTicket(Request $request){
        RaiseTickets::where('id',$request->id)->update(['assigned_to'=>$request->forward_by,'is_urgent'=>$request->is_urgent]);
        $deviceToken = team::where('id',$request->forward_by)->where('is_deleted',0)->first();
        $ticket = RaiseTickets::where('id',$request->id)->where('is_deleted',0)->first();
        $customer_details = customers::where('id',$ticket->customer_id)->where('is_deleted',0)->first();
        $customer_address = customer_products::where('unique_job_number',$ticket->unique_job_number)->where('is_deleted',0)->first();
        if(empty($ticket->image)){
            $ticket->image = asset('images/no_img.png');
        }
        else{
            $ticket->image = asset('images/products/'.$ticket->image);
        }
//        if($request->is_urgent == 'yes'){
            $push = new PushNotification('fcm');
            $push->setMessage([
                'notification' => [
                    'title' => $ticket->title,
                    'body' => $ticket->description,
                    'image'=> $ticket->image,
                    'sound' => 'default',
                    "content_available"=> true,
                ],
                'data' => [
                    'data_notification' => "ticket_forward",
                    'unique_job_number' => $ticket->unique_job_number,
                    'id' => $request->id,
                    'title' => $ticket->title,
                    'body' => $ticket->description,
                    'image'=> $ticket->image,
                    'assigned_to'=> $ticket->assigned_to,
//                    'customer_name'=> $customer_details->name,
                    'customer_address'=> $customer_address->address,
                    'click_action'=>'FLUTTER_NOTIFICATION_CLICK',

                ],
                'click_action'=>'FLUTTER_NOTIFICATION_CLICK'
            ])
                ->setApiKey('AAAAfOmmId0:APA91bFAFAjNjvpC3-Oua0JrJmCO07MHwLVpPbNNr-uhdUGWyE1_4GXyxFTOdozcls7gsh9yUx1vPtUXCyRPupll3pjdDveNW39zHoMQ2jfDicq7TpHF75b2D2YC5bKm12ftyC7o4FI2')
                ->setDevicesToken($deviceToken->device_token)
                ->send();
            $push->getFeedback();

//        }
        $entry['t_name'] = "Tickets";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Forwarded";
        activity::create($entry);
        $notification = array(
            'message' => 'Ticket Forwarded successfully',
            'alert-type' => 'success'
        );
        return redirect()->to('tickets')->with($notification);
    }


    public function ticketHistory(Request $request){
        $tickets_history = RaiseTickets::where('status','=','Completed')->where('is_deleted',0)->get();
        return view('Tickets.history',compact('tickets_history'));
    }

    public function raisedTicketsHistory(Request $request){

        if ($request->ajax()) {
            $data = DB::table('raise_tickets')->orderBy('raise_tickets.id','desc')
                ->select('raise_tickets.id', 'raise_tickets.unique_job_number', 'raise_tickets.description', 'raise_tickets.title', 'raise_tickets.image', 'raise_tickets.progress_date', 'raise_tickets.status', 'raise_tickets.is_urgent', 'raise_tickets.assigned_to as teamName')
                ->where('status', '=', 'Completed')->where('raise_tickets.is_deleted', '=', '0')
                ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('teamName', function ($team) {
                    $team_ticket = team::where('id', $team->teamName)->where('is_deleted', 0)->first();
                    if (!empty($team_ticket)) {
                        return $team_ticket->name;
                    } else {
                        return $team_ticket = '';
                    }
                })
                ->rawColumns(['action'])->make(true);
        }
    }

    public function cancelTicket(){
        $cancel_tickets = RaiseTickets::where('ic_canceled','=',1)->orderBy('id','desc')->where('is_deleted',0)->get();
        return view('Tickets.cancelTicket',compact('cancel_tickets'));

    }
    public function cancelTicketHistory(Request $request){
        if ($request->ajax()) {
            $data = DB::table('raise_tickets')->orderBy('raise_tickets.id','desc')
                ->select('raise_tickets.id', 'raise_tickets.unique_job_number', 'raise_tickets.description', 'raise_tickets.title', 'raise_tickets.image', 'raise_tickets.progress_date', 'raise_tickets.status', 'raise_tickets.is_urgent', 'raise_tickets.assigned_to as teamName')
                ->where('ic_canceled','=',1)->where('raise_tickets.is_deleted', '=', '1')
                ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('teamName', function ($team) {
                    $team_ticket = team::where('id', $team->teamName)->where('is_deleted', 0)->first();
                    if (!empty($team_ticket)) {
                        return $team_ticket->name;
                    } else {
                        return $team_ticket = '';
                    }
                })
                ->rawColumns(['action'])->make(true);
        }
    }
    public function getTechnicianTeam()
    {
        $team=team::where('is_deleted',0)->get();
        foreach ($team as $item)
        {
            $zone=Zone::where('id',$item->zone)->first();
            $item['zone_name']=$zone->title;
        }
        return Response::json($team);

    }

    public function getTechnicianTeamforward()
    {
        $team=team::where('is_deleted',0)->get();
        foreach ($team as $item)
        {
            $zone=Zone::where('id',$item->zone)->first();
            $item['zone_name']=$zone->title;
        }
        return Response::json($team);

    }

    public function ticketReport(Request $request){
        $tickets_history = RaiseTickets::where('status','=','Completed')->where('is_deleted',0)->get();
        $tickets_report = RaiseTickets::where('status','Completed')->select(DB::raw("COUNT(*) as count"))->whereYear('created_at',date('Y'))->groupBy('unique_job_number')->orderBy('count', 'DESC')->where('is_deleted',0)->pluck('count')->take(10);
        $tickets_report_ids = RaiseTickets::where('status','Completed')->select('unique_job_number', DB::raw("COUNT(*) as count"))->whereYear('created_at',date('Y'))->groupBy('unique_job_number')->where('is_deleted',0)->orderBy('count', 'DESC')->pluck('unique_job_number')->take(10);
        $data = array();
        $unique = array();
        $report = array();

        for($i=0; $i<count($tickets_report_ids); $i++)
        {
            $data=$tickets_report_ids[$i];
            $data1=$tickets_report[$i];
            $unique[]=$data;
            $report[]=$data1;
        }
        return view('Tickets.report',compact('tickets_history', 'unique', 'report'));
    }

    public function raisedTicketsReport(Request $request){

        if ($request->ajax()) {
            $data = DB::table('raise_tickets')->orderBy('count', 'DESC')
                ->select(DB::raw("COUNT(*) as count"), 'raise_tickets.id', 'raise_tickets.unique_job_number', 'raise_tickets.close_description', 'raise_tickets.title_close', 'raise_tickets.image', 'raise_tickets.progress_date','raise_tickets.complete_date', 'raise_tickets.status', 'raise_tickets.is_urgent', 'raise_tickets.assigned_to as teamName')
                ->whereYear('created_at',date('Y'))
                ->groupBy('unique_job_number')
                ->where('raise_tickets.is_deleted', '=', '0')
                ->where('status','Completed')
                ->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('teamName', function ($team) {
                    $team_ticket = team::where('id', $team->teamName)->where('is_deleted', 0)->first();
                    if (!empty($team_ticket)) {
                        return $team_ticket->name;
                    } else {
                        return $team_ticket = '';
                    }
                })
                ->editColumn('close_description', function ($data) {
                    $a=wordwrap($data->close_description,100,"\n");
                    return $a;
                })
                ->rawColumns(['action'])->make(true);
        }
    }

    public function reportFilter(Request $request) {

        if ($request->ajax()) {
            $data = RaiseTickets::orderBy('count', 'DESC')->where('status','Completed');

            if ($request->change_by == "12-month") {
                $data = $data->whereBetween('created_at', [date('Y-m-d', strtotime("-1 year")), date('Y-m-d', strtotime("+1 days"))]);
            } elseif ($request->change_by == "9-month") {
                $data = $data->whereBetween('created_at', [date('Y-m-d', strtotime("-9 month")), date('Y-m-d', strtotime("+1 days"))]);
            } elseif ($request->change_by == "6-month") {
                $data = $data->whereBetween('created_at', [date('Y-m-d', strtotime("-6 month")), date('Y-m-d', strtotime("+1 days"))]);
            } else {
                $data = $data->whereBetween('created_at', [date('Y-m-d', strtotime("-3 month")), date('Y-m-d', strtotime("+1 days"))]);
            }
            $data = $data->select(DB::raw("COUNT(*) as count"),
                'raise_tickets.id',
                'raise_tickets.unique_job_number',
                'raise_tickets.close_description',
                'raise_tickets.title_close',
                'raise_tickets.image',
                'raise_tickets.progress_date',
                'raise_tickets.complete_date',
                'raise_tickets.status',
                'raise_tickets.is_urgent',
                'raise_tickets.assigned_to as teamName')
                ->groupBy('unique_job_number')
                ->where('raise_tickets.is_deleted', '=', '0')
                ->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('teamName', function ($team) {
                    $team_ticket = team::where('id', $team->teamName)->where('is_deleted', 0)->first();
                    if (!empty($team_ticket)) {
                        return $team_ticket->name;
                    } else {
                        return $team_ticket = '';
                    }
                })
                ->rawColumns(['action'])->make(true);
        }
    }

    public function graphFilter(Request $request) {

        $tickets_report = RaiseTickets::where('status','Completed');
        $tickets_report_ids = RaiseTickets:: where('status','Completed');

        if ($request->change_by == "12-month") {
            $tickets_report = $tickets_report->whereBetween('created_at', [date('Y-m-d', strtotime("-1 year")), date('Y-m-d', strtotime("+1 days"))]);
            $tickets_report_ids = $tickets_report_ids->whereBetween('created_at', [date('Y-m-d', strtotime("-1 year")), date('Y-m-d', strtotime("+1 days"))]);
            $titleName = "Last Year";
        } elseif ($request->change_by == "9-month") {
            $tickets_report = $tickets_report->whereBetween('created_at', [date('Y-m-d', strtotime("-9 month")), date('Y-m-d', strtotime("+1 days"))]);
            $tickets_report_ids = $tickets_report_ids->whereBetween('created_at', [date('Y-m-d', strtotime("-9 month")), date('Y-m-d', strtotime("+1 days"))]);
            $titleName = "Last 9 Month";
        } elseif ($request->change_by == "6-month") {
            $tickets_report = $tickets_report->whereBetween('created_at', [date('Y-m-d', strtotime("-6 month")), date('Y-m-d', strtotime("+1 days"))]);
            $tickets_report_ids = $tickets_report_ids->whereBetween('created_at', [date('Y-m-d', strtotime("-6 month")), date('Y-m-d', strtotime("+1 days"))]);
            $titleName = "Last 6 Month";
        } else {
            $tickets_report = $tickets_report->whereBetween('created_at', [date('Y-m-d', strtotime("-3 month")), date('Y-m-d', strtotime("+1 days"))]);
            $tickets_report_ids = $tickets_report_ids->whereBetween('created_at', [date('Y-m-d', strtotime("-3 month")), date('Y-m-d', strtotime("+1 days"))]);
            $titleName = "Last 3 Month";
        }

        $tickets_report = $tickets_report->select(DB::raw("COUNT(*) as count"))
            ->groupBy('unique_job_number')
            ->orderBy('count', 'DESC')
            ->where('is_deleted',0)
            ->pluck('count')->take(10);
        $tickets_report_ids = $tickets_report_ids->select('unique_job_number', DB::raw("COUNT(*) as count"))
            ->groupBy('unique_job_number')
            ->where('is_deleted',0)
            ->orderBy('count', 'DESC')
            ->pluck('unique_job_number')->take(10);

        $data = array();
        $unique = array();
        $report = array();

        for($i=0; $i<count($tickets_report_ids); $i++)
        {
            $data=$tickets_report_ids[$i];
            $data1=$tickets_report[$i];

            $unique[]=$data;
            $report[]=$data1;
        }

        return response()->json([
            'unique' => $unique,
            'report' => $report,
            'titleName' => $titleName
        ]);
    }

    public function downloadReport(Request $request) {

        $unique_job_count = RaiseTickets::orderBy('count', 'DESC')
            ->whereBetween('created_at', [date('Y-m-d', strtotime("-1 year")), date('Y-m-d', strtotime("+1 days"))])
            ->select('raise_tickets.unique_job_number', DB::raw("COUNT(*) as count"))
            ->groupBy('unique_job_number')->where('status','Completed');

        if ($request->filter == "10") {
            $unique_job_count = $unique_job_count->where('raise_tickets.is_deleted', '=', '0')->take(10)->get();
        } elseif ($request->filter == "15") {
            $unique_job_count = $unique_job_count->where('raise_tickets.is_deleted', '=', '0')->take(15)->get();
        } elseif ($request->filter == "20") {
            $unique_job_count = $unique_job_count->where('raise_tickets.is_deleted', '=', '0')->take(20)->get();
        } elseif ($request->filter == "25") {
            $unique_job_count = $unique_job_count->where('raise_tickets.is_deleted', '=', '0')->take(25)->get();
        } elseif ($request->filter == "30") {
            $unique_job_count = $unique_job_count->where('raise_tickets.is_deleted', '=', '0')->take(30)->get();
        } elseif ($request->filter == "35") {
            $unique_job_count = $unique_job_count->where('raise_tickets.is_deleted', '=', '0')->take(35)->get();
        } elseif ($request->filter == "40") {
            $unique_job_count = $unique_job_count->where('raise_tickets.is_deleted', '=', '0')->take(40)->get();
        } elseif ($request->filter == "45") {
            $unique_job_count = $unique_job_count->where('raise_tickets.is_deleted', '=', '0')->take(45)->get();
        } else {
            $unique_job_count = $unique_job_count->where('raise_tickets.is_deleted', '=', '0')->take(50)->get();
        }
        return Excel::download(new ticketsReportExport($unique_job_count), 'ticketsReport.csv');
    }

    public function ticketStatus(Request $request){
        $tickets = TicketStatus::where('ticket_id', $request->ticket_id)->latest('created_at')->limit(3)->with('getTechnician')->get();
        return $tickets;
    }

    public function ticketPunches(Request $request){
        $tickets = Punches::where('ticket_id', $request->ticket_id)->with('getTechnician')->get();
        return $tickets;
    }


}
