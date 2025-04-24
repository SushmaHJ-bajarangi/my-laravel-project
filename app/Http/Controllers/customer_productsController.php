<?php

namespace App\Http\Controllers;

use App\DataTables\customer_productsDataTable;
use App\Http\Requests;
use App\Http\Requests\Createcustomer_productsRequest;
use App\Http\Requests\Updatecustomer_productsRequest;
use App\Models\customer_products;
use App\Models\customers;
use App\Models\AuthorizedPerson;
use App\Models\No_of_floors;
use App\Models\passengerCapacity;
use App\Models\products_model;
use App\Models\Services;
use App\Models\activity;
use App\Models\team;
use App\Models\BackupTeam;
use App\Models\Zone;
use App\Models\ProductStatus;
use App\Models\plans;
use App\Models\Transactions;
use App\Models\PartsRequest;
use App\Models\GenerateQuote;
use App\Models\GenerateQuoteDetails;
use App\Repositories\customer_productsRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\OfferCustomer;

class customer_productsController extends AppBaseController
{
    /** @var  customer_productsRepository */
    private $customerProductsRepository;

    public function __construct(customer_productsRepository $customerProductsRepo)
    {
        $this->middleware('auth');
        $this->customerProductsRepository = $customerProductsRepo;
    }

    public function index(customer_productsDataTable $customerProductsDataTable)
    {
        return $customerProductsDataTable->render('customer_products.index');
    }

    public function create()
    {
        $plans =plans::where('is_deleted',0)->get();
        $customer_zones = Zone::where('is_deleted',0)->get();
        $customers = customers::where('is_deleted', 0)->get();
        $models = products_model::where('is_deleted', 0)->get();
        $no_floors = No_of_floors::where('is_deleted', 0)->get();
        $product_status = ProductStatus::where('is_deleted',0)->get();
        $passenger_capacity = passengerCapacity::where('is_deleted', 0)->get();
        return view('customer_products.create', compact('customers', 'models','no_floors','passenger_capacity','product_status','plans','customer_zones'));
    }

