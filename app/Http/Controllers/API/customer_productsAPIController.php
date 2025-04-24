<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\Createcustomer_productsAPIRequest;
use App\Http\Requests\API\Updatecustomer_productsAPIRequest;
use App\Models\customer_products;
use App\Models\Services;
use App\Models\customers;
use App\Models\RaiseTickets;
use App\Models\team;
use App\Repositories\customer_productsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Edujugon\PushNotification\PushNotification;
use Response;
use Image;
use App\Models\GenerateQuote;
use App\Models\GenerateQuoteDetails;
use App\Models\plans;
use App\Models\Zone;



/**
 * Class customer_productsController
 * @package App\Http\Controllers\API
 */

class customer_productsAPIController extends AppBaseController
{
    /** @var  customer_productsRepository */
    private $customerProductsRepository;

    public function __construct(customer_productsRepository $customerProductsRepo)
    {
        $this->customerProductsRepository = $customerProductsRepo;
    }

    /**
     * Display a listing of the customer_products.
     * GET|HEAD /customerProducts
     *
     * @param Request $request
     * @return Response
     */
    public function customerProducts(Request $request){
        $id = $request->customer_id;
        if(customers::where('id',$id)->where('is_deleted',0)->exists()){
            if(customer_products::where('customer_id',$id)->where('is_deleted',0)->exists()){
                $products = customer_products::where('customer_id',$id)->where('is_deleted',0)->get();
                    foreach ($products as $item)
                    {
                        $quotesData=GenerateQuoteDetails::where('customer_id',$request->customer_id)->where('unique_job_number',$item->unique_job_number)->where('amc_status','active')->where('is_deleted',0)->first();
                        $quotesDatas=GenerateQuoteDetails::where('customer_id',$request->customer_id)->where('unique_job_number',$item->unique_job_number)->where('amc_status','active')->where('is_deleted',0)->get();
//                        return count($quotesDatas);

                        $riased_ticket=RaiseTickets::where('customer_id',$request->customer_id)->where('unique_job_number',$item->unique_job_number)->where('status','!=','Completed')->get();
                        if(count($riased_ticket) > 0)
                        {
                            $item['open_ticket']=count($riased_ticket);
                        }
                        else
                        {
                            $item['open_ticket']='';
                        }
                        if(!empty($quotesData))
                        {
                            $parts = plans::where('id',$quotesData->plan)->where('is_deleted',0)->first();
                            $item['payment_required']='no';
                            $item['start_date']=$quotesData->start_date;
                            $item['end_date']=$quotesData->end_date;
                            $item['amc_status']=$quotesData->amc_status;
                            $item['plan_name']=$parts->title;
                            $item['active_plan']=$quotesData->id;
                            $date2 = date('Y-m-d',strtotime($quotesData->end_date));
                            $date1=date('Y-m-d');
                            $datetime1 = date_create($date1);
                            $datetime2 = date_create($date2);
                            $interval = date_diff($datetime1, $datetime2);
                            $final_dif= $interval->format('%R%a') . "\n";
                            if( $final_dif < 200)
                            {
                                if(count($quotesDatas) < 2  )
                                {
                                    $item['expire_near']='yes';
                                    $item['expire_days']=abs($final_dif);

                                }
                                else{
                                    $item['expire_near']='no';
                                    $item['expire_days']='';
                                }
                            }
                            else{
                                $item['expire_near']='no';
                                $item['expire_days']='';
                            }


                        }
                        else
                        {
                            $item['payment_required']='yes';
                            $item['plan_name']='no plan';
                            $item['start_date']='';
                            $item['end_date']='';
                            $item['amc_status']='Expired';
                            $item['active_plan']='';
                            $item['expire_near']='no';
                            $item['expire_days']='';
                        }
                        $today_date=strtotime(date('d-m-Y'))*1000;
                    }
                $data['data'] = $products;
                $data['error'] = true;
                $data['code'] = 200;
                $data['message'] = 'Customer Products Found';//for error message

            }
            else{
                $data['data'] = 'No Data';
                $data['error'] = false;
                $data['code'] = 500;
                $data['message'] = 'Customer Products Not Found';//for error message
            }
        }
        else{
            $data['data'] = 'No Data';
            $data['error'] = false;
            $data['code'] = 500;
            $data['message'] = 'Customer Not Found';//for error message
        }
        return $data;
    }

    public function customerParticularProduct(Request $request){
        $id = $request->id;
        $customer_id = $request->customer_id;
        if(customer_products::where('id',$id)->where('customer_id',$customer_id)->where('is_deleted',0)->exists()){
            $products = customer_products::where('id',$id)->where('is_deleted',0)->first();
            $data['data'] = $products;
            $data['error'] = true;
            $data['code'] = 200;
            $data['message'] = 'Customer Product Found';//for error message

        }
        else{
            $data['data'] = 'No Data';
            $data['error'] = false;
            $data['code'] = 500;
            $data['message'] = 'Customer Product Not Found';//for error message
        }
        return $data;
    }

