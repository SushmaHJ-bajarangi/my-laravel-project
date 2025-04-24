<?php

namespace App\Http\Controllers\API;

use App\Models\customer_products;
use App\Models\plans;
use App\Models\customers;
use App\Models\SubscriptionHistory;
use App\Models\PaymentHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use Illuminate\Support\Facades\Mail;

/**
 * Class customerController
 * @package App\Http\Controllers\API
 */

class historyAPIController extends AppBaseController
{
    public function subscriptionHistory(Request $request){
        $plan = $request->plan;
        $customer_id = $request->customer_id;
        $unique_job_number = $request->unique_job_number;
        $amt = $request->amt;
        $payment_method = $request->payment_method;
        $transaction_id = $request->transaction_id;
        if(customers::where('id',$customer_id)->exists()){
            $plan_date = plans::where('id',$plan)->first();
            $getNumber = explode(' ',$plan_date->duration);
            $end_date = date('Y-m-d', strtotime('+'.$getNumber[0].' months'));
            $input['plan'] = $plan;
            $input['customer_id'] = $customer_id;
            $input['unique_job_number'] = $unique_job_number;
            $input['amt'] = $amt;
            $input['payment_method'] = $payment_method;
            $input['transaction_id'] = $transaction_id;
            $input['start_date'] = date('Y-m-d');
            $input['end_date'] = $end_date;
            $history = SubscriptionHistory::create($input);

            $Pinput['unique_job_number'] = $history->unique_job_number;
            $Pinput['customer_id'] = $history->customer_id;
            $Pinput['amt'] = $history->amt;
            $Pinput['payment_type'] = 'Subscription';
            $Pinput['date'] =  date('Y-m-d');
            PaymentHistory::create($Pinput);

            $data['success'] = true;//for success true
            $data['data'] = $input;//for success true
            $data['code'] = 200;//for success code 200
            $data['message'] = 'Payment Successfully';//for error message
        }
        else{
            $data['data'] = 'No Data';
            $data['error'] = false;
            $data['code'] = 500;
            $data['message'] = 'Customer Not Found';//for error message
        }
        return $data;
    }

    public function cronJob(){
        $customers = customers::whereNotNull('email')->where('is_deleted','0')->get();
        foreach ($customers as $customer){
            $history = SubscriptionHistory::where('customer_id',$customer->id)->where('is_deleted',0)->first();
            $date = $history->end_date;
            $end_date = date('Y-m-d', strtotime('-7 days', strtotime($date)));
            SubscriptionHistory::where('end_date','<',$end_date)->where('is_deleted',0)->get();
            $email = $customer->email;
            $name = $customer->name;
            try{
                $data = [
                    'email' => $email,
                    'end_date' => $date,
                    'name' => $name,
                ];

                Mail::send('subscription_email', $data, function($message) use ($data)
                {
                    $message->to($data["email"], $data["end_date"], $data["name"])->subject('Email Sending');
                });
                $data1['success'] = true;//for success true
                $data1['code'] = 200;//for success code 200
                $data1['message'] = 'Mail Sent.';//for success message
                return $data1;
            }
            catch (\Exception $exception){
                $data2['error'] = false;//for success true
                $data2['code'] = 500;//for success code 200
                $data2['message'] = $exception->getMessage();//for success message
                return $data2;
            }
        }
    }
}