    public function store(Request $request)
    {
        $input = $request->all();

        if($request->has('amc_value')){
           $amc_value ='yes';
            $input['amc_value'] = 1;
        }
        else{
            $amc_value ='no';
            $input['amc_value'] = 0;
        }

        $input['ordered_date'] = date('d-m-Y');
        if($amc_value == 'yes')
        {
            $today=date('d-m-Y');

            $input['warranty_start_date']= date('d-m-Y');
            $input['warranty_end_date']= date('d-m-Y', strtotime('+1 year'));
            $input['status'] = 'expired';
            $input['no_of_services'] = 0;
            $input['model_id'] = $request->model_id;

//            $input['area'] = $request->area;
//            $input['noofstops'] = $request->noofstops;

            $dataQuote['start_date']=date('d-m-Y');
            $dataQuote['end_date']=date('d-m-Y', strtotime('+1 year'));
            $dataQuote['service']= 6;
            $userDetail['amc_start_date'] = date('d-m-Y');
            $userDetail['amc_end_date'] = date('d-m-Y', strtotime('+one year'));
            $userDetail['amc_status'] = 'Under Amc';
            $userDetail['status'] = 'Under Amc';
        }
        else{
            if ($request->warranty_start_date && $request->warranty_end_date) {
                $input['warranty_start_date']=date('d-m-Y',strtotime($request->warranty_start_date));
                $input['warranty_end_date']=date('d-m-Y',strtotime($request->warranty_end_date));

                $input['status'] = 'Under Warranty';
                $input['no_of_services'] = $request->no_of_services;

//                $input['area'] = $request->area;
//                $input['noofstops'] = $request->noofstops;

                $dataQuote['start_date']=$request->warranty_start_date;
                $dataQuote['end_date']=$request->warranty_end_date;
                $dataQuote['service']=$request->no_of_services;
                $userDetail['amc_start_date'] = $request->warranty_start_date;
                $userDetail['amc_end_date'] = $request->warranty_end_date;
                if($request->warranty_end_date >= date('d-m-Y')){
                    $userDetail['amc_status'] = 'Under Amc';
                    $userDetail['status'] = 'Under Amc';
                }else{
                    $userDetail['amc_status'] = 'Amc Expired';
                    $userDetail['status'] = 'Amc Expired';
                }
            } else {
                $input['status'] = 'Under Installation';
                $input['no_of_services'] = '0';
                $today=date('d-m-Y');
                $dataQuote['start_date']=date('d-m-Y');
                $dataQuote['end_date']=date('d-m-Y', strtotime('+1 year'));

                $dataQuote['service']= 6;

                $userDetail['amc_start_date'] = date('d-m-Y');
                $userDetail['amc_end_date'] = date('d-m-Y', strtotime('+1 year'));
                $userDetail['amc_status'] = 'Under Amc';
                $userDetail['status'] = 'Under Amc';
            }
        }

        $customerProducts = $this->customerProductsRepository->create($input);

        $product = customer_products::where('unique_job_number',$customerProducts->unique_job_number)->first();

        $customer=customers::where('id',$product->customer_id)->first();
        $data['customer_id']=$product->customer_id;
        $data['customer_job_id']=$product->unique_job_number;
        $data['status']='Completed';
        $getId =GenerateQuote::create($data);
        $dataQuote['quote_id']=$getId->id;
        $dataQuote['plan'] = $request->plan;
        $dataQuote['price'] = 0;
        $dataQuote['payment_type']='cheque';
        $dataQuote['status']='Paid';
        $dataQuote['customer_id']=$product->customer_id;
        $dataQuote['payment_date']=date('d-m-Y');
        $dataQuote['payment_id']=$product->customer_id.'_'.rand(10000,999999);
        $dataQuote['unique_job_number']=$product->unique_job_number;
        $dataQuote['amc_status']='active';

        GenerateQuoteDetails::create($dataQuote);
        $input['customer_id']=$product->customer_id;
        $input['payment_mode']='Cheque';
        $input['order_id']=$product->customer_id.'_'.rand(10000,999999);
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

        customer_products::where('unique_job_number',$customerProducts->unique_job_number)->update($userDetail);


        if (!empty($request['authorized_name'])) {
            for ($i = 0; $i < count($request['authorized_name']); $i++) {
                if ($request['authorized_name'][$i] != '') {
                    $persons = [];
                    $persons['customer_id'] = $customerProducts->customer_id;
                    $persons['name'] = $request['authorized_name'][$i];
                    $persons['contact_number'] = $request['authorized_contact_number'][$i];
                    $persons['unique_job_number'] = $customerProducts->unique_job_number;
                    AuthorizedPerson::create($persons);
                }
            }
        }

        if($amc_value != 'yes')
        {
            if ($request->warranty_start_date && $request->warranty_end_date) {

                $input['warranty_start_date']=date('d-m-Y',strtotime($request->warranty_start_date));
                $input['warranty_end_date']=date('d-m-Y',strtotime($request->warranty_end_date));
                $input['status'] = 'Under Warranty';
                $input['no_of_services'] = $request->no_of_services;
                $date1 = date('d-m-Y',strtotime($request->warranty_start_date));
                $date2 = date('d-m-Y',strtotime($request->warranty_end_date));
                $ts1 = strtotime($date1);
                $ts2 = strtotime($date2);
                $year1 = date('Y', $ts1);
                $year2 = date('Y', $ts2);
                $month1 = date('m', $ts1);
                $month2 = date('m', $ts2);
                $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
                // calculate number of months

                if($request->no_of_services != 0)
                {
                    $getServicesNumber = $diff / $request->no_of_services;
                    $getServicesNumber = round($getServicesNumber);
                    $input['status'] = 'Under Warranty';
                }
                else{
                    $getServicesNumber=0;
                    $input['status'] = 'expired';
                }

                $warrantyStartDate = $date1;
                $warrantyEndDate = $date2;
                for ($i=0; $i< $request->no_of_services; $i++) {
                    $warrantyStartDate = date('d-m-Y', strtotime("+$getServicesNumber months", strtotime($warrantyStartDate)));
                    $assigned_date = $warrantyStartDate;
                    $month = date('m',strtotime($assigned_date));
                    $start_date = date('01-m-Y',strtotime($assigned_date));
                    $end_day = date('t',strtotime($assigned_date));
                    $no_of_services = 0;
                    $zone = $customerProducts->zone;
                    $current_date = $start_date;
                    $current_day=1;
                    $team_id = team::where('zone',$zone)->first();
                    $final_date = $this->assignService($assigned_date,$month,$start_date,$end_day,$zone,$no_of_services,$current_date,$team_id->id,$current_day);
                    $services = [];
                    $services['customer_id'] = $customerProducts->customer_id;
                    $services['unique_job_number'] = $customerProducts->unique_job_number;
                    $services['customer_product_id'] = $customerProducts->id;
                    $services['date'] = $final_date;
                    $services['status'] = 'Assigned';
                    $services['technician_id'] = '';
                    $services['assign_team_id'] = $team_id->id;
                    $services['zone'] = $customerProducts->zone;
                    $service['passenger_capacity']=$customerProducts->passenger_capacity;
                    Services::create($services);
                }
            }
        }

        $entry['t_name'] = "CustomerProjects";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Inserted";
        activity::create($entry);
        $notification = array(
            'message' => 'Customer Project saved successfully',
            'alert-type' => 'success'
        );
        return redirect(route('customerProducts.index'))->with($notification);
    }

