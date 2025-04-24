<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateplansAPIRequest;
use App\Http\Requests\API\UpdateplansAPIRequest;
use App\Models\customer_products;
use App\Models\plans;
use App\Models\GenerateQuote;
use App\Models\GenerateQuoteDetails;
use App\Repositories\plansRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\Services;
use App\Models\customers;
use App\Models\Transactions;
use App\Models\team;

use Edujugon\PushNotification\PushNotification;
/**
 * Class plansController
 * @package App\Http\Controllers\API
 */

class plansAPIController extends AppBaseController
{
    /** @var  plansRepository */
    private $plansRepository;

    public function __construct(plansRepository $plansRepo)
    {
        $this->plansRepository = $plansRepo;
    }


    public function getPlans(){
        $parts = plans::where('is_deleted',0)->select('id','title','description')->get();
        if(count($parts) > 0){
            $data['data'] = $parts;//for success true
            $data['success'] = true;//for success true
            $data['code'] = 200;//for success code 200
            $data['message'] = 'Plans found';//for success message
        }
        else{
            $data['data'] = 'No Data';//for success true
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'Not Found';//for success message
        }
        return $data;
    }

    public function generateQuote(Request $request){
        $customer_id = $request->customer_id;
        $plan = $request->plan;
        $customer_job_id = $request->customer_job_id;
        if(!empty($plan)) {
            $input['customer_id'] = $customer_id;
            $input['customer_job_id'] = $customer_job_id;
            $input['status'] = 'pending';
            $getId = GenerateQuote::create($input);
            $plan_array=explode(',',$plan);
            for ($i = 0; $i < count($plan_array); $i++) {
                if($plan_array[$i] != ''){
                    $quote = [];
                    $quote['quote_id'] = $getId->id;
                    $quote['plan'] = $plan_array[$i];
                    $quote['customer_id'] = $customer_id;
                    $quote['unique_job_number'] = $request->customer_job_id;
                    GenerateQuoteDetails::create($quote);
                }
            }
            $data['data'] = $input;//for success true
            $data['success'] = true;//for success true
            $data['code'] = 200;//for success code 200
            $data['message'] = 'Quote Added Successfully';//for success message
        }
        else{
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'Required';//for success message
        }
        return $data;
    }

