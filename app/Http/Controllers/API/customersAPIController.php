<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatecustomersAPIRequest;
use App\Http\Requests\API\UpdatecustomersAPIRequest;
use App\Models\customer_products;
use App\Models\plans;
use App\Models\customers;
use App\Models\Notification;
use App\Models\SubscriptionHistory;
use App\Repositories\customersRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\AuthorizedPerson;


/**
 * Class customerController
 * @package App\Http\Controllers\API
 */

class customersAPIController extends AppBaseController
{
    /** @var  customersRepository */
    private $customersRepository;

    public function __construct(customersRepository $customersRepo)
    {
        $this->customersRepository = $customersRepo;
    }

    public function customerLogin(Request $request){

        $number = $request->contact_number;
//        $signature=$request->signature;
        if($number == ''){
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'All Fields Required';//for error message
        }
        else{
            if(customers::where('contact_number',$number)->where('is_deleted',0)->exists()){
                $otp = rand(1000,9999);
                $api_key = "a6493a1e-e308-11eb-8089-0200cd936042";
                $sender_id='TEKNIX';
                $TemplateName='teknix_otp_template';
                $final_data=array(
                    'From'=>$sender_id,
                    'To'=>$number,
                    'TemplateName'=>$TemplateName,
                    'VAR1'=>$otp,
//                    'VAR2'=>$signature
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
                    $data['message'] = 'Something went wrong';//for error message
                }
                $response = [];
                $response['otp'] = $otp;
                $response['contact_number'] = $number;
                $data['success'] = true;//for success true
                $data['code'] = 200;//for success code 200
                $data['data'] = $response;
                $data['message'] = 'Number is correct';//for error message
            } elseif(AuthorizedPerson::where('contact_number',$number)->where('is_deleted',0)->exists()){
                $otp = rand(1000,9999);
                $api_key = "a6493a1e-e308-11eb-8089-0200cd936042";
                $sender_id='TEKNIX';
                $TemplateName='teknix_otp_template';
                $final_data=array(
                    'From'=>$sender_id,
                    'To'=>$number,
                    'TemplateName'=>$TemplateName,
                    'VAR1'=>$otp,
//                    'VAR2'=>$signature
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
                    $data['message'] = 'Something went wrong';//for error message
                }
                $response = [];
                $response['otp'] = $otp;
                $response['contact_number'] = $number;
                $data['success'] = true;//for success true
                $data['code'] = 200;//for success code 200
                $data['data'] = $response;
                $data['message'] = 'Number is correct';//for error message
            } else{
                $data['data'] = 'No Data';
                $data['error'] = false;
                $data['code'] = 500;
                $data['message'] = 'Customer Not Found';//for error message
            }
        }
        return $data;
    }

    public function customerOtpVerify(Request $request){
        $verfiy_code = $request->verfiy_code;
        $otp_code = $request->otp_code;
        if(customers::where('contact_number',$request->contact_number)->where('is_deleted',0)->exists()){
            $customer = customers::where('contact_number',$request->contact_number)->first();
            $customer['type'] = 'Customer';
            if($otp_code == $verfiy_code){
                $data['success'] = true;//for success true
                $data['data'] = $customer;//for success true
                $data['code'] = 200;//for success code 200
                $data['message'] = 'Login Successfully';//for error message
            }else{
                $data['error'] = false;
                $data['code'] = 500;
                $data['message'] = 'OTP is not matched';//for error message
            }
        } elseif(AuthorizedPerson::where('contact_number',$request->contact_number)->where('is_deleted',0)->exists()){
            $authorizedPerson = AuthorizedPerson::where('contact_number',$request->contact_number)->first();
            $customer = customers::where('id',$authorizedPerson->customer_id)->where('is_deleted',0)->first();
            if (!empty($customer)) {
                $customer['type'] = 'Customer';
                if($otp_code == $verfiy_code){
                    $data['success'] = true;//for success true
                    $data['data'] = $customer;//for success true
                    $data['code'] = 200;//for success code 200
                    $data['message'] = 'Login Successfully';//for error message
                }else{
                    $data['error'] = false;
                    $data['code'] = 500;
                    $data['message'] = 'OTP is not matched';//for error message
                }
            } else {
                $data['data'] = 'No Data';
                $data['error'] = false;
                $data['code'] = 500;
                $data['message'] = 'Customer Not Found';//for error message
            }
        } else{
            $data['data'] = 'No Data';
            $data['error'] = false;
            $data['code'] = 500;
            $data['message'] = 'Customer Not Found';//for error message
        }
        return $data;
    }
    public function customerTokenUpdate(Request $request)
    {
        $number = $request->user_id;
        $token = $request->device_token;
        if ($number == '' || $token == '') {
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'Something Went Wrong!';//for success message
        } else {
            if (customers::where('id', $request->user_id)->where('is_deleted', 0)->exists()) {
                $team = customers::where('id', $request->user_id)->where('is_deleted', 0)->first();
                if (empty($team->device_token)) {
                    customers::where('id', $request->user_id)->where('is_deleted', 0)->update(['device_token' => $request->device_token]);
                    $data['success'] = true;//for success true
                    $data['code'] = 200;//for success code 200
                    $data['message'] = 'Token Updated Successfully';//for success message
                } else {
                    if (customers::where('id', $request->user_id)->where('is_deleted', 0)->where('device_token', '!=', $request->device_token)->first()) {
                        customers::where('id', $request->user_id)->where('is_deleted', 0)->update(['device_token' => $request->device_token]);
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
    public function notifications(Request $request){
        $user_id = $request->user_id;
        $notifications = Notification::where('to_user_id',$user_id)->orWhere('to_user_id','0')->get();
        $data['data'] = $notifications;//for success true
        $data['success'] = true;//for success true
        $data['code'] = 200;//for success code 200
        $data['message'] = 'Notifications fetched successfully';//for succe
    }

//    public function show($id)
//    {
//        // Try to find the customer by their ID
//        $customer = customers::find($id);
//
//        // If the customer doesn't exist, return a 404 error
//        if (!$customer) {
//            return response()->json([
//                'error' => true,
//                'message' => 'Customer not found',
//                'code' => 404,
//            ], 404);
//        }
//
//        // Return the customer data
//        return response()->json([
//            'success' => true,
//            'message' => 'Customer fetched successfully',
//            'data' => $customer,
//            'code' => 200,
//        ], 200);
//    }


}
