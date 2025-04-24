<?php

namespace App\Http\Controllers\API;



use App\Models\RaiseTickets;
use App\Repositories\DoorsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\review;

/**
 * Class DoorsController
 * @package App\Http\Controllers\API
 */

class ReviewAPIController extends AppBaseController
{
    /** @var  DoorsRepository */
//    private $doorsRepository;

    public function __construct(DoorsRepository $doorsRepo)
    {
//        $this->doorsRepository = $doorsRepo;
    }
    public function reviewfromcustomer(Request $request)
    {
        $review=review::where('ticket_id',$request->ticket_id)->where('is_deleted',0)->first();
        if(!empty($review))
        {
            $rating_data=review::where('ticket_id',$request->ticket_id)->where('is_deleted',0)->first();
            if(!empty($rating_data))
            {

                $ticket=RaiseTickets::where('id',$request->ticket_id)->where('is_deleted',0)->first();
                if(!empty($ticket))
                {
                    review::where('ticket_id',$request->ticket_id)
                        ->update([
                            'c_rating'=>$request->c_rating,
                            'c_star'=>$request->c_star,
                            'rating_for'=>$request->rating_for,
                            'comment_cus'=>$request->comment_cus,
                            'customer_id'=>$ticket->customer_id,
                            'technician_id'=>$ticket->assigned_to

                        ]);
                    $data['success'] = true;//for success true
                    $data['code'] = 200;//for success code 200
                    $data['message'] = 'Techinician Rated Successfully!';//for success message
                }

            }
            else{
                $data['data'] = 'Review submited';//for success true
                $data['error'] = false;//for success true
                $data['code'] = 500;//for success code 200
                $data['message'] = 'Tickets already rated';//for success message
            }

        }
        else
        {
            $ticket=RaiseTickets::where('id',$request->ticket_id)->where('is_deleted',0)->first();
            $input['ticket_id']=$request->ticket_id;
            $input['c_rating']=$request->c_rating;
            $input['c_star']=$request->c_star;
            $input['rating_for']=$request->rating_for;
            $input['comment_cus']=$request->comment_cus;
            $input['comment_tec']=$ticket->customer_id;
            $input['technician_id']=$ticket->assigned_to;
            review::create($input);
            $data['success'] = true;//for success true
            $data['code'] = 200;//for success code 200
            $data['message'] = 'Techinician Rated Successfully!';//for success message
        }
        return $data;
    }
    public function reviewfromtechnician(Request $request)
    {
        $review=review::where('ticket_id',$request->ticket_id)->where('is_deleted',0)->first();
        if(!empty($review))
        {
            $rating_data=review::where('ticket_id',$request->ticket_id)->where('is_deleted',0)->first();
            if(!empty($rating_data))
            {
                $ticket=RaiseTickets::where('id',$request->ticket_id)->where('is_deleted',0)->first();
                if(!empty($ticket)) {
                    $PartsRequest_detail_update = review::where('ticket_id', $request->ticket_id)->update([
                        't_rating' => $request->t_rating,
                        't_star' => $request->t_star,
                        'rating_for' => $request->rating_for,
                        'comment_tec' => $request->comment_tec,
                        'customer_id'=>$ticket->customer_id,
                        'technician_id'=>$ticket->assigned_to
                    ]);
                    $data['success'] = true;//for success true
                    $data['code'] = 200;//for success code 200
                    $data['message'] = 'Customer Rated Successfully!';//for success message
                }
              else{
                    $data['data'] = 'Ticket Not Found';//for success true
                    $data['error'] = false;//for success true
                    $data['code'] = 500;//for success code 200
                    $data['message'] = 'Tickets not found';//for success message
                }
            }
            else{
                $data['data'] = 'Review submited';//for success true
                $data['error'] = false;//for success true
                $data['code'] = 500;//for success code 200
                $data['message'] = 'Tickets already rated';//for success message
            }

        }
        else
        {
            $ticket=RaiseTickets::where('id',$request->ticket_id)->where('is_deleted',0)->first();
            if(!empty($ticket)){
                $input['comment_tec']=$ticket->customer_id;
                $input['technician_id']=$ticket->assigned_to;    
                $input['ticket_id']=$request->ticket_id;
                $input['t_rating']=$request->t_rating;
                $input['t_star']=$request->t_star;
                $input['rating_for']=$request->rating_for;
                $input['comment_tec']=$ticket->customer_id;
                $input['technician_id']=$ticket->assigned_to;
                $PartsRequest_detail_update=review::create($input);
                $data['success'] = true;//for success true
                $data['code'] = 200;//for success code 200
                $data['message'] = 'Customer Rated Successfully!';//for success message
            }
            else{
                $data['data'] = 'Ticket Not Found';//for success true
                $data['error'] = false;//for success true
                $data['code'] = 500;//for success code 200
                $data['message'] = 'Tickets not found';//for success message
            }
        }
        return $data;
    }
}
