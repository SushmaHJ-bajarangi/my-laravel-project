<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatepartsAPIRequest;
use App\Http\Requests\API\UpdatepartsAPIRequest;
use App\Models\parts;
use App\Models\partDetails;
use App\Repositories\partsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\PartsRequest;
use App\Models\customers;
use App\Models\Transactions;
use Edujugon\PushNotification\PushNotification;
use App\Models\team;



/**
 * Class partsController
 * @package App\Http\Controllers\API
 */

class partsAPIController extends AppBaseController
{
    /** @var  partsRepository */
    private $partsRepository;
    public function __construct(partsRepository $partsRepo)
    {
        $this->partsRepository = $partsRepo;
    }
    public function getParts(){
        $parts=partDetails::where('is_deleted',0)->get();
        foreach ($parts as $item)
        {
            $parts_title=parts::where('id',$item->part_id)->where('is_deleted',0)->first();
            if(!empty($parts_title)){
                $item->title=$parts_title->title;
            }
            else{
                $item->title='';
            }
        }

        if(count($parts) > 0){
            $data['data'] = $parts;//for success true
            $data['success'] = true;//for success true
            $data['code'] = 200;//for success code 200
            $data['message'] = 'Parts found';//for success message
        }
        else{
            $data['data'] = 'No Data';//for success true
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'Not Found';//for success message
        }
        return $data;
    }
    public function getPartsRequests(Request $request)
    {
        $technician_user_id = $request->technician_user_id;
        $parts_request = PartsRequest::where('is_deleted', 0)->where('technician_user_id',$technician_user_id)->where('status','!=','Paid')->orderBy('id','desc')->where('is_deleted',0)->get();
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
                $customer_name=customers::where('id',$part->customer_id)->where('is_deleted',0)->first();
                $part['customer_name']=$customer_name->name;
                $part['user_id']=$part->customer_id;
                $part['quantity']=$quantity_final;

            }
            $data['data'] = $parts_request;//for success true
            $data['success'] = true;//for success true
            $data['code'] = 200;//for success code 200
            $data['message'] = 'Parts data found';//for success message
        } else {
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'Parts data Not Found';//for success message
        }
        return $data;
    }
    public function partsPaymentNotification(Request $request)
    {
            $customer_detail=customers::where('id',$request->user_id)->where('is_deleted',0)->first();
            $parts_details=PartsRequest::where('id',$request->partsRequest_id)->where('is_deleted',0)->first();
            $push = new PushNotification('fcm');
            $push->setMessage([
                'notification' => [
                    'title' => 'Hello '.$customer_detail->name .' this notification from Teknix elevators PVT LTD for  payment reminder ' ,
                    'body' => 'you have purchase parts for your lift this notification for payment reminding please check this ',
                    'image'=>'https://bajarangisoft.com/Teknix/public/images/logo.png',
                    'sound' => 'default',
                    "content_available"=> true,
                    "click_action"=> "FLUTTER_NOTIFICATION_CLICK",
                ],
                'data' => [
                    'data_notification' => "payment_reminder",
                    'part_request_id' => $request->partsRequest_id,
                    'amount' => $parts_details->final_price,
                    'customer_name' => $customer_detail->name,


                ],
                'click_action'=>'FLUTTER_NOTIFICATION_CLICK'
            ])
                ->setApiKey('AAAAfOmmId0:APA91bFAFAjNjvpC3-Oua0JrJmCO07MHwLVpPbNNr-uhdUGWyE1_4GXyxFTOdozcls7gsh9yUx1vPtUXCyRPupll3pjdDveNW39zHoMQ2jfDicq7TpHF75b2D2YC5bKm12ftyC7o4FI2')
                ->setDevicesToken($customer_detail->device_token)
                ->send();
            $push->getFeedback();
            $data['success'] = true;//for success true
            $data['code'] = 200;//for success code 200
            $data['message'] = 'Notification sent successfully';//for success message

         return $data;
    }
    public function part_payment_done(Request $request){
        $partRequest_id = $request->part_request_id;
        $orderId = $request->order_id;
        $transaction = Transactions::where('order_id',$orderId)->first();
        if(!empty($transaction)){
            $data['payment_type']='online';
            $data['payment_id']=$transaction->id;
            $data['payment_method']=$transaction->payment_mode;
            $data['payment_date']=date('Y-m-d');
            $data['status']='Paid';
            $data['admin_status']='Paid';
            PartsRequest::whereId($partRequest_id)->update($data);
        }
        $data1['success'] = true;//for success true
        $data1['code'] = 200;//for success code 200
        $data1['message'] = 'Payment done successfully';//for success message

        return $data1;
    }
    public function cashPaymentRequest(Request $request)
    {
        $partRequest_id = $request->part_request_id;
        $customer_id = $request->customer_id;
        $customer_detail=customers::where('id',$customer_id)->where('is_deleted',0)->first();
        $parts_cash=PartsRequest::where('id',$partRequest_id)->where('customer_id',$customer_id)->where('is_deleted',0)->first();

        if(!empty($parts_cash)){
            $data['payment_type']='Cash';
            $data['payment_id']=rand(100000,10000000);
            $data['payment_method']='Cash';
            $data['payment_date']=date('Y-m-d');
            $data['status']='Pending';
            PartsRequest::whereId($partRequest_id)->update($data);
            $input['order_id']=$customer_id.'_'.$partRequest_id.'_'.rand(1000,9999);
            $input['customer_id']=$customer_id;
            $input['merchant_param1']=$request->customer_id;
            $input['merchant_param2']=$request->part_request_id;
            $input['merchant_param3']='Parts Request Payment';
            $input['transaction_for']='Parts Request Payment';
            $input['payment_mode']='Cash';
            $input['currency']='INR';
            $input['amount']=$parts_cash->amt;
            $input['billing_name']=$customer_detail->name;
            $input['billing_address']=$customer_detail->address;
            $input['billing_city']='Banglore';
            $input['billing_state']='Karanataka';
            $input['billing_zip']='560091';
            $input['billing_country']='India';
            $input['billing_tel']=$customer_detail->contact_number;
            $input['billing_email']=$request->email;
            $input['delivery_name']=$request->name;
            $input['delivery_address']=$request->address;
            $input['delivery_city']='Banglore';
            $input['delivery_state']='Karanataka';
            $input['delivery_zip']='560091';
            $input['delivery_country']='India';
            $input['delivery_tel']=$customer_detail->contact_number;
            $input['mer_amount']=$parts_cash->amt;
            $input['trans_date']=date('d-m-Y H:i:s');
            Transactions::create($input);
        }
        $data1['success'] = true;//for success true
        $data1['code'] = 200;//for success code 200
        $data1['message'] = 'Payment done successfully';//for success message

        return $data1;
    }
    public function cashpaymentreminder(Request $request)
    {
        $PartsRequest_detail=PartsRequest::where('id',$request->part_request_id)->where('is_deleted',0)->first();
        if(empty($PartsRequest_detail))
        {
            $data['data'] = 'No Data';//for success true
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'User not found';//for success message
        }
        else{
            $PartsRequest_detail=PartsRequest::where('id',$request->part_request_id)->where('is_deleted',0)->first();
            $customer_details=customers::where('id',$PartsRequest_detail->customer_id)->where('is_deleted',0)->first();
            $team_deatils=team::where('id',$PartsRequest_detail->technician_user_id)->where('is_deleted',0)->first();
            $push = new PushNotification('fcm');
            $push->setMessage([
                'notification' => [
                    'title' => 'Hello '.$customer_details->name .' this notification from Teknix elevators PVT LTD for cash payment reminder ' ,
                    'body' => 'you have purchase parts for your lift this notification for payment reminding please check this ',
                    'image'=>'https://bajarangisoft.com/Teknix/public/images/logo.png',
                    'sound' => 'default',
                    "content_available"=> true,
                    "click_action"=> "FLUTTER_NOTIFICATION_CLICK",
                ],
                'data' => [
                    'data_notification' => "cashreminder",
                    'part_request_id' => $request->part_request_id,
                    'customer_name' => $customer_details->name,
                    'amount' => $PartsRequest_detail->amt,
                    'body' => 'tank',
                    'click_action'=>'FLUTTER_NOTIFICATION_CLICK',

                ],
                'click_action'=>'FLUTTER_NOTIFICATION_CLICK'
            ])
                ->setApiKey('AAAAfOmmId0:APA91bFAFAjNjvpC3-Oua0JrJmCO07MHwLVpPbNNr-uhdUGWyE1_4GXyxFTOdozcls7gsh9yUx1vPtUXCyRPupll3pjdDveNW39zHoMQ2jfDicq7TpHF75b2D2YC5bKm12ftyC7o4FI2')
                ->setDevicesToken($team_deatils->device_token)
                ->send();
            $push->getFeedback();
            $data['success'] = true;//for success true
            $data['code'] = 200;//for success code 200
            $data['message'] = 'Notification sent successfully';//for success message

        }
        return $data;
    }
    public function cashrecievedstatus(Request $request)
    {
        $PartsRequest_detail=PartsRequest::where('id',$request->partsRequest_id)->where('status','Pending')->where('is_deleted',0)->first();
        if(empty($PartsRequest_detail))
        {
            $data['data'] = 'No Data Found for this ticket';//for success true
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'User not found';//for success message
        }
        else{
            $PartsRequest_detail_update=PartsRequest::where('id',$request->partsRequest_id)->where('technician_user_id',$request->technician_user_id)->update(['status'=>'Paid']);
            $data['success'] = true;//for success true
            $data['code'] = 200;//for success code 200
            $data['message'] = 'Notification sent successfully';//for success message
        }
        return $data;
    }


}