    public function raiseTicket(Request $request)
    {
        $title = $request->title;
        $description = $request->description;
        $customer_id = $request->customer_id;
        $unique_job_number = $request->unique_job_number;
        if ($title == '' || $unique_job_number == '') {
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'All Fields Required';//for error message
        } else {
            if (!empty($request->image) && !empty($request->imageName)) {
                ini_set('max_input_time', -1);
                ini_set('max_execution_time', 0);
                $image = $request->image;
                $imageName = '/images/products/' . $request->imageName;
                $realImage = base64_decode($image);
                $data['image'] = $request->imageName;
                $path = public_path() . $imageName;
                file_put_contents($path, $realImage);
                if ($data['image'] != '') {
                    try {
                        $imageFile = Image::make($path);

                        $w = $imageFile->width();
                        $h = $imageFile->height();

                        $width = 720;
                        $height = 720;
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
                    $input['title'] = $title;
                    $input['description'] = $description;
                    $input['customer_id'] = $customer_id;
                    $input['unique_job_number'] = $unique_job_number;
                    $input['image'] = $request->imageName;
                    $input['date'] = date('d-m-Y');
                    $input['progress_date'] = date('d-m-Y');
                    $input['is_urgent'] = 'no';
                    $input['status'] = 'Pending';

                        RaiseTickets::create($input);
                        $data['data'] = $input;
                        $data['success'] = true;
                        $data['code'] = 200;
                        $data['message'] = 'Raise Ticket Successfully';//for error message
                }

            }
            else{
                $input['title'] = $title;
                $input['description'] = $description;
                $input['customer_id'] = $customer_id;
                $input['unique_job_number'] = $unique_job_number;
                $input['date'] = date('d-m-Y');
                $input['progress_date'] = date('d-m-Y');
                $input['is_urgent'] = 'no';
                $input['status'] = 'Pending';
                $Id = RaiseTickets::create($input);
                $get_data = RaiseTickets::where('id',$Id->id)->first();
                $data['data'] = $get_data;
                $data['success'] = true;
                $data['code'] = 200;
                $data['message'] = 'Raise Ticket Successfully';//for error message
            }
        }
        return $data;
    }

    public function customerOpenTickets(Request $request)
    {
        $customer_id = $request->customer_id;
        $tickets = RaiseTickets::where('customer_id', $customer_id)->where('customer_status','!=','Completed')->orderBy('id','DESC')->where('is_deleted',0)->get();
        foreach ($tickets as $item) {
            $customer_name = customers::where('id', $item->customer_id)->first();
            $address = customer_products::where('unique_job_number', $item->unique_job_number)->first();
            $team_name = team::where('id', $item->assigned_to)->first();
            if ($item->image != null) {
                $item['image'] = asset('images/products/' . $item->image);
            } else {
                $item['image'] = null;
            }
            if(!empty($team_name))
            {
                $item->team_contact_number = $team_name->contact_number;
                $item->assigned_to_title = $team_name->name;
                $item->assigned_to = $team_name->id;
            }
            else
            {
                $item->team_contact_number = '-';
                $item->assigned_to_title = '-';
                $item->assigned_to = '-';
            }
            $product=customer_products::where('unique_job_number',$item->unique_job_number)->where('status','!=','Expired')->where('is_deleted',0)->first();
            if(!empty($product))
            {
                $item['warranty_start_date']=$product->warranty_start_date;
                $item['warranty_end_date']=$product->warranty_end_date;
                $item['warranty_status']=$product->status;
            }
            else{
                $item['warranty_start_date']='';
                $item['warranty_end_date']='';
                $item['warranty_status']='Expired';
            }
            $quotesData=GenerateQuoteDetails::where('customer_id',$request->customer_id)->where('unique_job_number',$item->unique_job_number)->where('amc_status','active')->where('is_deleted',0)->first();
            if(!empty($quotesData)) {

                $parts = plans::where('id', $quotesData->plan)->where('is_deleted', 0)->first();
                $item['payment_required'] = 'no';
                $item['start_date'] = $quotesData->start_date;
                $item['end_date'] = $quotesData->end_date;
                $item['amc_status'] = $quotesData->amc_status;
                $item['plan_name'] = $parts->title;
                $item['active_plan'] = $quotesData->id;
            }
            else{
                $item['payment_required']='yes';
                $item['plan_name']='no plan';
                $item['start_date']='';
                $item['end_date']='';
                $item['amc_status']='Expired';
                $item['active_plan']='';

            }
            $w_end_date=strtotime($address->warranty_end_date) * 1000;
            $t_date=strtotime(date('d-m-Y')) * 1000;
            $item->customer_id = $customer_name->name;
            $item->address = $address->address;
            $item->passenger_capacity = $address->passenger_capacity;
            $item->model_id = $address->model_id;
            $item->number_of_floors = $address->number_of_floors;
            $item->customer_id = $address->customer_id;
            $item->distance = $address->distance;
            $item->unique_job_number = $address->unique_job_number;
            $item->ordered_date = $address->ordered_date;
            $item->no_of_services = $address->no_of_services;
            $zone=Zone::where('id',$address->zone)->where('is_deleted',0)->first();
            if(!empty($zone))
            {
                $item->zone = $zone->title;
            }
            else{
                $item->zone ='';
            }
            $item->contact_number = $customer_name->contact_number;
            $item->name = $customer_name->name;

        }
        if (count($tickets) > 0) {
            $data['data'] = $tickets;//for success true
            $data['success'] = true;//for success true
            $data['code'] = 200;//for success code 200
            $data['message'] = 'Tickets found';//for success message
        } else {
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'Tickets Not Found';//for success message
        }
        return $data;
    }

    public function customerTicketsHistory(Request $request)
    {
        $customer_id = $request->customer_id;
        $tickets = RaiseTickets::where('customer_id', $customer_id)->where('customer_status','=','Completed')->orderBy('id','DESC')->where('is_deleted',0)->get();
        foreach($tickets as $item) {
            $customer_name = customers::where('id', $item->customer_id)->first();
            $address = customer_products::where('unique_job_number', $item->unique_job_number)->first();
            $team_name = team::where('id', $item->assigned_to)->first();
            if ($item->image != null) {
                $item['image'] = asset('images/products/' . $item->image);
            } else {
                $item['image'] = null;
            }
            if ($item->signature_image != null) {
                $item['signature_image'] = asset('signature/' . $item->signature_image);
            } else {
                $item['signature_image'] = null;
            }
            if ($item->close_image != null) {
                $item['close_image'] = asset('closeimage/' . $item->close_image);
            } else {
                $item['close_image'] = null;
            }

            $quotesData=GenerateQuoteDetails::where('customer_id',$request->customer_id)->where('unique_job_number',$item->unique_job_number)->where('amc_status','active')->where('is_deleted',0)->first();
            if(!empty($quotesData))
            {

                $parts = plans::where('id',$quotesData->plan)->where('is_deleted',0)->first();
                $item['payment_required']='no';
                $item['start_date']=$quotesData->start_date;
                $item['end_date']=$quotesData->end_date;
                $item['amc_status']=$quotesData->amc_status;
                $item['plan_name']=$parts->title;
                $item['active_plan']=$quotesData->id;
            }
            else
            {
                $item['payment_required']='yes';
                $item['plan_name']='no plan';
                $item['start_date']='';
                $item['end_date']='';
                $item['amc_status']='Expired';
                $item['active_plan']='';
            }
            $item->customer_id = $customer_name->name;
            $item->team_contact_number = $customer_name->contact_number;
            $item->assigned_to_title = $team_name->name;
            $item->assigned_to = $team_name->id;
            $item->address = $address->address;
            $item->passenger_capacity = $address->passenger_capacity;
            $item->model_id = $address->model_id;
            $item->number_of_floors = $address->number_of_floors;
            $item->customer_id = $address->customer_id;
            $item->distance = $address->distance;
            $item->unique_job_number = $address->unique_job_number;
            $item->warranty_start_date = $address->warranty_start_date;
            $item->warranty_end_date = $address->warranty_end_date;
            $item->ordered_date = $address->ordered_date;
            $item->warranty_status = $address->warranty_status;
            $item->no_of_services = $address->no_of_services;
            $zone=Zone::where('id',$address->zone)->where('is_deleted',0)->first();
            if(!empty($zone))
            {
                $item->zone = $zone->title;
            }
            else{
                $item->zone ='';
            }

            $item->contact_number = $team_name->contact_number;
            $item->name = $customer_name->name;

        }
        if (count($tickets) > 0) {
            $data['data'] = $tickets;//for success true
            $data['success'] = true;//for success true
            $data['code'] = 200;//for success code 200
            $data['message'] = 'Tickets found';//for success message
        } else {
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'Tickets Not Found';//for success message
        }
        return $data;
    }

    public  function signatureSubmit(Request $request)
    {
        if($request->ticket_id == '' || $request->unique_job_number == '')
        {
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'Tickets Not Found';//for success message
        }
        else
        {
            if (!empty($request->image) && !empty($request->imageName)) {
                ini_set('max_input_time', -1);
                ini_set('max_execution_time', 0);
                $image = $request->image;
                $imageName = '/signature/' .$request->imageName;
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
                    RaiseTickets::where('id',$request->ticket_id)->update(['signature_image'=>$request->imageName,'customer_status'=>'Completed']);
                    $final_data=RaiseTickets::where('id',$request->ticket_id)->where('is_deleted',0)->first();
                    $data['data'] = $final_data;
                    $data['success'] = true;
                    $data['code'] = 200;
                    $data['message'] = 'Signature Upload Successfully';//for error message
                }

            }
        }
     return $data;
    }

}
