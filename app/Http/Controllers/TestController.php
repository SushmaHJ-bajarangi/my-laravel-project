<?php

namespace App\Http\Controllers;

use App\DataTables\ZoneDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateZoneRequest;
use App\Http\Requests\UpdateZoneRequest;
use App\Repositories\ZoneRepository;
use App\Http\Controllers\AppBaseController;
use Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Response;
use App\Models\Zone;
use App\Models\activity;
use App\Imports\ImportProducts;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\customer_products;
use App\Models\products_model;
use App\Models\customers;
use App\User;
use App\Models\team;
use App\Models\Services;
use App\Models\StageOfMaterial;
use App\Models\DispatchStatus;
use App\Models\Priority;
use App\Models\ManufactureStatus;
use App\Models\ManufactureStage;
use App\Models\Production;
use App\Models\ProductionSom;
use App\Models\ProductionMnfStage;
class TestController extends AppBaseController
{

    public function dummyForm(){
        $today = \Carbon\Carbon::today()->format('d-m-Y');
//        $products = customer_products::whereRaw("STR_TO_DATE(amc_end_date, '%d-%m-%Y') < STR_TO_DATE(?, '%d-%m-%Y')", [$today])
//            ->where('status', '=', 'Under Amc')->where('amc_status', '=', 'Under Amc')->update([
//                'status' => 'Amc Expire',
//                'amc_status' => 'Amc Expire',
//            ]);

//        foreach ($products as $item){
//            customer_products::where('id', $item->id)->update([
//                'status' => 'Amc Expire',
//                'amc_status' => 'Amc Expire',
//            ]);
//        }

        // return 'done';
        // return $products;
        $customer = customers::where('is_deleted', 0)->get();
        $stage_of_material = StageOfMaterial::where('is_deleted', 0)->get();
        $dispatch_status = DispatchStatus::where('is_deleted', 0)->get();
        $priority = Priority::where('is_deleted', 0)->get();
        $manufacture_status = ManufactureStatus::where('is_deleted', 0)->get();
        $manufacture_stages = ManufactureStage::where('is_deleted', 0)->get();
        return view('excel_form', compact('customer', 'stage_of_material','dispatch_status','priority','manufacture_status','manufacture_stages'));
    }
    public function manufacture_and_production(Request $request){
        $production = new Production;
        $production->manager = $request->crm;
        $production->mnf_payment_date = $request->payment_received;
        $production->crm_confirmation_date = $request->crm_confirmation_date;
        $production->job_no = $request->jobs;
        $production->customer_id = $request->customer_name;
        $production->contract_value = $request->contract_value;
        $production->priority = $request->priority;
        $production->mnf_confirmation_date = $request->manufacturing_confirmation_date;
        $production->original_planned_dispatch_date = $request->original_planned_dispatch_date;
        $production->revised_planned_dispatch_date = $request->revised_planned_dispatch_date;
        $production->dispatch_payment_status = $request->dispatch_payment_status;
        $production->pending_dispatch_amount_inr = $request->amount_pending_for_dispatch;
        $production->manufacturing_status = $request->manufacturing_status_1;
        $production->dispatch_status = $request->dispatch_status;
        $production->dispatch_stage_lot = $request->dispatch_stage_lot;
        $production->comments = $request->comments;
        $production->factory_commitment_date = $request->factory_commitment_date;
        $production->revised_date_reason = $request->reason_for_revised_date;
        $production->revised_planed_dispatch = $request->revised_planed_dispatch_date;
        $production->dispatch_date_reason_factory = $request->reason_dispatch_date_factory;
        $production->revised_commitment_date_factory = $request->revised_commitment_date_factory;
        $production->material_readiness = $request->material_readiness;
        $production->completion_status = $request->status_of_completion;
        $production->no_of_days = $request->no_of_days;
        $production->dispatch_date = $request->dispatch_date;
        $production->specification = $request->specification;
        $production->issue = $request->issue;
        $production->address = $request->address_details;
        $production->save();

        if (isset($request->stage_of_material) && count($request->stage_of_material) > 0){
            foreach ($request->stage_of_material as $key => $item){
                $data = [
                    'prod_id' => $production->id,
                    'som_id' => $item,
                    'note' => $request->stage_of_material_note[$key] ?? null,
                ];
                ProductionSom::create($data);
            }
        }

        if (isset($request->manufacturing_by) && count($request->manufacturing_by) > 0){
            foreach ($request->manufacturing_by as $key => $item){
                $data = [
                    'prod_id' => $production->id,
                    'ms_id' => $request->manufacturing_stage[$key],
                    'status' => $request->manufacturing_status[$key],
                    'production_date' => $request->production_date[$key],
                    'readiness_date' => $request->readiness_date[$key],
                    'mf_by' => $request->manufacturing_by[$key],
                ];
                ProductionMnfStage::create($data);
            }
        }
        Flash::success('Success');
        return redirect(url('dummy_form'));

    }
    public function test()
    {
        //$2y$10$vn1SJ1iM4RDj6jVCdWiSSuyZO/xOxw.jrxqiFl.JWShhqmfDMB24y
        //$2y$10$10qRZiWPiwXWRKjcg9f4YuTFMc91zXyMO8zIpQgGe59uKdZcQ9Du.
        //User::whereId(1)->update(['password'=>bcrypt('12345678')]);
        //return 'wrwe';
        return view('import_excel');
    }
    public function import(Request $request)
    {
        $request->validate([
            'import_file' => 'required'
        ]);
        $rows= Excel::toArray([],  request()->file('import_file'));
//        echo '<pre>';print_r($rows);exit;
        foreach ($rows[0] as $k => $row){
            echo $k.'<br>';
            if($k > 0){
                echo '------------<br>';
                if(!customer_products::where('unique_job_number',$row[6])->exists()){
                    $mobileNumber = $row[3];
                    $customer = customers::where('contact_number',$mobileNumber)->first();
                    if(empty($customer) && !empty($mobileNumber)){
                        $customer = customers::create([
                           'name'=>$row[1],
                           'email'=>'test@gmail.com',
                           'contact_number'=>$mobileNumber,
                           'address'=>$row[2],
                        ]);
                    }
                    if(!empty($customer)){
                        $input = [];
                        if(!empty($row[9])){
                            $start_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[9])->format('d-m-Y');
                        }
                        else{
                            $start_date = date('d-m-Y');
                        }
                        if(!empty($row[10])){
                            $end_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[10])->format('d-m-Y');
                        }
                        else{
                            $end_date = date('d-m-Y');
                        }

                        $input['customer_id']=$customer->id;
                        $model = products_model::where('title',$row[5])->first();
                        if(empty($model)){
                            $model = products_model::create(['title'=>$row[5]]);
                        }
                        $input['model_id']=$model->id;
                        $input['number_of_floors']=5;
                        $input['passenger_capacity']=5;
                        $input['distance']=100;
                        $input['unique_job_number']=$row[6];

                        $input['warranty_start_date']=$start_date;
                        $input['warranty_end_date']=$end_date;
                        $input['ordered_date']=$start_date;
                        if(strtotime($end_date) > strtotime(date('Y-m-d'))){
                            $input['status']='Under Warranty';
                            $input['side_status']=2;
                        }
                        else{
                            $input['status']='expired';
                            $input['side_status']=1;
                        }

                        $input['no_of_services']=6;

                        $input['address']=$row[2];
                        $input['project_name']=$row[1];

                        $team = team::where('title',$row[4])->first();
                        if(!empty($team)){
                            $input['zone']=$team->zone;
                        }
                        else{
                            $titleArray = explode(' ',$row[4]);
                            $title = '';
                            foreach ($titleArray as $t){
                                $title .= $t[0];
                            }
                            $team = team::where('title',$title)->first();
                            if(!empty($team)){
                                $input['zone']=$team->zone;
                            }
                            else{
                                $input['zone']=1;
                            }
                        }

                        $customerProducts = customer_products::create($input);

                        if ($start_date && $end_date) {
                            $date1 = date('d-m-Y',strtotime($start_date));
                            $date2 = date('d-m-Y',strtotime($end_date));
                            $input['warranty_start_date']=$date1;
                            $input['warranty_end_date']=$date2;
                            $input['status'] = 'Under Warranty';

                            $ts1 = strtotime($date1);
                            $ts2 = strtotime($date2);
                            $year1 = date('Y', $ts1);
                            $year2 = date('Y', $ts2);
                            $month1 = date('m', $ts1);
                            $month2 = date('m', $ts2);
                            $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
                            // calculate number of months

                            $getServicesNumber = $diff / 6;
                            $getServicesNumber = round($getServicesNumber);

                            $warrantyStartDate = $date1;
                            for ($i=0; $i< 6; $i++) {
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
                                if(strtotime($end_date) > strtotime(date('Y-m-d'))){
                                    $services['status']='Assigned';
                                }
                                else{
                                    $services['status']='Completed';
                                }
                                $services['technician_id'] = '';
                                $services['assign_team_id'] = $team_id->id;
                                $services['zone'] = $customerProducts->zone;
                                $service['passenger_capacity']=$customerProducts->passenger_capacity;
                                Services::create($services);
                            }
                        }
                    }

                }
                else{
                    echo 'job already exists '.$row[6].'.<br><br>';
                }
            }
        }
        echo 'done';exit;
//        Excel::import(new ImportProducts, request()->file('import_file'));
        return back()->with('success', 'Contacts imported successfully.');
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
