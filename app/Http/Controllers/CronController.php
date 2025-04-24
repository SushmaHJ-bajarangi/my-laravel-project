<?php

namespace App\Http\Controllers;

use App\DataTables\Hold_ReasonsDataTable;
use App\Http\Requests;
use App\Http\Controllers\AppBaseController;
use App\Models\Services;
use GuzzleHttp\Psr7\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Response;
use App\Models\GenerateQuoteDetails;
use App\Models\partDetails;
use App\Models\parts_purchase;
use App\Models\Transactions;
use App\Models\customers;
use App\Models\customer_products;

class CronController extends AppBaseController
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function warnttycronDaily()
    {
        $services=Services::where('status','Assigned')->get();
        $today=strtotime(date('d-m-Y'))*1000;
        foreach ($services as $item)
        {
            $service_date=strtotime($item->date)*1000;
            if($service_date < $today)
            {
                Services::where('date',$item->date)->update(['status'=>'Completed']);
            }
        }
    }
    
    public function amc_status()
    {
        $today = \Carbon\Carbon::today()->format('d-m-Y');
        $products = customer_products::whereRaw("STR_TO_DATE(amc_end_date, '%d-%m-%Y') < STR_TO_DATE(?, '%d-%m-%Y')", [$today])
            ->where('status', '=', 'Under Amc')->where('amc_status', '=', 'Under Amc')->update([
                'status' => 'Amc Expire',
                'amc_status' => 'Amc Expire',
            ]);
    }
}