    public function show($id)
    {
        $customerProducts = $this->customerProductsRepository->find($id);

        if (empty($customerProducts)) {
            $notification = array(
                'message' => 'Customer Project not found',
                'alert-type' => 'error'
            );
            return redirect(route('customerProducts.index'))->with($notification);
        }
        return view('customer_products.show')->with('customerProducts', $customerProducts);
    }

    public function edit($id)
    {
        $plans = plans::where('is_deleted',0)->get();
        $customerProducts = $this->customerProductsRepository->find($id);

        $GenerateQuoteDetails = GenerateQuoteDetails::where('unique_job_number',$customerProducts->unique_job_number)->where('is_deleted', '0')->where('amc_status','active')->first();

        if (empty($customerProducts)) {

            $notification = array(
                'message' => 'Customer Projects not found',
                'alert-type' => 'error'
            );
            return redirect(route('customerProducts.index'))->with($notification);
        }
        $customer_zones = Zone::where('is_deleted',0)->get();
        $customers = customers::where('is_deleted', 0)->get();
        $models = products_model::where('is_deleted', 0)->get();
        $no_floors = No_of_floors::where('is_deleted', 0)->get();
        $passenger_capacity = passengerCapacity::where('is_deleted', 0)->get();
        $product_status = ProductStatus ::where('is_deleted',0)->get();
        $persons = AuthorizedPerson::where('customer_id', $customerProducts->customer_id)->where('unique_job_number','=',$customerProducts->unique_job_number)->where('is_deleted', '0')->get();
        return view('customer_products.edit', compact('customers', 'models', 'plans','persons','no_floors','passenger_capacity','product_status','customer_zones','GenerateQuoteDetails'))->with('customerProducts', $customerProducts);
    }