    public function getGeneratedQuote(Request $request){
        $customer_job_number = $request->customer_job_number;
        if(GenerateQuote::where('customer_job_id',$customer_job_number)->where('is_deleted',0)->exists()){
            $getQuote = GenerateQuote::where('customer_job_id',$customer_job_number)->where('is_deleted',0)->with('getGenerateQuoteDetails')->first();
            $data['data'] = $getQuote;//for success true
            $data['success'] = true;//for success true
            $data['code'] = 200;//for success code 200
            $data['message'] = 'Quotes Found';//for success message
        }
        else{
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'Customer Job Number Not Exists';//for success message
        }
        return $data;
    }
    public function planlist(Request $request)
    {
        $date=date('d-m-Y');
        $quotes=GenerateQuoteDetails::where('customer_id',$request->customer_id)->where('unique_job_number',$request->unique_job_number)->where('amc_status','!=','active')->where('status','!=','Paid')->where('is_deleted',0)->get();

            if(count($quotes) > 0)
            {
                foreach ($quotes as $item)
                {
                    $Quotes_details=GenerateQuoteDetails::where('customer_id',$request->customer_id)->where('unique_job_number',$request->unique_job_number)->where('amc_status','!=','active')->where('is_deleted',0)->get();
                    foreach ($Quotes_details as $datafinal)
                    {
                        $plan_id[]=$datafinal->plan;
                    }
                }
                $planList=plans::where('is_deleted',0)->get();
                foreach ($planList as $item) {
                    if(count($plan_id) > 0)
                    {
                        if(in_array($item->id, $plan_id))
                        {
                            $item['value_in']='yes';
                            $Quotes_details=GenerateQuoteDetails::where('plan',$item->id)->where('customer_id',$request->customer_id)->where('unique_job_number',$request->unique_job_number)->where('amc_status','!=','active')->where('is_deleted',0)->first();
                            $item['Quotes_id']=$Quotes_details->id;
                            if($Quotes_details->price !=null)
                            {
                                $item['price']=$Quotes_details->price;
                            }
                            else{
                                $item['price']='';
                            }

                        }
                        else
                        {
                            $item['value_in']='no';
                            $item['price']='';
                        }
                    }
                    else{
                        $item['value_in']='no';
                    }


                }
                if(count($planList) > 0)
                {
                    $data['data']=$planList;
                    $data['success'] = true;//for success true
                    $data['code'] = 200;//for success code 200
                    $data['message'] = 'Quotes Found';//for success message

                }
                else{
                    $data['error'] = false;//for success true
                    $data['code'] = 500;//for success code 200
                    $data['message'] = 'No plans Avaialable';//for success message
                }
            }
            else{
                $planList=plans::where('is_deleted',0)->get();
                foreach ($planList as $item)
                {
                    $item['value_in']='no';
                }
                $data['data']=$planList;
                $data['success'] = true;//for success true
                $data['code'] = 200;//for success code 200
                $data['message'] = 'Quotes Found';//for success message
                $data['plan_required'] = 'yes';//for success message
            }

        return $data;
    }
    public function amc_payment_done(Request $request){
        $partRequest_id = $request->Quotes_id;
        $orderId = $request->order_id;
        $transaction = Transactions::where('order_id',$orderId)->first();
        $amc_service=GenerateQuoteDetails::whereId($partRequest_id)->first();
        $plan_days=plans::where('id',$amc_service->plan)->first();
        $product=customer_products::where('unique_job_number',$amc_service->unique_job_number)->where('is_deleted',0)->first();
        $normal_service=Services::where('unique_job_number',$amc_service->unique_job_number)->where('customer_id',$amc_service->customer_id)->where('status','Assigned')->orderBy('id','DESC')->where('is_deleted',0)->first();

        if(!empty($product->warranty_end_date))
        {
            $service_final=strtotime($product->warranty_end_date) * 1000;
        }
        else{
            $service_final=strtotime('d-m-Y')*1000;
        }
        $today_date=strtotime('d-m-Y')*1000;
        if(!empty($product))
        {
            $quotesDatas=GenerateQuoteDetails::where('customer_id',$request->customer_id)->where('unique_job_number',$amc_service->unique_job_number)->where('amc_status','active')->where('status','Paid')->where('is_deleted',0)->first();
            if(!empty($quotesDatas))
            {
                $product=customer_products::where('unique_job_number',$amc_service->unique_job_number)->where('is_deleted',0)->first();
                $serviceLength=$amc_service->service;
                $days=($plan_days->duration*30)/$serviceLength;

                for($i=1; $i <=$serviceLength; $i++)
                {

                    $service_date=date('d-m-Y', strtotime($product->warranty_end_date . ' +'.$i*$days.' day'));
                    $warrantyStartDate = $quotesDatas->end_date;
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
            else
            {
                $service_final=strtotime($product->warranty_end_date) * 1000;
                if($service_final > $today_date)
                {
                    $product=customer_products::where('unique_job_number',$amc_service->unique_job_number)->where('is_deleted',0)->first();
                    $serviceLength=$amc_service->service;
                    $days=($plan_days->duration*30)/$serviceLength;

                    for($i=1; $i <=$serviceLength; $i++)
                    {

                        $service_date=date('d-m-Y', strtotime($product->warranty_end_date . ' +'.$i*$days.' day'));
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
                else{
                    $product=customer_products::where('unique_job_number',$amc_service->unique_job_number)->where('is_deleted',0)->first();
                    $serviceLength=$amc_service->service;
                    $days=($plan_days->duration*30)/$serviceLength;

                    for($i=1; $i <=$serviceLength; $i++)
                    {
                        $service_date=date('d-m-Y', strtotime(date('d-m-Y') . ' +'.$i*$days.' day'));
                        $warrantyStartDate = $service_date;
                        $assigned_date = $warrantyStartDate;
                        $month = date('m',strtotime($assigned_date));
                        $start_date = date('01-m-Y',strtotime($assigned_date));
                        $end_day = date('t',strtotime($assigned_date));
                        $zone = $product->zone;
                        $current_date = $start_date;
                        $current_day=1;
                        $team_id = team::where('id',$zone)->first();
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
            }
        }
        else{
            $product=customer_products::where('unique_job_number',$amc_service->unique_job_number)->where('is_deleted',0)->first();
            $serviceLength=$amc_service->service;
            $days=($plan_days->duration*30)/$serviceLength;
            for($i=1; $i <=$serviceLength; $i++)
            {
                $today_date=date('d-m-Y');
                $service_date=date('d-m-Y', strtotime(date('d-m-Y') . ' +'.$i*$days.' day'));
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

        if(!empty($transaction)){
            $quotesDatas=GenerateQuoteDetails::where('customer_id',$request->customer_id)->where('unique_job_number',$amc_service->unique_job_number)->where('amc_status','active')->where('status','Paid')->where('is_deleted',0)->get();
            if(count($quotesDatas) < 1)
            {
                $normal_service=Services::where('unique_job_number',$amc_service->unique_job_number)->where('customer_id',$amc_service->customer_id)->where('status','Assigned')->orderBy('id','DESC')->where('is_deleted',0)->first();
                if($service_final > $today_date) {

                    $start_date=date('d-m-Y', strtotime($product->warranty_end_date .'+1 day'));
                    $end_date=date('d-m-Y', strtotime($product->warranty_end_date . '+'.$plan_days->duration*30 .' '.'day'));
                }
                else{

                    $start_date=date('d-m-Y');
                    $end_date=date('d-m-Y', strtotime('+'.$plan_days->duration*30 .' '.'day'));
                }
            }
            else{
                $quotesDatas=GenerateQuoteDetails::where('customer_id',$request->customer_id)->where('unique_job_number',$amc_service->unique_job_number)->where('amc_status','active')->where('status','Paid')->where('is_deleted',0)->first();
                $start_date=date('d-m-Y', strtotime($quotesDatas->start_date .'+1 day'));
                $end_date=date('d-m-Y', strtotime($quotesDatas->end_date . '+'.$plan_days->duration*30 .' '.'day'));
            }
            $data1['payment_type']='online';
            $data1['payment_id']=$transaction->id;
            $data1['payment_type']=$transaction->payment_mode;
            $data1['payment_date']=date('d-m-Y');
            $data1['start_date']=$start_date;
            $data1['end_date']=$end_date;
            $data1['status']='Paid';
            $data1['amc_status']='active';
            $data1['final_amount']=$transaction->amount;
            GenerateQuoteDetails::whereId($partRequest_id)->update($data1);
            $data1['success'] = true;//for success true
            $data1['code'] = 200;//for success code 200
            $data1['message'] = 'Payment done successfully';//for success message
            return $data1;

        }
        else{
            $data1['error'] = false;//for success true
            $data1['code'] = 500;//for success code 200
            $data1['message'] = 'No plans Avaialable';//for success message
        }

        return $data1;
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

    public function plandetails(Request $request){
        $partRequest_id = $request->Quotes_id;
        $quotes=GenerateQuoteDetails::where('customer_id',$request->customer_id)->where('unique_job_number',$request->unique_job_number)->where('amc_status','active')->where('is_deleted',0)->get();
        if(!empty($quotes))
        {
            foreach ($quotes as $quote)
            {
                $plan_details=plans::where('id',$quote->plan)->first();
                if(!empty($plan_details))
                {
                    $quote['title']=$plan_details->title;
                    $quote['description']=$plan_details->description;
                    $quote['duration']=$plan_details->duration;
                }
                else
                {
                    $quote['title']='';
                    $quote['description']='';
                    $quote['duration']='';
                }
            }
            $data['data'] = $quotes;//for success true
            $data['success'] = true;//for success true
            $data['code'] = 200;//for success code 200
            $data['message'] = 'Payment done successfully';//for success message
        }
        else{
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'No plans Avaialable';//for success message
        }
        return $data;
    }

}
