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
use App\Models\plans;
use App\Models\Transactions;
use App\Models\customers;
use App\Models\PartsRequest;
use App\Models\customer_products;
use Appnings\Payment\Facades\Payment;
use Illuminate\Http\Request;
use Response;
use App\Models\GenerateQuote;
use App\Models\GenerateQuoteDetails;
use DataTables;
use App\Models\Services;
use App\Models\team;

use Illuminate\Support\Facades\DB;
class paymentHistoryController extends AppBaseController
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function paymentHistory()
    {
        $history = Transactions::where('is_deleted',0)->orderBy('id','DESC')->get();
        foreach ($history as $item)
        {
            $customer_name = customers::where('id', $item->customer_id)->first();

            $item['customer_name']=$customer_name->name;

            if ($item->transaction_for == 'AMC')
            {
                $job_number = GenerateQuoteDetails::where('quote_id', $item->merchant_param2)->first();
                if(isset($job_number->unique_job_number)){
                    $item['unique_job_number'] = $job_number->unique_job_number;
                }
            }
            else
            {
                $job_number = PartsRequest::where('id', $item->merchant_param2)->first();
                $item['unique_job_number']=$job_number->unique_job_number;
            }
        }

        return view('paymentHistory.index', compact('history'));
    }

    public function filter(Request $request)
    {
        if ($request->transaction_for == 'All')
        {
            $filter = Transactions::where('is_deleted',0)->get();
            foreach ($filter as $item)
            {
                $customer_name = customers::where('id', $item->customer_id)->first();
                $item['customer_name']=$customer_name->name;

                if ($item->transaction_for == 'AMC')
                {
                    $job_number = GenerateQuoteDetails::where('id', $item->merchant_param2)->first();
                    $item['unique_job_number']=$job_number->unique_job_number;
                }
                else
                {
                    $job_number = PartsRequest::where('id', $item->merchant_param2)->first();
                    $item['unique_job_number']=$job_number->unique_job_number;
                }
            }
        }
        else
        {
            $filter = Transactions::where('transaction_for', $request->transaction_for)->get();
            foreach ($filter as $item)
            {
                $customer_name = customers::where('id', $item->customer_id)->first();
                $item['customer_name']=$customer_name->name;

                if ($item->transaction_for == 'AMC')
                {
                    $job_number = GenerateQuoteDetails::where('id', $item->merchant_param2)->first();
                    $item['unique_job_number']=$job_number->unique_job_number;
                }
                else
                {
                    $job_number = PartsRequest::where('id', $item->merchant_param2)->first();
                    $item['unique_job_number']=$job_number->unique_job_number;
                }
            }
        }
        return response()->json($filter);
    }

    public function getpaymenthistory()
    {
        $filter = Transactions::where('is_deleted',0)->get();
        return response()->json($filter);
    }

    public function getHistory(Request $request){

        if ($request->ajax()) {
            $data = DB::table('transactions')
                ->select('transactions.id', 'transactions.unique_job_number', 'transactions.customer_id', 'transactions.order_id', 'transactions.bank_ref_no', 'transactions.payment_mode', 'transactions.amount', 'transactions.transaction_for')
                ->where('is_deleted',0)
                ->get();
            return Datatables::of($data)
                ->addIndexColumn()
            ->addColumn('action', function ($row) {
                    return 'acton';
            })
                ->rawColumns(['action'])->make(true);

        }
    }
    public function amcpayment(){
        $customerProduct = customer_products::where('is_deleted',0)->get();
        foreach ($customerProduct as $item)
        {
            $customerProducts=GenerateQuoteDetails::where("unique_job_number",$item)->where('amc_status','!=','active')->groupBy('unique_job_number')->get();
        }
        $plans=plans::where('is_deleted',0)->get();
        return view('paymentHistory/amcpayment',compact('plans','customerProducts','customerProduct'));
    }

    public function createamcpayment(Request $request){
        $quotes_details=GenerateQuoteDetails::where('unique_job_number',$request->unique_job_number)->where('amc_status','active')->first();
        if(!empty($quotes_details))
        {
            $msg = "This Project have already AMC Active";
            return response()->json(array('msg'=> $msg), 200);
        }
        else{
            $product=customer_products::where('unique_job_number',$request->unique_job_number)->first();
            $customer=customers::where('id',$product->customer_id)->first();
            $data['customer_id']=$product->customer_id;
            $data['customer_job_id']=$product->unique_job_number;
            $data['status']='Completed';
            $getId =GenerateQuote::create($data);
            $dataQuote['quote_id']=$getId->id;
            $dataQuote['plan']=$request->plan;
            $dataQuote['price']=$request->amount;
            $dataQuote['start_date']=$request->start_date;
            $dataQuote['end_date']=$request->end_date;
            $dataQuote['payment_type']='cheque';
            $dataQuote['status']='Paid';
            $dataQuote['customer_id']=$product->customer_id;
            $dataQuote['payment_date']=date('d-m-Y');
            $dataQuote['final_amount']=$request->amount;
            $dataQuote['payment_id']=$product->customer_id.'_'.rand(10000,999999);
            $dataQuote['unique_job_number']=$product->unique_job_number;
            $dataQuote['amc_status']='active';
            $dataQuote['service']=$request->services;
            GenerateQuoteDetails::create($dataQuote);
            $input['customer_id']=$product->customer_id;
            $input['payment_mode']='Cheque';
            $input['order_id']=$product->customer_id.'_'.rand(10000,999999);
            $input['amount']=$request->amount;
            $input['currency']='INR';
            $input['billing_name']=$customer->name;
            $input['billing_address']=$product->address;
            $input['billing_city']='Bangalore';
            $input['billing_state']='Karnataka';
            $input['billing_country']='India';
            $input['billing_tel']=$customer->contact_number;
            $input['billing_email']=$customer->email;
            $input['billing_zip']='560091';
            $input['merchant_param1']=$customer->id;
            $input['merchant_param2']=$getId->id;
            $input['merchant_param3']='AMC';
            $input['transaction_for']='AMC';
            $input['trans_date']=date('d-m-Y H:i:s');
            Transactions::create($input);
            $userDetail['status'] = 'Under AMC';
            $userDetail['amc_status'] = 'Under AMC';
            $userDetail['amc_start_date'] = $request->start_date;
            $userDetail['warranty_start_date'] = $request->start_date;
            $userDetail['amc_end_date'] = $request->end_date;
            $userDetail['warranty_end_date'] = $request->end_date;
            $userDetail['no_of_services'] = $request->services;
            customer_products::where('unique_job_number',$request->unique_job_number)->update($userDetail);

            $serviceLength=$request->services;
            $plan_days=plans::where('id',$request->plan)->first();
            $days=($plan_days->duration*30)/$serviceLength;

            for($i=1; $i <=$serviceLength; $i++)
            {

                $service_date=date('d-m-Y', strtotime($request->start_date . ' +'.$i*$days.' day'));
                $warrantyStartDate = $service_date;
                $assigned_date = $warrantyStartDate;
                $month = date('m',strtotime($assigned_date));
                $start_date = date('01-m-Y',strtotime($assigned_date));
                $end_day = date('t',strtotime($assigned_date));
                $zone = $product->zone;
                $current_date = $start_date;
                $current_day=1;
                $team_id = team::where('zone',$zone)->first();
                $no_of_services=0;
                $final_date = $this->assignService($assigned_date,$month,$start_date,$end_day,$zone,$no_of_services,$current_date,$team_id->id,$current_day);

                $services = [];
                $services['customer_id'] = $product->customer_id;
                $services['unique_job_number'] = $product->unique_job_number;
                $services['customer_product_id'] = $product->id;
                $services['date'] = $final_date;
                $services['status'] = 'Assigned';
                $services['technician_id'] = '';
                $services['assign_team_id'] = $team_id->id;
                $services['zone'] = $product->zone;
                $services['service_type'] = "AMC";
                $service['passenger_capacity']=$product->passenger_capacity;
                Services::create($services);

            }

        }
        $msg = "AMC Payment done Successfully ";
        return response()->json(array('msg'=> $msg,'status_data'=>'success'), 200);
    }
    public function assignService($assigned_date,$month,$start_date,$end_day,$zone,$no_of_services,$current_date,$team_id,$current_day){
        $dayName = date('D', strtotime($current_date));
        if($dayName == 'Sun'){
            $current_day++;
            $current_date = date($current_day.'-m-Y',strtotime($assigned_date));
            $current_date = date('d-m-Y',strtotime($current_date));
        }

        $existingServiceCount = Services::where('date',$current_date)->where('assign_team_id',$team_id)->count();

        if($existingServiceCount <= $no_of_services){
            return $current_date;
        }
        else{
            if($current_day >= $end_day) {
                $no_of_services++;
                $current_day=01;
                $current_date = $start_date;
            }
            else {
                $current_day++;
                $current_date = date($current_day.'-m-Y',strtotime($assigned_date));
                $current_date = date('d-m-Y',strtotime($current_date));
            }
            $fDate = $this->assignService($assigned_date,$month,$start_date,$end_day,$zone,$no_of_services,$current_date,$team_id,$current_day);
            return $fDate;
        }
    }
}