    public function update($id, Request $request)
    {
        $customerProducts = $this->customerProductsRepository->find($id);

        if (empty($customerProducts)) {

            $notification = array(
                'message' => 'Customer Project not found',
                'alert-type' => 'error'
            );
            return redirect(route('customerProducts.index'))->with($notification);
        }

        $input = $request->all();

        if(empty($customerProducts->no_of_services))
        {
            if ($request->warranty_start_date && $request->warranty_end_date) {
                $input['warranty_start_date']=date('d-m-Y',strtotime($request->warranty_start_date));
                $input['warranty_end_date']=date('d-m-Y',strtotime($request->warranty_end_date));
                $input['no_of_services'] = $request->no_of_services;
                $date1 = date('d-m-Y',strtotime($request->warranty_start_date));
                $date2 = date('d-m-Y',strtotime($request->warranty_end_date));
                $ts1 = strtotime($date1);
                $ts2 = strtotime($date2);
                $year1 = date('Y', $ts1);
                $year2 = date('Y', $ts2);
                $month1 = date('m', $ts1);
                $month2 = date('m', $ts2);
                $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
                // calculate number of months

                if($request->no_of_services !=0)
                {
                    $getServicesNumber = $diff / $request->no_of_services;
                    $getServicesNumber = round($getServicesNumber);
                    $input['status'] = 'Under Warranty';
                }
                else{
                    $getServicesNumber=0;
                    $input['status'] = 'expired';
                }

                $warrantyStartDate = $date1;
                $warrantyEndDate = $date2;
                for ($i=0; $i< $request->no_of_services; $i++) {
                    $warrantyStartDate = date('d-m-Y', strtotime("+$getServicesNumber months", strtotime($warrantyStartDate)));
                    $assigned_date = $warrantyStartDate;
                    $month = date('m',strtotime($assigned_date));
                    $start_date = date('01-m-Y',strtotime($assigned_date));
                    $end_day = date('t',strtotime($assigned_date));
                    $no_of_services = 0;
                    $zone = $request->zone;
                    $current_date = $start_date;
                    $current_day=01;
                    $team_id = team::where('zone',$zone)->first();
                    $final_date = $this->assignService($assigned_date,$month,$start_date,$end_day,$zone,$no_of_services,$current_date,$team_id->id,$current_day);
                    $services = [];
                    $services['customer_id'] = $customerProducts->customer_id;
                    $services['unique_job_number'] = $customerProducts->unique_job_number;
                    $services['customer_product_id'] = $customerProducts->id;
                    $services['date'] = $final_date;
                    $services['status'] = 'Assigned';
                    $services['technician_id'] = '';
                    $services['assign_team_id'] = $team_id->id;
                    $services['zone'] = $customerProducts->zone;
                    $service['passenger_capacity']=$customerProducts->passenger_capacity;
                    Services::create($services);
                }
            }
        }

        $input['ordered_date'] = $customerProducts->ordered_date;
        if($customerProducts->zone != $request->zone)
        {
            $team=team::where('zone',$request->zone)->first();
            Services::where('unique_job_number', $customerProducts->unique_job_number)->where('status','Assigned')->update(['zone'=>$request->zone,'assign_team_id'=>$team->id,'customer_id'=>$request->customer_id]);
        }
        else{
            Services::where('unique_job_number', $customerProducts->unique_job_number)->update(['customer_id'=>$request->customer_id]);
        }
        $this->customerProductsRepository->update($input, $id);
        $customerProducts = $this->customerProductsRepository->find($id);

        Services::where('customer_product_id', $id)->update(['zone'=>$request->zone]);
        if (!empty($request['authorized_name'])) {
            for ($i = 0; $i < count($request['authorized_name']); $i++) {
                if ($request['authorized_name'][$i] != '') {
                    $helpers = [];
                    $helpers['customer_id'] = $customerProducts->customer_id;
                    $helpers['name'] = $request['authorized_name'][$i];
                    $helpers['contact_number'] = $request['authorized_contact_number'][$i];
                    $helpers['unique_job_number'] = $customerProducts->unique_job_number;
                    if (isset($request['authorized_id'][$i])) {
                        if (AuthorizedPerson::where('id', $request['authorized_id'][$i])->exists()) {
                            AuthorizedPerson::where('id', $request['authorized_id'][$i])->update($helpers);
                        } else {
                            AuthorizedPerson::create($helpers);
                        }
                    } else {
                        AuthorizedPerson::create($helpers);
                    }
                }
            }
        }

        $entry['t_name'] = "CustomerProjects";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Updated";
        activity::create($entry);
        $notification = array(
            'message' => 'Customer Project updated successfully',
            'alert-type' => 'success'
        );
        return redirect(route('customerProducts.index'))->with($notification);
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

    public function destroy($id)
    {
        $customerProducts = $this->customerProductsRepository->find($id);

        if (empty($customerProducts)) {
            Flash::error('Customer Project not found');
            $notification = array(
                'message' => 'Customer Project not found',
                'alert-type' => 'error'
            );
            return redirect(route('customerProducts.index'))->with($notification);
        }

//        $this->customerProductsRepository->delete($id);
          customer_products::where('id', $id)->update(['is_deleted'=>1]);

        $entry['t_name'] = "CustomerProjects";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Deleted";
        activity::create($entry);
        $notification = array(
            'message' => 'Customer Project deleted successfully',
            'alert-type' => 'success'
        );
        return redirect(route('customerProducts.index'))->with($notification);
    }

    public function checkCustomerJobNumber(Request $request)
    {
        $numbers = $request->customer_number;
        if (count($numbers) > 0) {
            foreach ($numbers as $itemNumber) {
                if (count(array_keys($numbers, $itemNumber)) > 1)
                {
                    $data['numbers'] = $numbers;
                    $data['response'] = 'customer_number_exists';
                    return $data;
                }
            }
        }
        if (customer_products::where('unique_job_number', $request->unique_job_number)->where('id', '!=', $request->customer_product_id)->where('is_deleted',0)->exists()) {
            return 'number_exists';
        } elseif (customers::whereIn('contact_number', $request->customer_number)->where('is_deleted',0)->exists()) {
            $customer_numbers = customers::whereIn('contact_number', $request->customer_number)->pluck('contact_number');
            $data['numbers'] = $customer_numbers;
            $data['response'] = 'customer_number_exists';
            return $data;
        } elseif (AuthorizedPerson::whereIn('contact_number', $request->customer_number)->where('unique_job_number', '!=', $request->unique_job_number)->where('is_deleted',0)->exists()) {
            $customer_numbers = AuthorizedPerson::whereIn('contact_number', $request->customer_number)->pluck('contact_number');
            $data['numbers'] = $customer_numbers;
            $data['response'] = 'customer_number_exists';
            return $data;
        } else {
            return 'number_not_exists';
        }
    }

    public function getdata_products(Request $request)
    {
        $product = customer_products::where('unique_job_number', 'like', '%' . $request->job_number . '%')->where('is_deleted',0)->get();
        $html = '';
        if (isset($product) && count($product) > 0) {
            foreach ($product as $p) {
                $customer_zones  = Zone::where('id',$p->zone)->where('is_deleted',0)->first();
                $productstatus  = ProductStatus ::where('id',$p->side_status)->where('is_deleted',0)->first();

                $html .= '<tr role="row">
                    <td>' . $p->unique_job_number . '</td>
                    <td>' . $p->getCustomer->name . '</td>
                    <td>' . $p->project_name . '</td>
                    <td>' . $p->warranty_start_date . '</td>
                    <td>' . $p->warranty_end_date . '</td>
                    <td>' . $p->status . '</td>
                    <td>' . $customer_zones->title . '</td>
                        <td><div id="myGroup">
                        <button class="btn dropdown btn-primary accordion-heading" data-toggle="collapse" id="toggle_icon" data-target="#address' . $p->id . '" data-parent="#myGroup">+</button>
                        <div class="accordion-group">
                            <div class="collapse indent"  id="address' . $p->id . '">
                            <div class="card accordion-body" id="cutomer_detail">
                            <div><lable  style="text-align:left;">No of Services </lable><span style="float:right;">' . $p->no_of_services . '</span></div>
                            <div class="number_of_floors"><lable  style="text-align:left;">No of Floors </lable> <span style="float:right;">' . $p->number_of_floors . '</span></div>
                            <div><lable  style="text-align:left;">passenger Capacity</lable><span style="float:right;">' . $p->passenger_capacity . '</span></div>
                            <div><lable  style="text-align:left;">Distance </lable><span style="float:right;">' . $p->distance . '</span></div>
                            <div><lable  style="text-align:left;">Lift Model </lable><span style="float:right;">' . $p->getModel->title . '</span></div>
                            <hr>
                            <div>' . $p->address . '</div>
                              </div>
                            </div>
                           </div>
                        </div></td>
                    <td>' . $p->ordered_date . '</td>
                    <td>' . $productstatus->title . '</td>
                    <td>
                        <div class="btn-group" style="display: block">
                            <a href="' . route('customerProducts.show', $p->id) . '" class="btn btn-default btn-xs">
                                <i class="glyphicon glyphicon-eye-open"></i>
                            </a>
                            <a href="' . route('customerProducts.edit', $p->id) . '" class="btn btn-default btn-xs">
                                <i class="glyphicon glyphicon-edit"></i>
                            </a>

                            <a><form method="delete" action="' . route('customerProducts.destroy', $p->id) . '">
                               <button type="submit" onclick="return confirm(\'Are you sure?\')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></button>
                            </form></a>
                        </div>
                    </td>
                </tr>';
            }
        } else {
            $html .= '<tr class="odd">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td valign="top" colspan="3" class="dataTables_empty">No data available in table</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>

                    </tr>';

        }
        echo $html;
    }

    public function customerProductsfilter(Request $request)
    {
        if($request->unique_job_number != '')
        {
            $customer_product=customer_products::Where('unique_job_number', 'like', '%' . $request->unique_job_number . '%')->get();
            return Datatables()->of($customer_product)
                ->make(true);
        }
        else{
            $customer_product=customer_products::select('unique_job_number','customer_id','project_name','warranty_start_date','warranty_end_date','status','zone','detail','ordered_date','side_status')->get();
            return Datatables()->of($customer_product)
                ->make(true);
        }
    }

    public function productshow()
    {
//       $service_product=Services::where('status','Assigned')->get();
//
//       foreach ($service_product as $service)
//       {
//           $customer_product=customer_products::Where('zone', 7)->first();
//           return $customer_product;
//           $team=BackupTeam::get();
//           return $team;
//
//           $services=Services::where('unique_job_number',$customer->unique_job_number)->get();
//           return $services;
//       }
    }

    public function vantage_advertising()
    {
        set_time_limit(300);
        $pdf = Pdf::loadView('customer_products.vantageadvertising');

        $pdf->setPaper('A4', 'portrait');
        $pdf->set_option('margin-top', 0);
        $pdf->set_option('margin-bottom', 0);
        $pdf->set_option('margin-left', 0);
        $pdf->set_option('margin-right', 0);

        return $pdf->stream('vantageadvertising.pdf');
    }

    public function mr_charanjiv_khattar()
    {
//      return view('customer_products.mrcharanjivkhattar');
        set_time_limit(300);
        $pdf =Pdf::loadView('customer_products.mrcharanjivkhattar');
        return $pdf->stream('mrcharanjivkhattar.pdf');
     }

    public function jayanthilal()
    {
//      return view('customer_products.jayanthilal_pdf');
        set_time_limit(300);
        $pdf = Pdf::loadview('customer_products.jayanthilal_pdf');
        return $pdf->stream('jayanthilal.pdf');
    }git

    public function jayasheela()
    {
        set_time_limit(300);
//      return view('customer_products.jayasheela_pdf');
        $pdf = Pdf::loadview('customer_products.jayasheela_pdf');
        return $pdf->stream('jayasheela.pdf');
    }

    public function storeOffer(Request $request, $id)
    {
        $validated = $request->validate([
            'offer_type' => 'required|string',
            'offer_date' => 'required|date',
            'offer_no'   => 'required|string',
            'site_name'  => 'nullable|string|max:50',
            'address'    => 'nullable|string|max:56',
        ]);

        OfferCustomer::create([
            'offer_type' => $validated['offer_type'],
            'offer_date' => $validated['offer_date'],
            'offer_no'   => $validated['offer_no'],
            'site_name'  => $validated['site_name'],
            'address'    => $validated['address'],
        ]);

        return redirect()->back()->with('success', 'Offer saved successfully!');
    }

}
