<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateteamAPIRequest;
use App\Http\Requests\API\UpdateteamAPIRequest;
use App\Models\team;
use App\Models\TicketStatus;
use App\Models\Punches;
use App\Models\Technician_Assist;
use App\Product;
use App\Repositories\teamRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\RaiseTickets;
use App\Models\customers;
use App\Models\customer_products;
use App\Models\parts_purchase;
use App\Models\PartsRequest;
use App\Models\Hold_Reasons;
use App\Models\parts;
use App\Models\partDetails;
use App\Models\GenerateQuote;
use App\Models\GenerateQuoteDetails;
use App\Models\plans;
use App\Models\CloseTicket;
use App\Models\Zone;
use App\Models\Helpers;
use App\Events\AssignTicketEvent;
use Illuminate\Support\Facades\Log;
use Edujugon\PushNotification\PushNotification;
/**
 * Class teamController
 * @package App\Http\Controllers\API
 */

class teamAPIController extends AppBaseController
{
    /** @var  teamRepository */
    private $teamRepository;

    public function __construct(teamRepository $teamRepo)
    {
        $this->teamRepository = $teamRepo;
    }

    /**
     * Display a listing of the team.
     * GET|HEAD /teams
     *
     * @param Request $request
     * @return Response
     */
    public function technicianLogin(Request $request)
    {
        $number = $request->contact_number;
//        $signature = $request->signature;
        if ($number == '') {
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'All Fields Required';//for error message
        } else {
            if (team::where('contact_number', $number)->where('is_deleted', 0)->exists()) {
                $otp = rand(1000, 9999);
                $api_key = "a401882b-1bc6-11ec-a13b-0200cd936042";
                $sender_id = 'TEKNIX';
                $TemplateName = 'teknix_otp_template';
                $final_data = array(
                    'From' => $sender_id,
                    'To' => $number,
                    'TemplateName' => $TemplateName,
                    'VAR1' => $otp,
//                    'VAR2' => $signature
                );
                $payload = json_encode($final_data);
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "http://2factor.in/API/V1/$api_key/ADDON_SERVICES/SEND/TSMS",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => $payload,
                    CURLOPT_HTTPHEADER => array(
                        "content-type: application/x-www-form-urlencoded"
                    ),
                ));
                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);
                if ($err) {
                    $data['error'] = false;
                    $data['code'] = 500;
                    $data['message'] = 'Something Went Wrong';//for error message
                }
                $response = [];
                $response['otp'] = $otp;
                $response['contact_number'] = $number;
                $data['success'] = true;//for success true
                $data['code'] = 200;//for success code 200
                $data['data'] = $response;
                $data['message'] = 'Number Is Correct';//for error message
            }
            else if(Helpers::where('contact_number',$number)->where('is_deleted', 0)->exists()){
                  $otp = rand(1000, 9999);
                $api_key = "a401882b-1bc6-11ec-a13b-0200cd936042";
                $sender_id = 'TEKNIX';
                $TemplateName = 'teknix_otp_template';
                $final_data = array(
                    'From' => $sender_id,
                    'To' => $number,
                    'TemplateName' => $TemplateName,
                    'VAR1' => $otp,
//                    'VAR2' => $signature
                );
                $payload = json_encode($final_data);
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "http://2factor.in/API/V1/$api_key/ADDON_SERVICES/SEND/TSMS",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => $payload,
                    CURLOPT_HTTPHEADER => array(
                        "content-type: application/x-www-form-urlencoded"
                    ),
                ));
                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);
                if ($err) {
                    $data['error'] = false;
                    $data['code'] = 500;
                    $data['message'] = 'Something Went Wrong';//for error message
                }
                $response = [];
                $response['otp'] = $otp;
                $response['contact_number'] = $number;
                $data['success'] = true;//for success true
                $data['code'] = 200;//for success code 200
                $data['data'] = $response;
                $data['message'] = 'Number Is Correct';//for error message
            }
            else {
                $data['data'] = 'No Data';
                $data['error'] = false;
                $data['code'] = 500;
                $data['message'] = 'Technician Not Found';//for error message
            }
        }
        return $data;
    }

    public function technicianOtpVerify(Request $request)
    {
        $verfiy_code = $request->verfiy_code;
        $otp_code = $request->otp_code;
        if (team::where('contact_number', $request->contact_number)->where('is_deleted', 0)->exists()) {
            $team = team::where('contact_number', $request->contact_number)->where('is_deleted',0)->first();
            $team['type'] = 'Technician';
            if ($otp_code == $verfiy_code) {
                $data['success'] = true;//for success true
                $data['data'] = $team;//for success true
                $data['code'] = 200;//for success code 200
                $data['message'] = 'Login Successfully';//for error message
            } else {
                $data['error'] = false;
                $data['code'] = 500;
                $data['message'] = 'OTP Is Not Matched';//for error message
            }
        } 
         else if (Helpers::where('contact_number', $request->contact_number)->where('is_deleted', 0)->exists()) {
             $helper = Helpers::where('contact_number', $request->contact_number)->where('is_deleted', 0)->first();
            $team = team::where('id', $helper->team_id)->where('is_deleted',0)->first();
            $team['type'] = 'Technician';
            if ($otp_code == $verfiy_code) {
                $data['success'] = true;//for success true
                $data['data'] = $team;//for success true
                $data['code'] = 200;//for success code 200
                $data['message'] = 'Login Successfully';//for error message
            } else {
                $data['error'] = false;
                $data['code'] = 500;
                $data['message'] = 'OTP Is Not Matched';//for error message
            }
        } 
        else {
            $data['data'] = 'No Data';
            $data['error'] = false;
            $data['code'] = 500;
            $data['message'] = 'Technician Not Found';//for error message
        }
        return $data;
    }

    public function getTeams()
    {
        $teams = team::where('is_deleted', 0)->select('id', 'title', 'name', 'contact_number')->with('helpers')->get();
        if (count($teams) > 0) {
            $data['data'] = $teams;//for success true
            $data['success'] = true;//for success true
            $data['code'] = 200;//for success code 200
            $data['message'] = 'Teams Found';//for success message
        } else {
            $data['data'] = 'No Data';//for success true
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'Not Found';//for success message
        }
        return $data;
    }

    public function getTeamMembers(Request $request)
    {
        $teams = team::where('is_deleted', 0)->where('id','!=',$request->team_id)->select('id', 'title', 'name', 'zone','contact_number')->get();
        if (count($teams) > 0) {
            foreach ($teams as $item)
            {
                $zone=Zone::where('id',$item->zone)->where('is_deleted',0)->first();
                if(!empty($zone))
                {
                    $item->zone = $zone->title;
                }
                else{
                    $item->zone ='';
                }
            }
            $data['data'] = $teams;//for success true
            $data['success'] = true;//for success true
            $data['code'] = 200;//for success code 200
            $data['message'] = 'Teams Found';//for success message
        } else {
            $data['data'] = 'No Data';//for success true
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'Not Found';//for success message
        }
        return $data;
    }

    public function tokenUpdate(Request $request)
    {
        $number = $request->contact_number;
        $token = $request->device_token;
        if ($number == '' || $token == '') {
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'Something Went Wrong!';//for success message
        } else {
            if (team::where('contact_number', $request->contact_number)->where('is_deleted', 0)->exists()) {
                $team = team::where('contact_number', $request->contact_number)->where('is_deleted', 0)->first();
                if (empty($team->device_token)) {
                    team::where('contact_number', $request->contact_number)->where('is_deleted', 0)->update(['device_token' => $request->device_token]);
                    $data['success'] = true;//for success true
                    $data['code'] = 200;//for success code 200
                    $data['message'] = 'Token Updated Successfully';//for success message
                } else {
                    if (team::where('contact_number', $request->contact_number)->where('is_deleted', 0)->where('device_token', '!=', $request->device_token)->first()) {
                        team::where('contact_number', $request->contact_number)->where('is_deleted', 0)->update(['device_token' => $request->device_token]);
                        $data['success'] = true;//for success true
                        $data['code'] = 200;//for success code 200
                        $data['message'] = 'Token Updated Successfully';//for success message
                    } else {
                        $data['success'] = true;//for success true
                        $data['code'] = 200;//for success code 200
                        $data['message'] = 'Token Already Found';//for success message
                    }
                }
            }
            else if (Helpers::where('contact_number', $request->contact_number)->where('is_deleted', 0)->exists()) {
                $helper = Helpers::where('contact_number', $request->contact_number)->where('is_deleted', 0)->first();
                // $team = team::where('id',$helper->team_id)->where('is_deleted', 0)->first();
                if (empty($helper->device_token)) {
                    Helpers::where('contact_number', $request->contact_number)->where('is_deleted', 0)->update(['device_token' => $request->device_token]);
                    $data['success'] = true;//for success true
                    $data['code'] = 200;//for success code 200
                    $data['message'] = 'Token Updated Successfully';//for success message
                } else {
                    if (Helpers::where('contact_number', $request->contact_number)->where('is_deleted', 0)->where('device_token', '!=', $request->device_token)->first()) {
                        Helpers::where('contact_number', $request->contact_number)->where('is_deleted', 0)->update(['device_token' => $request->device_token]);
                        $data['success'] = true;//for success true
                        $data['code'] = 200;//for success code 200
                        $data['message'] = 'Token Updated Successfully';//for success message
                    } else {
                        $data['success'] = true;//for success true
                        $data['code'] = 200;//for success code 200
                        $data['message'] = 'Token Already Found';//for success message
                    }
                }
            }
            else {
                $data['error'] = false;//for success true
                $data['code'] = 500;//for success code 200
                $data['message'] = 'Technician Not Found';//for success message
            }
        }
        return $data;
    }

    public function technicainTodayTicket(Request $request)
    {
        $technician_user_id = $request->technician_user_id;
        $tickets = RaiseTickets::where('assigned_to', $technician_user_id)->where('status','!=','Completed')->orderBy('id','DESC')->where('is_deleted',0)->get();
        foreach ($tickets as $item) {
            $customer_name = customers::where('id', $item->customer_id)->where('is_deleted',0)->first();
            $address = customer_products::where('unique_job_number', $item->unique_job_number)->where('is_deleted',0)->first();
            $team_name = team::where('id', $item->assigned_to)->where('is_deleted',0)->first();
            $parts_details=PartsRequest::where('ticket_id',$item->id)->where('status','!=','Paid')->get();
            if(count($parts_details) > 0)
            {
                $item['parts_payment']='yes';
            }
            else{
                $item['parts_payment']='no';
            }
            if ($item->image != null) {
                $item['image'] = asset('images/products/' . $item->image);
            } else {
                $item['image'] = null;
            }
            $product=customer_products::where('unique_job_number',$item->unique_job_number)->where('status','!=','Expired')->where('is_deleted',0)->first();
            if(!empty($product))
            {
                $item['warranty_start_date']=$product->warranty_start_date;
                $item['warranty_end_date']=$product->warranty_end_date;
                $item['warranty_status']=$product->status;
            }
            else{
                $item['warranty_start_date']='';
                $item['warranty_end_date']='';
                $item['warranty_status']='Expired';
            }
            $quotesData=GenerateQuoteDetails::where('customer_id',$item->customer_id)->where('unique_job_number',$item->unique_job_number)->where('amc_status','active')->where('is_deleted',0)->first();
            if(!empty($quotesData))
            {
                $parts = plans::where('id',$quotesData->plan)->where('is_deleted',0)->first();
                $item['payment_required']='no';
                $item['start_date']=$quotesData->start_date;
                $item['end_date']=$quotesData->end_date;
                $item['amc_status']=$quotesData->amc_status;
                if(!empty($parts)){
                    $item['plan_name']=$parts->title;
                }
                else{
                    $item['plan_name']='no plan';
                }
                $item['active_plan']=$quotesData->id;

            }
            else
            {
                $item['payment_required']='yes';
                $item['plan_name']='no plan';
                $item['start_date']='';
                $item['end_date']='';
                $item['amc_status']='Expired';
                $item['active_plan']='';
            }
            $item->customer_id = $customer_name->name;
            $item->assigned_to_title = $team_name->name;
            $item->assigned_to = $team_name->id;
            $item->address = $address->address ?? null;
            $item->door = $address->door ?? null;
            $item->cop_type = $address->cop_type ?? null;
            $item->lop_type = $address->lop_type ?? null;
            $item->passenger_capacity = $address->passenger_capacity ?? null;
            $item->model_id = $address->model_id ?? null;
            $item->number_of_floors = $address->number_of_floors ?? null;
            $item->customer_id = $address->customer_id ?? null;
            $item->distance = $address->distance ?? null;
            $item->unique_job_number = $address->unique_job_number ?? null;
            $item->ordered_date = $address->ordered_date ?? null;
            $item->no_of_services = $address->no_of_services ?? null;
            if(!empty($address)){
                $zone=Zone::where('id',$address->zone)->where('is_deleted',0)->first();
                if(!empty($zone))
                {
                    $item->zone = $zone->title;
                }
                else{
                    $item->zone ='';
                }
            }
            else{
                $item->zone ='';
            }
            $item->contact_number = $customer_name->contact_number;
            $item->name = $customer_name->name;

        }
        if (count($tickets) > 0) {
            $data['data'] = $tickets;//for success true
            $data['success'] = true;//for success true
            $data['code'] = 200;//for success code 200
            $data['message'] = 'Tickets Found';//for success message
        } else {
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'Tickets Not Found';//for success message
        }
        return $data;
    }

    public function particularTicket(Request $request)
    {
        $technician_user_id = $request->technician_user_id;
        $unique_job_number = $request->unique_job_number;
        $raised_ticket_id = $request->raised_ticket_id;

        if ($technician_user_id == '' || $unique_job_number == '' || $raised_ticket_id == '') {

            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'Something Went Wrong!';//for success message
        } else {

            $tickets = RaiseTickets::where('assigned_to', $technician_user_id)->where('unique_job_number', $unique_job_number)->where('id', $raised_ticket_id)->where('is_deleted',0)->first();
            if (!empty($tickets)) {
                $data['data'] = $tickets;//for success true
                $data['success'] = true;//for success true
                $data['code'] = 200;//for success code 200
                $data['message'] = 'Tickets Found';//for success message
            } else {
                $data['data'] = 'No Data';//for success true
                $data['error'] = false;//for success true
                $data['code'] = 500;//for success code 200
                $data['message'] = 'Not Found';//for success message
            }


        }

        return $data;
    }

    public function recentTicket(Request $request)
    {
        $technician_user_id = $request->technician_user_id;
        $unique_job_number = $request->unique_job_number;
        if ($technician_user_id == '' || $unique_job_number == '') {

            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'Something Went Wrong!';//for success message
        } else {

            $recent_tickets = RaiseTickets::where('assigned_to', $technician_user_id)->where('unique_job_number', $unique_job_number)->where('is_deleted',0)->first();
            if (!empty($recent_tickets)) {
                $data['data'] = $recent_tickets;//for success true
                $data['success'] = true;//for success true
                $data['code'] = 200;//for success code 200
                $data['message'] = 'Tickets Found';//for success message
            } else {
                $data['data'] = 'No Data';//for success true
                $data['error'] = false;//for success true
                $data['code'] = 500;//for success code 200
                $data['message'] = 'Not Found';//for success message
            }
        }

        return $data;
    }

    public function ticketAccept(Request $request)
    {
        $ticket_id = $request->ticket_id;
        $technician_user_id = $request->technician_id;
        $unique_job_number = $request->unique_job_number;
        if ($technician_user_id == '' || $unique_job_number == '' || $ticket_id == '') {

            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'Something Went Wrong!';//for success message
        }
        else {
            $ticket_accept = RaiseTickets::where('id', $ticket_id)->where('assigned_to', $technician_user_id)->where('unique_job_number', $unique_job_number)->where('is_deleted',0)->first();
            if (!empty($ticket_accept)) {
                $ticket_accepts = RaiseTickets::where('id',$ticket_id )->update(['status' => 'Accepted',]);
                $data['data'] = $ticket_accepts;//for success true
                $data['success'] = true;//for success true
                $data['code'] = 200;//for success code 200
                $data['message'] = 'Tickets Status Updated Successfully';//for success message
            } else {
                $data['data'] = 'No Data';//for success true
                $data['error'] = false;//for success true
                $data['code'] = 500;//for success code 200
                $data['message'] = 'Tickets Not Found';//for success message
            }
        }
        return $data;
    }

    public function ticketdecline(Request $request)
    {
        $ticket_id = $request->ticket_id;
        $technician_user_id = $request->technician_id;
        $unique_job_number = $request->unique_job_number;
        if ($technician_user_id == '' || $unique_job_number == '' || $ticket_id == '') {

            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'Something Went Wrong!';//for success message
        }
        else {
            $ticket_accept = RaiseTickets::where('id', $ticket_id)->where('assigned_to', $technician_user_id)->where('unique_job_number', $unique_job_number)->where('is_deleted',0)->first();
            if (!empty($ticket_accept)) {
                $technicianName = team::where('id',$technician_user_id)->first();
                $teams = team::where('is_deleted',0)->get();
                $event['technicianName'] = $technicianName;
                $event['teams'] = $teams;
                $event['ticketId'] = $ticket_id;

                $ticket_accepts = RaiseTickets::where('id',$ticket_id )->update(['status' => 'Pending','assigned_to'=>'']);
                $data['data'] = $ticket_accepts;//for success true
                $data['success'] = true;//for success true
                $data['code'] = 200;//for success code 200
                $data['message'] = 'Tickets Status Updated Successfully';//for success message
                event(new AssignTicketEvent($event));
            } else {
                $data['data'] = 'No Data';//for success true
                $data['error'] = false;//for success true
                $data['code'] = 500;//for success code 200
                $data['message'] = 'Tickets Not Found';//for success message
            }
        }
        return $data;
    }

    public function ticketForward(Request $request){
        $ticket_id = $request->ticket_id;
        $forwared =$request->forward_by;
        $forward_reason = $request->forward_reason;
        $technician_user_id = $request->technician_id;
        $unique_job_number = $request->unique_job_number;
        if ($technician_user_id == '' || $unique_job_number == '' || $ticket_id == '' || $forwared == '' || $forward_reason == '') {
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'Something Went Wrong!';//for success message
        }
        else{
            $ticket_forward = RaiseTickets::where('id', $ticket_id)->where('assigned_to', $forwared)->where('unique_job_number', $unique_job_number)->where('is_deleted',0)->first();
            if (!empty($ticket_forward)) {
                $ticket_accepts = RaiseTickets::where('id',$ticket_id )->update(['status'=>'Pending','forward_by'=>$forwared,'assigned_to'=>$technician_user_id,'forward_reason'=>$forward_reason]);
                $data['data'] = $ticket_accepts;//for success true
                $data['success'] = true;//for success true
                $data['code'] = 200;//for success code 200
                $data['message'] = 'Tickets Forward Successfully';//for success message
            }
            else {
                $data['data'] = 'No Data';//for success true
                $data['error'] = false;//for success true
                $data['code'] = 500;//for success code 200
                $data['message'] = 'Not Found';//for success message
            }
        }

        return $data;
    }

    public function holdReason(Request $request){

        $hold_reason=Hold_Reasons::get();
        if(!empty($hold_reason))
        {
            $data['data'] = $hold_reason;//for success true
            $data['success'] = true;//for success true
            $data['code'] = 200;//for success code 200
            $data['message'] = 'Tickets Updated Successfully';//for success message
        }
        else{
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'Something Went Wrong!';//for success message
        }

        return $data;
    }

    public function holdTicket(Request $request){
        $ticket_id = $request->ticket_id;
        $technician_user_id = $request->technician_user_id;
        $hold_reason = $request->hold_reason;
        $unique_job_number = $request->unique_job_number;
        if ($technician_user_id == '' || $unique_job_number == '' || $ticket_id == '') {

            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'Something Went Wrong!';//for success message
        }
        else {
            $ticket_accept = RaiseTickets::where('id', $ticket_id)->where('assigned_to', $technician_user_id)->where('unique_job_number', $unique_job_number)->where('is_deleted',0)->first();
            if (!empty($ticket_accept)) {
                $ticket_accepts = RaiseTickets::where('id',$ticket_id )->update(['status' => 'onhold','hold_reason'=>$hold_reason]);
                $data['data'] = $ticket_accepts;//for success true
                $data['success'] = true;//for success true
                $data['code'] = 200;//for success code 200
                $data['message'] = 'Tickets Hold Status Updated Successfully';//for success message
            } else {
                $data['data'] = 'No Data';//for success true
                $data['error'] = false;//for success true
                $data['code'] = 500;//for success code 200
                $data['message'] = 'Tickets Not Found';//for success message
            }
        }
        return $data;
    }

    public function partsPurchase(Request $request)
    {
        $price = $request->price;
        $final_price = $request->final_price;
        $unique_job_number = $request->unique_job_number;
        $parts_id = $request->parts_id;
        if ($price == '' || $final_price == '' || $unique_job_number == '' || $parts_id == '') {
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'All Fields Required';//for error message
        }

    else{
        $input['price'] = $request->price;
        $input['final_price'] = $request->final_price;
        $input['unique_job_number'] = $request->unique_job_number;
        $input['parts_id'] = $request->parts_id;
    //    $input['parts_id'] = implode(', ', $request->parts_id);
        parts_purchase::create($input);
        $data['data'] = $input;
        $data['success'] = true;
        $data['code'] = 200;
            $data['message'] = 'Parts Purchased Successfully';//for error message
    }
    return $data;
    }

    public function ticketCompleted(Request $request){

        $ticket_id = $request->ticket_id;
        $technician_user_id = $request->technician_id;
        $unique_job_number = $request->unique_job_number;
        $input=$request->all();
        if ($technician_user_id == '' || $unique_job_number == '' || $ticket_id == '') {

            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'Something Went Wrong!';//for success message
        } else {

            $this->validate($request, [
                'signature' => 'required|image|mimes:jpeg,png,jpg,bmp,gif,svg',
            ]);
            $signatureimage='';
            $closeimage='';
            if ($request->hasFile('signature')) {
                $image = $request->file('signature');
                $signatureimage = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/signature/');
                $image->move($destinationPath, $signatureimage);
            }

            if ($request->hasFile('closeimage')) {
                $image = $request->file('closeimage');
                $closeimage = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/closeimage/');
                $image->move($destinationPath, $closeimage);
            }
            else{
                $closeimage='';
            }
             $ticket_accept = RaiseTickets::where('id', $ticket_id)->where('assigned_to', $technician_user_id)
                 ->where('unique_job_number', $unique_job_number)->where('is_deleted',0)->first();
            $customer=customers::where('id',$ticket_accept->customer_id)->where('is_deleted',0)->first();
            if (!empty($ticket_accept)) {
                $team=team::where('id',$technician_user_id)->first();

                $ticket_accepts = RaiseTickets::where('id',$ticket_id )
                    ->update([
                            'status' => 'Completed',
                            'customer_status'=>'Completed',
                            'signature_image'=>$signatureimage,
                            'title_close'=>$request->close_reason,
                            'close_description'=>$request->description,
                            'authname'=>$request->authname,
                            'close_image'=>$closeimage,
                            'auth_number'=>$request->auth_number,
                            'tech_name'=>$team->name,
                            'complete_date'=>date('d-m-Y h:i:s'),
                            'is_deleted'=>0
                            ]);
                $push = new PushNotification('fcm');
                $push->setMessage([
                    'notification' => [
                        'title' => 'Hello '.$customer->name .' '.'Your ticket has been close please look in to this !!' ,
                        'body' => 'you have created ticket for your lift this notification for reminding close ticket by our technician please check this ',
                        'image'=>'https://bajarangisoft.com/Teknix/public/images/logo.png',
                        'sound' => 'default',
                        "content_available"=> true,
                        "click_action"=> "FLUTTER_NOTIFICATION_CLICK",

                    ],
                    'data' => [
                        'data_notification' => "ticket_close",
                        'customer_name' => $customer->name,
                        'ticket_id'=>$ticket_id,
                        'auth_person'=>$request->authname,


                    ],
                    'click_action'=>'FLUTTER_NOTIFICATION_CLICK'
                ])
                    ->setApiKey('AAAAfOmmId0:APA91bFAFAjNjvpC3-Oua0JrJmCO07MHwLVpPbNNr-uhdUGWyE1_4GXyxFTOdozcls7gsh9yUx1vPtUXCyRPupll3pjdDveNW39zHoMQ2jfDicq7TpHF75b2D2YC5bKm12ftyC7o4FI2')
                    ->setDevicesToken($customer->device_token)
                    ->send();
                $push->getFeedback();

                $data['data'] = $ticket_accept;//for success true
                $data['success'] = true;//for success true
                $data['code'] = 200;//for success code 200
                $data['message'] = 'Ticket Completed Successfully';//for success message
            } else {
                $data['data'] = 'No Data';//for success true
                $data['error'] = false;//for success true
                $data['code'] = 500;//for success code 200
                $data['message'] = 'Tickets Not Found';//for success message
            }
        }
        return $data;

    }

    public function partsRequestTechnician(Request $request)
    {
        $ticket_id = $request->ticket_id;
        $technician_user_id = $request->technician_user_id;
        $unique_job_number = $request->unique_job_number;
        $parts_id = $request->parts_id;
        $amt = ($request->amt*18)/(100)+($request->amt);
        $date = $request->date;
        $customer =customer_products::where('unique_job_number',$request->unique_job_number)->where('is_deleted',0)->first();
        
        if($technician_user_id == '' || $unique_job_number == '' || $ticket_id == '' || $parts_id == '' || empty($customer)) {
           
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'Something Went Wrong!';//for success message
        }
        else{
             $customer_id=$customer->customer_id;
            $input['amt'] = $amt;
            $input['final_price'] = $amt;
            $input['unique_job_number'] = $request->unique_job_number;
            $input['parts_id'] = $request->parts_id;
            $input['technician_user_id'] = $request->technician_user_id;
            $input['customer_id'] = $customer_id;
            $input['ticket_id'] = $request->ticket_id;
            $input['date'] = date('d-m-Y');
            $input['quantity'] = $request->quantity;
            //    $input['parts_id'] = implode(', ', $request->parts_id);
            PartsRequest::create($input);
            $data['data'] = $input;
            $data['success'] = true;
            $data['code'] = 200;
            $data['message'] = 'Technician Parts Are Requested Successfully';//for error message
        }
    return $data;
}

    public function technicianRequestCustomer(Request $request)
    {
        $customer_id = $request->customer_id;
        if($customer_id == '') {
        $data['error'] = false;//for success true
        $data['code'] = 500;//for success code 200
        $data['message'] = 'Something Went Wrong!';//for success message
    }
        else{
        $parts_request = PartsRequest::where('is_deleted', 0)->where('customer_id',$customer_id)->where('status','!=','Paid')->where('is_deleted',0)->orderBy('id','desc')->get();
        if (count($parts_request) > 0) {
            foreach ($parts_request as $part){
                $parts_id=explode(',',$part->parts_id);
                $quantity_details=explode(',',$part->quantity);
                $quantity_final=[];
                $data_final=[];
                foreach ($parts_id as $key=>$part_id)
                {
                    $parts=partDetails::where('id',$part_id)->where('is_deleted',0)->first();
                    $parts_title=parts::where('id',$parts->part_id)->first();
                    $parts->title=$parts_title->title;
                    $parts['quantity']=$quantity_details[$key];
                    $data_final[]=$parts;
                }
                $part->parts_details=$data_final;
                $customer_name=team::where('id',$customer_id)->where('is_deleted',0)->first();
                $part['customer_name']=$customer_name->name;
            }

            $data['data'] = $parts_request;//for success true
            $data['success'] = true;//for success true
            $data['code'] = 200;//for success code 200
            $data['message'] = 'Parts Data Found';//for success message
        }else {
            $data['data'] = 'No Data';//for success true
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'Technician Request To Customer Data Not Found';//for success message
        }
    }
        return $data;
    }

    public function technicianStatusCompleted(Request $request){
        $customer_id = $request->customer_id;
        if($customer_id == '') {
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'Something Went Wrong!';//for success message
        }
        else{
            $technician_request =  PartsRequest::where('customer_id',$customer_id)->where('status','=','completed')->where('is_deleted',0)->get();
            if (!empty($technician_request)) {
                $data['data'] = $technician_request;//for success true
                $data['success'] = true;//for success true
                $data['code'] = 200;//for success code 200
                $data['message'] = 'Technician Request Data To Customer Found ';//for success message
            } else {
                $data['data'] = 'No Data';//for success true
                $data['error'] = false;//for success true
                $data['code'] = 500;//for success code 200
                $data['message'] = 'Technician Request To Customer Data Not Found';//for success message
            }
        }

        return $data;

    }

    public function technicianTicketsHistory(Request $request)
    {
        $technician_user_id = $request->technician_user_id;
        $tickets = RaiseTickets::where('assigned_to', $technician_user_id)->where('status','=','Completed')->where('is_deleted',0)->orderBy('id','DESC')->get();
        foreach($tickets as $item) {
            $customer_name = customers::where('id', $item->customer_id)->first();
            $address = customer_products::where('unique_job_number', $item->unique_job_number)->where('is_deleted',0)->first();
            $team_name = team::where('id', $item->assigned_to)->first();
            if ($item->image != null) {
                $item['image'] = asset('images/products/' . $item->image);
            } else {
                $item['image'] = null;
            }
            if ($item->signature_image != null) {
                $item['signature_image'] = asset('signature/' . $item->signature_image);
            } else {
                $item['signature_image'] = null;
            }
            if ($item->close_image != null) {
                $item['close_image'] = asset('closeimage/' . $item->close_image);
            } else {
                $item['close_image'] = null;
            }

            $item->customer_id = $customer_name->name;
            $item->team_contact_number = $customer_name->contact_number;
            $item->assigned_to_title = $team_name->name;
            $item->assigned_to = $team_name->id;
            $item->address = $address->address;
            $item->door = $address->door;
            $item->cop_type = $address->cop_type;
            $item->lop_type = $address->lop_type;
            $item->passenger_capacity = $address->passenger_capacity;
            $item->model_id = $address->model_id;
            $item->number_of_floors = $address->number_of_floors;
            $item->customer_id = $address->customer_id;
            $item->distance = $address->distance;
            $item->unique_job_number = $address->unique_job_number;
            $item->warranty_start_date = $address->warranty_start_date;
            $item->warranty_end_date = $address->warranty_end_date;
            $item->ordered_date = $address->ordered_date;
            $item->warranty_status = $address->warranty_status;
            $item->no_of_services = $address->no_of_services;
            $zone=Zone::where('id',$address->zone)->where('is_deleted',0)->first();
            if(!empty($zone))
            {
                $item->zone = $zone->title;
            }
            else{
                $item->zone ='';
            }
            $item->amc_status = $address->amc_status;
            $item->amc_start_date = $address->amc_start_date;
            $item->amc_end_date = $address->amc_end_date;
            $item->contact_number = $team_name->contact_number;
            $item->name = $customer_name->name;

        }
        if (count($tickets) > 0) {
            $data['data'] = $tickets;//for success true
            $data['success'] = true;//for success true
            $data['code'] = 200;//for success code 200
            $data['message'] = 'Tickets Found';//for success message
        } else {
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'Tickets Not Found';//for success message
        }
        return $data;
    }

    public function deletePartsRequest(Request $request)
    {
        if($request->part_id == '' || $request->unique_job_number== '')
        {
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'Parts Request Not Found';//for success message
        }
        else{
            PartsRequest::where('id',$request->part_id)->forceDelete();
            $data['success'] = true;//for success true
            $data['code'] = 200;//for success code 200
            $data['message'] = 'Parts Request Delete';//for success message
        }
        return $data;
    }

    public function closeTicket(Request $request){
        $close_ticket=CloseTicket::get();
        if(!empty($close_ticket))
        {
            $data['data'] = $close_ticket;//for success true
            $data['success'] = true;//for success true
            $data['code'] = 200;//for success code 200
            $data['message'] = 'Close Tickets Updated Successfully';//for success message
        }
        else{
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'Something Went Wrong!';//for success message
        }

        return $data;
    }

    public function ticketStatus(Request $request){
        $this->validate($request, [
            'technician_id' => 'required',
            'ticket_id' => 'required',
            'status' => 'required',
            'reason' => 'required',
        ]);

        $ticket = TicketStatus::create([
            'technician_id' => $request->technician_id,
            'ticket_id' => $request->ticket_id,
            'status' => $request->status,
            'reason' => $request->reason,
            'date' => date('Y-m-d'),
        ]);

        $data['data'] = $ticket;//for success true
        $data['success'] = true;//for success true
        $data['code'] = 200;//for success code 200
        $data['message'] = 'Tickets Status Updated Successfully';//for success message
        return $data;
    }

    public function geticketStatus($ticket_id){
        $tickets = TicketStatus::where('ticket_id', $ticket_id)->latest('created_at')->limit(3)->with('getTechnician')->get();
        if(count($tickets) > 0) {
            $data['data'] = $tickets;//for success true
            $data['success'] = true;//for success true
            $data['code'] = 200;//for success code 200
            $data['message'] = 'Tickets Retrived Successfully';//for success message
        }
        else{
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'Something Went Wrong!';//for success message
        }

        return $data;
    }

    public function punchesIn(Request $request){
        $this->validate($request, [
            'ticket_id' => 'required',
            'technician_id' => 'required',
            'type' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'date' => 'required',
            'time' => 'required',
        ]);

        $existingPunch = Punches::where('technician_id', $request->technician_id)
            ->where('ticket_id', $request->ticket_id)
            ->whereDate('created_at','<=',date('Y-m-d H:s:i'))
            ->latest()
            ->first();

        if ($existingPunch && $existingPunch->type == 'in') {
            $data['error'] = false;
            $data['code'] = 500;
            $data['message'] = 'You have already punched in for the same ticket. Please punch out before punching in again.';
            return $data;
        }

        $anotherExistingPunch = Punches::where('technician_id', $request->technician_id)
            ->whereDate('created_at','<=',date('Y-m-d H:s:i'))->latest()
            ->first();

        if ($anotherExistingPunch && $anotherExistingPunch->ticket_id != $request->ticket_id && $request->type == 'out') {
            $data['error'] = false;
            $data['code'] = 500;
            $data['message'] = 'Technician cannot punch in for a different ticket without punching out of the current one.';
            return $data;
        }

        $distance = 0;
        $geTicket = RaiseTickets::where('id',$request->ticket_id)->select('unique_job_number')->first();
        if(!empty($geTicket) && !empty($geTicket->unique_job_number)){
            $getProduct = customer_products::where('unique_job_number', $geTicket->unique_job_number)->first();
            if(!empty($getProduct) && !empty($getProduct->latitude) && !empty($getProduct->longitude)){
                $distance = $this->getDistance($getProduct->latitude, $getProduct->longitude, $request->latitude, $request->longitude);
            }

            if(!empty($getProduct) && empty($getProduct->latitude) || empty($getProduct->longitude)){
                $distance = 0;
                // need to calculate lat log for product
            }
        }

        $punch = Punches::create(
            [
                'ticket_id' => $request->ticket_id,
                'technician_id' => $request->technician_id,
                'type' => $request->type,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'date' => $request->date,
                'time' => $request->time,
                'distance' => round($distance, 4),
            ]
        );

        $data['data'] = $punch;//for success true
        $data['success'] = true;//for success true
        $data['code'] = 200;//for success code 200
        $data['message'] = 'punch in done Successfully';//for success message
        return $data;
    }

    public function punchesOut(Request $request){
        $this->validate($request, [
            'ticket_id' => 'required',
            'technician_id' => 'required',
            'type' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'date' => 'required',
            'time' => 'required',
        ]);

        $existingPunch = Punches::where('technician_id', $request->technician_id)
            ->where('ticket_id', $request->ticket_id)
            ->whereDate('created_at','<=',date('Y-m-d H:s:i'))
            ->latest()
            ->first();

        if (empty($existingPunch)) {
            $data['error'] = false;
            $data['code'] = 500;
            $data['message'] = 'You have not punched in for this ticket';
            return $data;
        }
        else if($existingPunch && $existingPunch->type != 'in'){
            $data['error'] = false;
            $data['code'] = 500;
            $data['message'] = 'You have not punched in for this ticket';
            return $data;
        }


        $anotherExistingPunch = Punches::where('technician_id', $request->technician_id)
            ->where('ticket_id', $request->ticket_id)
            ->whereDate('created_at','<=',date('Y-m-d H:s:i'))
            ->latest()
            ->first();

        if (!empty($anotherExistingPunch) && $existingPunch->type == 'out') {
            $data['error'] = false;
            $data['code'] = 500;
            $data['message'] = 'You have already punched out for this ticket';
            return $data;
        }

        $distance = 0;
        $geTicket = RaiseTickets::where('id',$request->ticket_id)->select('unique_job_number')->first();
        if(!empty($geTicket) && !empty($geTicket->unique_job_number)){
            $getProduct = customer_products::where('unique_job_number', $geTicket->unique_job_number)->first();
            if(!empty($getProduct) && !empty($getProduct->latitude) && !empty($getProduct->longitude)){
                $distance = $this->getDistance($getProduct->latitude, $getProduct->longitude, $request->latitude, $request->longitude);
            }

            if(!empty($getProduct) && empty($getProduct->latitude) || empty($getProduct->longitude)){
                $distance = 0;
                // need to calculate lat log for product
            }
        }

        $punch = Punches::create(
            [
                'ticket_id' => $request->ticket_id,
                'technician_id' => $request->technician_id,
                'type' => $request->type,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'date' => $request->date,
                'time' => $request->time,
                'distance' => round($distance, 4),
            ]
        );

        $data['data'] = $punch;//for success true
        $data['success'] = true;//for success true
        $data['code'] = 200;//for success code 200
        $data['message'] = 'punch out done Successfully';//for success message
        return $data;
    }

    function getDistance($lat1, $lon1, $lat2, $lon2) {
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        $earthRadius = 6371;

        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;

        $a = sin($dlat / 2) * sin($dlat / 2) +
            cos($lat1) * cos($lat2) *
            sin($dlon / 2) * sin($dlon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $earthRadius * $c;

        return $distance;
    }
}
