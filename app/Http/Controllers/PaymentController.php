<?php
/**
 * Created by PhpStorm.
 * User: hiteshtank
 * Date: 25/08/21
 * Time: 5:42 PM
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\AppBaseController;
use App\Models\Transactions;
use App\Models\customers;
use App\Models\PartsRequest;
use Appnings\Payment\Facades\Payment;
use Illuminate\Http\Request;
use Response;
use App\Models\GenerateQuote;
use App\Models\GenerateQuoteDetails;

class PaymentController extends AppBaseController
{
    public function payment($request_id)
    {
        if($request_id){
            echo '
               <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
               <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
               <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
               <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>';
        }
        echo '<center><div class="card" style="margin: 110px 10px 10px 10px;display:inline-block">
                  <div class="card-body">
                    <span class="card-title"><div class="spinner-border text-warning"></div>
                         <p>Please wait We are redirecting you to payment page</p>
                    </span>
                  </div>
              </div></center>';
        $partRequest =PartsRequest::whereId($request_id)->first();
        if(!empty($partRequest)){
            $customer = customers::whereId($partRequest->customer_id)->first();
            if(!empty($customer)){
                $parameters = [
//                    'tid' => rand(100,999)."_".time(),
                    'order_id'=>$customer->id.'_'.$partRequest->id.'_'.rand(1000,9999),
                    'amount' => $partRequest->final_price,
                    'currency' => 'INR',
                    'billing_name'=>$customer->name,
                    'billing_address'=>$customer->address,
                    'billing_city'=>'Bangalore',
                    'billing_state'=>'Karnataka',
                    'billing_country'=>'India',
                    'billing_tel'=>$customer->contact_number,
                    'billing_email'=>$customer->email,
                    'billing_zip'=>'560091',
                    'merchant_param1'=>$customer->id,
                    'merchant_param2'=>$request_id,
                    'merchant_param3'=>'Parts Request Payment',
                ];

                $order = Payment::prepare($parameters);
                return Payment::process($order);
            }
            else{
                return redirect('payment/error/c404');
            }
        }
        else{
            return redirect('payment/error/p404');
        }
    }
    public function amcpayment($Quotes_id)
    {
        if($Quotes_id){
            echo '
               <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
               <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
               <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
               <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>';
        }
        echo '<center><div class="card" style="margin: 110px 10px 10px 10px;display:inline-block">
                  <div class="card-body">
                    <span class="card-title"><div class="spinner-border text-warning"></div>
                         <p>Please wait We are redirecting you to payment page</p>
                    </span>
                  </div>
              </div></center>';
//        echo '<div class="card" style="margin-top: 100px"><div class="spinner-border text-warning"></div><p>Please wait We are redirecting you to payment page</p></div>';
        $partRequest =GenerateQuoteDetails::whereId($Quotes_id)->first();
        if(!empty($partRequest)){
            $customer = customers::whereId($partRequest->customer_id)->first();
            if(!empty($customer)){

                $parameters = [
//                    'tid' => rand(100,999)."_".time(),
                    'order_id'=>$customer->id.'_'.$partRequest->id.'_'.rand(1000,99999),
                    'amount' => $partRequest->price,
                    'currency' => 'INR',
                    'billing_name'=>$customer->name,
                    'billing_address'=>$customer->address,
                    'billing_city'=>'Bangalore',
                    'billing_state'=>'Karnataka',
                    'billing_country'=>'India',
                    'billing_tel'=>$customer->contact_number,
                    'billing_email'=>$customer->email,
                    'billing_zip'=>'560091',
                    'merchant_param1'=>$customer->id,
                    'merchant_param2'=>$Quotes_id,
                    'merchant_param3'=>'AMC',
                ];
                $order = Payment::prepare($parameters);
                return Payment::process($order);
            }
            else{
                return redirect('payment/error/c404');
            }
        }
        else{
            return redirect('payment/error/p404');
        }
    }
    public function success(Request $request)
    {

        if($request){
            echo '
               <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
               <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
               <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
               <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>';
        }
        echo '<center><div class="card" style="margin: 110px 10px 10px 10px;display:inline-block">
                  <div class="card-body">
                    <span class="card-title"><div class="spinner-border text-warning"></div>
                         <p>Please wait We are Confirming your Payment</p>
                    </span>
                  </div>
              </div></center>';
        try{
            $response = Payment::gateway('CCAvenue')->response($request);

            $data = $response;
            if($response['merchant_param3']=='AMC')
            {
                $data['customer_id']=$response['merchant_param1'];
                $data['transaction_for']=$response['merchant_param3'];
                Transactions::create($data);
                return redirect('payment/done/'.$response['order_id']);
            }

            else{
                $data['customer_id']=$response['merchant_param1'];
                $data['transaction_for']=$response['merchant_param3'];
                Transactions::create($data);
                return redirect('payment/done/'.$response['order_id']);
            }
        }
        catch (\Exception $e){
            return redirect('payment/not_done');
        }

    }
    public function done($transaction_id){
        echo 'Loading ...';
    }
    public function not_done(){
        echo 'Something went wrong';
    }
}