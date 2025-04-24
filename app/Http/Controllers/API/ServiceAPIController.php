<?php

namespace App\Http\Controllers\API;

use App\Models\customer_products;
use App\Models\plans;
use App\Models\customers;
use App\Models\Services;
use App\Models\SubscriptionHistory;
use App\Models\PaymentHistory;
use App\Models\team;
use App\Models\ServicesList;
use App\Models\servicenote;
use App\Models\Announcement;
use App\Models\Technician_Assist;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use Illuminate\Support\Facades\Mail;
use Image;
use App\Models\app_version;


/**
 * Class customerController
 * @package App\Http\Controllers\API
 */

class ServiceAPIController extends AppBaseController
{
    public function techiniciantodayservice(Request $request)
    {
        $date=date('d-m-Y');
        $service_today=Services::where('assign_team_id',$request->technician_user_id)->where('date',$date)->where('status','=','Assigned')->where('is_deleted',0)->get();

        if(count($service_today) > 0)
        {
            foreach ($service_today as $item)
            {
                $customer_details=customers::where('id',$item->customer_id)->where('is_deleted',0)->first();
                $item['customer_name']=$customer_details->name;
                $item['contact_number']=$customer_details->contact_number;
                $item['address']=$customer_details->address;
            }
            $data['data'] = $service_today;//for success true
            $data['success'] = true;//for success true
            $data['code'] = 200;//for success code 200
            $data['message'] = 'Payment done successfully';//for success message
        }
        else
        {
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'No service Avaialable for today';//for success message
        }
        return $data;
    }
    public function upcomingservice(Request $request)
    {
        $service_today=Services::where('assign_team_id',$request->technician_user_id)->where('status','Assigned')->orderBy('date','asc')->where('is_deleted',0)->get();
        if(count($service_today) > 0)
        {
            $item_data = [];
            foreach ($service_today as $item)
            {
                $date=date('d-m-Y');
                $today_date=1000*strtotime($date);
                $service_date=1000*strtotime($item->date);

                if($today_date < $service_date)
                {
                    $today_month=date('m');
                    $today_year=date('Y');
                    $service_month=date('m', strtotime($item->date));
                    $service_year=date('Y', strtotime($item->date));
                    if($today_month == $service_month && $service_year==$today_year)
                    {
                        $customer_details=customers::where('id',$item->customer_id)->where('is_deleted',0)->first();
                        $item['customer_name']=$customer_details->name;
                        $item['contact_number']=$customer_details->contact_number;
                        $item['address']=$customer_details->address;
                        $item['lets_service']='lets_service';
                        $item_data[]=$item;

                    }

                }

            }
            $data['data'] = $item_data;//for success true
            $data['success'] = true;//for success true
            $data['code'] = 200;//for success code 200
            $data['message'] = 'Payment done successfully';//for success message
        }
        else
        {
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'No service Avaialable for Upcoming';//for success message
        }
        return $data;
    }
    public function remainingservice(Request $request)
    {
        $service_today=Services::where('assign_team_id',$request->technician_user_id)->where('status','Assigned')->orderBy('date','asc')->where('is_deleted',0)->get();

        if(count($service_today) > 0)
        {
            foreach ($service_today as $item)
            {
                $date=date('d-m-Y');
                $today_date=1000*strtotime($date);
                $service_date=1000*strtotime($item->date);

                if($today_date > $service_date)
                {
                    $customer_details=customers::where('id',$item->customer_id)->where('is_deleted',0)->first();
                    $item['customer_name']=$customer_details->name;
                    $item['contact_number']=$customer_details->contact_number;
                    $item['address']=$customer_details->address;
                    $item['lets_service']='lets_service';
                    $itemData[]=$item;
                }

            }
            $data['data'] = $itemData;//for success true
            $data['success'] = true;//for success true
            $data['code'] = 200;//for success code 200
            $data['message'] = 'Payment done successfully';//for success message
        }
        else
        {
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'No service Avaialable for Upcoming';//for success message
        }
        return $data;
    }
    public function serviceclose(Request $request)
    {
        $service_data=Services::where('id',$request->service_id)->where('assign_team_id',$request->technician_user_id)->where('status','Assigned')->where('is_deleted',0)->first();
        if(!empty($service_data))
        {
            $this->validate($request, [
                'signature' => 'required|image|mimes:jpeg,png,jpg,bmp,gif,svg',
            ]);
            $signatureimage='';
            if ($request->hasFile('signature')) {
                $image = $request->file('signature');
                $signatureimage = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/signature/');
                $image->move($destinationPath, $signatureimage);
            }
            $date =date('d-m-Y');
            $team=team::where('id',$request->technician_user_id)->first();
            Services::where('id',$request->service_id)->where('assign_team_id',$request->technician_user_id)->where('status','Assigned')
                ->update([
                    'status'=>'Completed',
                    'authname'=>$request->authname,
                    'auth_number'=>$request->auth_number,
                    'service_list'=>$request->service_list,
                    'signature_image'=>$signatureimage,
                    'tech_name'=>$team->name,
                    'complete_service'=>$date,
                ]);
            if(!empty($request->customer_note))
            {
                $input['service_id']=$request->service_id;
                $input['description']=$request->customer_note;
                servicenote::create($input);
            }


            $data['success'] = true;//for success true
            $data['code'] = 200;//for success code 200
            $data['message'] = 'Service close successfully';//for success message
        }
        else
        {
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'No service Avaialable this technician';//for success message
        }
        return $data;
    }
    public function getServices(Request $request){
        $customer_id = $request->customer_id;
        $customer_job_number = $request->unique_job_number;
        $service_data=Services::where('customer_id',$customer_id)->where('unique_job_number',$customer_job_number)->where('is_deleted',0)->get();

        if(count($service_data) >0){
            $services = Services::where('customer_id',$customer_id)->where('unique_job_number',$customer_job_number)->where('status','!=','Completed')->where('is_deleted',0)->get();
            $customer_name = customers::where('id',$customer_id)->where('is_deleted',0)->first();
            foreach($services as $service){
                $team = team::where('id',$service->assign_team_id)->where('is_deleted',0)->first();
                if(isset($team)){
                    $service['technician_name'] = $team->name;
                }
                else{
                    $service['technician_name'] = 'Not assigned';
                }
                $service['customer_name'] = $customer_name->name;
            }
            $data['data'] = $services;
            $data['error'] = true;
            $data['code'] = 200;
            $data['message'] = 'Services Found';//for error message

        }
        else{
            $data['data'] = 'No Data';
            $data['error'] = false;
            $data['code'] = 500;
            $data['message'] = 'Services Not Found';//for error message
        }
        return $data;
    }
    public function servicehistory(Request $request){
        $customer_id = $request->customer_id;
        $customer_job_number = $request->unique_job_number;
        $services = Services::where('customer_id',$customer_id)->where('status','Completed')->where('is_deleted',0)->orderBy('date','desc')->limit(10)->get();
        if(count($services) > 0){
            $customer_name = customers::where('id',$customer_id)->where('is_deleted',0)->first();
            foreach($services as $service){
                if($service->image !='')
                {
                    $service['image']=asset('services/'.$service->image);
                }
                else{
                    $service['image']=asset('images/no_img.png');
                }

                $team = team::where('id',$service->assign_team_id)->where('is_deleted',0)->first();
                if(isset($team)){
                    $service['technician_name'] = $team->name;
                }
                else{
                    $service['technician_name'] = 'Not assigned';
                }
                $service['customer_name'] = $customer_name->name;
            }
            $data['data'] = $services;
            $data['error'] = true;
            $data['code'] = 200;
            $data['message'] = 'Services Found';//for error message

        }
        else{
            $data['data'] = 'No Data';
            $data['error'] = false;
            $data['code'] = 500;
            $data['message'] = 'Services Not Found';//for error message
        }
        return $data;
    }
    public function technicianservicehistory(Request $request){
        $technician_id = $request->technician_user_id;
        $services = Services::where('assign_team_id',$technician_id)->where('status','Completed')->limit(10)->where('is_deleted',0)->get();
        if(count($services) > 0){
            $team = team::where('id',$technician_id)->where('is_deleted',0)->first();
            foreach($services as $service){
                if($service->image !='')
                {
                    $service['image']=asset('services/'.$service->image);
                }
                else{
                    $service['image']=asset('images/no_img.png');
                }

                $customer = customers::where('id',$service->customer_id)->where('is_deleted',0)->first();
                if(isset($team)){
                    $service['technician_name'] = $team->name;
                }
                $service['customer_name'] = $customer->name;
            }
            $data['data'] = $services;
            $data['error'] = true;
            $data['code'] = 200;
            $data['message'] = 'Services Found';//for error message

        }
        else{
            $data['data'] = 'No Data';
            $data['error'] = false;
            $data['code'] = 500;
            $data['message'] = 'Services Not Found';//for error message
        }
        return $data;
    }
    public function servicesignatureSubmit(Request $request){
        if (!empty($request->image) && !empty($request->imageName)) {
            ini_set('max_input_time', -1);
            ini_set('max_execution_time', 0);
            $image = $request->image;
            $imageName = '/services/' .$request->imageName;
            $realImage = base64_decode($image);
            $data['image'] = $request->imageName;
            $path = public_path() . $imageName;
            file_put_contents($path, $realImage);
            if ($data['image'] != '') {
                try {
                    $imageFile = Image::make($path);
                    $w = $imageFile->width();
                    $h = $imageFile->height();
                    $width = 520;
                    $height = 520;
                    $quantity = 90;
                    if ($w > $width && $h > $height) {
                        $canvas = Image::canvas($width, $height);
                        $image = $imageFile->resize($width, $height, function ($constraint) {
                            $constraint->aspectRatio();
                        });

                        $canvas->insert($image, 'center');
                        $canvas->encode('jpg', $quantity);
                        $canvas->save($path, $quantity);
                    } elseif ($w > $width && $h < $height) {
                        $canvas = Image::canvas($width, $h);
                        $image = $imageFile->resize($width, $height, function ($constraint) {
                            $constraint->aspectRatio();
                        });

                        $canvas->insert($image, 'center');
                        $canvas->encode('jpg', $quantity);
                        $canvas->save($path, $quantity);
                    } elseif ($w < $width && $h > $height) {
                        $canvas = Image::canvas($w, $height);
                        $image = $imageFile->resize($width, $height, function ($constraint) {
                            $constraint->aspectRatio();
                        });

                        $canvas->insert($image, 'center');
                        $canvas->encode('jpg', $quantity);
                        $canvas->save($path, $quantity);
                    } else {
                        $canvas = Image::canvas($w, $h);
                        $canvas->insert($imageFile, 'center');
                        $canvas->encode('jpg', $quantity);
                        $canvas->save($path, $quantity);
                    }
                } catch (\Exception $e) {
                    return $e->getMessage();
                }
                Services::where('id',$request->service_id)->update(['image'=>$request->imageName,'status'=>'Completed']);
                $final_data=Services::where('id',$request->service_id)->where('is_deleted',0)->first();
                $data['data'] = $final_data;
                $data['success'] = true;
                $data['code'] = 200;
                $data['message'] = 'Service Close , Signature Upload Successfully';//for error message
            }

        }
        return $data;

    }
    public function sericesLists(){
        $services_list=ServicesList::where('is_deleted',0)->get();
        if(!empty($services_list))
        {
            $data['data'] = $services_list;//for success true
            $data['success'] = true;//for success true
            $data['code'] = 200;//for success code 200
            $data['message'] = 'Service Lists updated Successfully';//for success message
        }
        else{
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'Something Went Wrong!';//for success message
        }

        return $data;
    }
    public function technicianAnouncement()
    {
        $announcement=Announcement::where('technician','Technician')->orderBy('id','desc')->limit(15)->get();
        $team=team::where('is_deleted',0)->get();
        if(count($announcement) > 0 )
        {
            $announcement=Announcement::where('technician','Technician')->orderBy('id','desc')->limit(15)->get();
            foreach ($announcement as $item)
            {
                if($item->image !='')
                {
                    $item['image']=asset('announce/'.$item->image);
                }
                else
                {
                    $item['image']=asset('images/no_img.png');
                }

            }
            $data['data'] = $announcement;//for success true
            $data['success'] = true;//for success true
            $data['code'] = 200;//for success code 200
            $data['message'] = 'Announcement for technician';//for success message
        }
        else{
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'Announcement not found!';//for success message
        }
        return $data;
    }
    public function customerAnouncement()
    {
        $announcement=Announcement::where('technician','Customer')->orderBy('id','desc')->limit(15)->get();
        if(count($announcement ) > 0)
        {
            $announcement=Announcement::where('technician','Customer')->orderBy('id','desc')->limit(15)->get();
            foreach ($announcement as $item)
            {
                if($item->image !='')
                {
                    $item['image']=asset('announce/'.$item->image);
                }
                else
                {
                    $item['image']=asset('images/no_img.png');
                }

            }
            $data['data'] = $announcement;//for success true
            $data['success'] = true;//for success true
            $data['code'] = 200;//for success code 200
            $data['message'] = 'Announcement for customers';//for success message
        }
        else{
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'Announcement not found!';//for success message
        }
        return $data;
    }

    public function technicianassistant(){
        $technician_assist = Technician_Assist::where('is_deleted',0)->get();

        if(count($technician_assist ) > 0) {
            foreach ($technician_assist as $item) {
                if ($item->PDF != '') {
                    $item['PDF'] = asset('technician_assist/' . $item->PDF);
                } else {
                    $item['image'] = asset('images/image.png');
                }

            }
            $data['data'] = $technician_assist;//for success true
            $data['success'] = true;//for success true
            $data['code'] = 200;//for success code 200
            $data['message'] = 'Technician Assist Available Here';//for success message
        }
        else{
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'Technician Assist not found!';//for success message
        }
        return $data;

    }
    public function versionCheck()
    {
        $version =app_version::first();
//        return $version;
        if(!empty($version))
        {
            $data['data'] = $version;//for success true
            $data['success'] = true;//for success true
            $data['code'] = 200;//for success code 200
            $data['message'] = 'this version is available';//for success message
        }
        else{
            $data['data'] = 'No Data';//for success true
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'there is no version found';//for success message
        }
        return $data;
    }
}