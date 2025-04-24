<?php

namespace App\Imports;

use App\Models\customer_products;
use App\Models\products_model;
use App\Models\customers;
use App\Models\team;
use App\Models\Services;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportProducts implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    protected $ccc = 0;
    public function model(array $row)
    {
        if($this->ccc < 2 && $row['0'] != 'Organization'){
            $mobileNumber = $row[3];
            $customer = customers::where('contact_number',$mobileNumber)->first();
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
            else{
                echo 'customer not exists';
            }
        }
        else{
            echo 'expired';
            exit;
        }
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
