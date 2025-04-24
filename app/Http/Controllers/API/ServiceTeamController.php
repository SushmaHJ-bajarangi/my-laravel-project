<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateteamAPIRequest;
use App\Http\Requests\API\UpdateteamAPIRequest;
use App\Models\BackupTeam;
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
use App\Events\AssignTicketEvent;
use Illuminate\Support\Facades\Log;
use Edujugon\PushNotification\PushNotification;
/**
 * Class teamController
 * @package App\Http\Controllers\API
 */

class ServiceTeamController extends AppBaseController
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
    public function servicetechnicianLogin(Request $request)
    {
        $number = $request->contact_number;
//        $signature = $request->signature;
        if ($number == '') {
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'All Fields Required';//for error message
        } else {
            if (BackupTeam::where('contact_number', $number)->where('is_deleted', 0)->exists()) {
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
            } else {
                $data['data'] = 'No Data';
                $data['error'] = false;
                $data['code'] = 500;
                $data['message'] = 'Service Technician Not Found';//for error message
            }
        }
        return $data;
    }

    public function servicetechnicianOtpVerify(Request $request)
    {
        $verfiy_code = $request->verfiy_code;
        $otp_code = $request->otp_code;
        if (BackupTeam::where('contact_number', $request->contact_number)->where('is_deleted', 0)->exists()) {
            $team = BackupTeam::where('contact_number', $request->contact_number)->where('is_deleted',0)->first();
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
        } else {
            $data['data'] = 'No Data';
            $data['error'] = false;
            $data['code'] = 500;
            $data['message'] = 'Service Technician Not Found';//for error message
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

    public function servicetokenUpdate(Request $request)
    {
        $number = $request->contact_number;
        $token = $request->device_token;
        if ($number == '' || $token == '') {
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'Something Went Wrong!';//for success message
        } else {
            if (BackupTeam::where('contact_number', $request->contact_number)->where('is_deleted', 0)->exists()) {
                $team = BackupTeam::where('contact_number', $request->contact_number)->where('is_deleted', 0)->first();
                if (empty($team->device_token)) {
                    BackupTeam::where('contact_number', $request->contact_number)->where('is_deleted', 0)->update(['device_token' => $request->device_token]);
                    $data['success'] = true;//for success true
                    $data['code'] = 200;//for success code 200
                    $data['message'] = 'Token Updated Successfully';//for success message
                } else {
                    if (BackupTeam::where('contact_number', $request->contact_number)->where('is_deleted', 0)->where('device_token', '!=', $request->device_token)->first()) {
                        BackupTeam::where('contact_number', $request->contact_number)->where('is_deleted', 0)->update(['device_token' => $request->device_token]);
                        $data['success'] = true;//for success true
                        $data['code'] = 200;//for success code 200
                        $data['message'] = 'Token Updated Successfully';//for success message
                    } else {
                        $data['success'] = true;//for success true
                        $data['code'] = 200;//for success code 200
                        $data['message'] = 'Token Already Found';//for success message
                    }
                }
            } else {
                $data['error'] = false;//for success true
                $data['code'] = 500;//for success code 200
                $data['message'] = 'Technician Not Found';//for success message
            }
        }
        return $data;
    }

}
