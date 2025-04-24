<?php

namespace App\Http\Controllers\API;

use App\Models\GenerateQuoteDetails;
use App\Models\partDetails;
use App\Models\parts_purchase;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\customers;
use App\Models\Transactions;
use App\Models\PartsRequest;
use App\Models\parts;



/**
 * Class AnnouncementController
 * @package App\Http\Controllers\API
 */

class PaymentHistoryController extends AppBaseController
{
    /** @var  AnnouncementRepository */


    /**
     * Display a listing of the Announcement.
     * GET|HEAD /announcements
     *
     * @param Request $request
     * @return Response
     */
    public function customerpaymenthistory(Request $request)
    {
        $transaction=Transactions::where('customer_id',$request->customer_id)->where('is_deleted',0)->get();

        foreach ($transaction as $item)
        {
            if($item->transaction_for == 'AMC')
            {
                $quotesDetails=GenerateQuoteDetails::where('id',$item->merchant_param2)->where('is_deleted',0)->first();
                $item['unique_job_number']=$quotesDetails->unique_job_number;
                $item['quoets_id']=$item->merchant_param2;
                $item['parts_id']='';
            }
            else{

                $partsReq= PartsRequest::where('id',$item->merchant_param2)->where('is_deleted',0)->first();
                $item['unique_job_number']=$partsReq->unique_job_number;
                $item['quoets_id']='';
                $item['parts_id']=$item->merchant_param2;

            }

        }
        $data['data']=$transaction;
        $data['success'] = true;//for success true
        $data['code'] = 200;//for success code 200
        $data['message'] = 'Quotes Found';//for success message
        $data['plan_required'] = 'yes';//for success message
        return $data;
    }

}
