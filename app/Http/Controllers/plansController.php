<?php

namespace App\Http\Controllers;

use App\DataTables\plansDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateplansRequest;
use App\Http\Requests\UpdateplansRequest;
use App\Models\plans;
use App\Models\activity;
use App\Models\customer_products;
use App\Models\GenerateQuoteDetails;
use App\Models\customers;
use App\Models\GenerateQuote;
use App\Repositories\plansRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Response;
use Illuminate\Http\Request;

use Edujugon\PushNotification\PushNotification;
class plansController extends AppBaseController
{
    /** @var  plansRepository */
    private $plansRepository;

    public function __construct(plansRepository $plansRepo)
    {
        $this->middleware('auth');
        $this->plansRepository = $plansRepo;
    }

    /**
     * Display a listing of the plans.
     *
     * @param plansDataTable $plansDataTable
     * @return Response
     */
    public function index(plansDataTable $plansDataTable)
    {
        return $plansDataTable->render('plans.index');
    }

    /**
     * Show the form for creating a new plans.
     *
     * @return Response
     */
    public function create()
    {
        return view('plans.create');
    }

    /**
     * Store a newly created plans in storage.
     *
     * @param CreateplansRequest $request
     *
     * @return Response
     */
    public function store(CreateplansRequest $request)
    {
        $input = $request->all();

        $plans = $this->plansRepository->create($input);

        $entry['t_name'] = "Plans";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Inserted";
        activity::create($entry);
        $notification = array(
            'message' => 'Plans saved successfully',
            'alert-type' => 'success'
        );
        return redirect(route('plans.index'))->with($notification);
    }

    /**
     * Display the specified plans.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $plans = $this->plansRepository->find($id);

        if (empty($plans)) {
            $notification = array(
                'message' => 'Plans not found',
                'alert-type' => 'error'
            );
            return redirect(route('plans.index'))->with($notification);
        }

        return view('plans.show')->with('plans', $plans);
    }

    /**
     * Show the form for editing the specified plans.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $plans = $this->plansRepository->find($id);

        if (empty($plans)) {

            $notification = array(
                'message' => 'Plans not found',
                'alert-type' => 'error'
            );
            return redirect(route('plans.index'))->with($notification);
        }

        return view('plans.edit')->with('plans', $plans);
    }

    /**
     * Update the specified plans in storage.
     *
     * @param  int              $id
     * @param UpdateplansRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateplansRequest $request)
    {
        $plans = $this->plansRepository->find($id);

        if (empty($plans)) {
            $notification = array(
                'message' => 'Plans not found',
                'alert-type' => 'error'
            );
            return redirect(route('plans.index'))->with($notification);
        }

        $plans = $this->plansRepository->update($request->all(), $id);

        $entry['t_name'] = "Plans";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Updated";
        activity::create($entry);
        $notification = array(
            'message' => 'Plans updated successfully',
            'alert-type' => 'success'
        );
        return redirect(route('plans.index'))->with($notification);
    }

    /**
     * Remove the specified plans from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $plans = $this->plansRepository->find($id);

        if (empty($plans)) {
            $notification = array(
                'message' => 'Plans not found',
                'alert-type' => 'error'
            );
            return redirect(route('plans.index'))->with($notification);
        }

//        $this->plansRepository->delete($id);
        plans::where('id',$id)->update(['is_deleted'=>1]);

        $entry['t_name'] = "Plans";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Deleted";
        activity::create($entry);
        $notification = array(
            'message' => 'Plans deleted successfully',
            'alert-type' => 'success'
        );

        return redirect(route('plans.index'))->with($notification);
    }

    public function quotes(){
        $data = GenerateQuoteDetails::where('is_deleted',0)->where('amc_status','active')->pluck('unique_job_number');
        $quotes = GenerateQuoteDetails::where('amc_status','!=','active')->where('is_deleted',0)->get();
        return view('plans.quotes',compact('quotes'));
    }

    public function generateQuotesDelete($id){
        GenerateQuoteDetails::where('id',$id)->update(['is_deleted'=>1]);
        $notification = array(
            'message' => 'Quote deleted successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }

    public function updateQuote(Request $request){

        $quote = GenerateQuoteDetails::where('id',$request->id)->where('is_deleted',0)->first();
        $final_price=$request->price;
        GenerateQuoteDetails::where('id',$request->id)->update(['price'=>$final_price,'final_amount'=>$final_price,'service'=>$request->services]);
        GenerateQuote::where('id',$quote->quote_id)->update(['status'=>'Completed']);
        $customer = customers::whereId($quote->customer_id)->where('is_deleted',0)->first();
        $plan=plans::where('id',$quote->plan)->where('is_deleted',0)->first();
        if(!empty($customer)){
            $push = new PushNotification('fcm');
            $push->setMessage([
                'notification' => [
                    'title'=>'hello',
                    'body'=>'hello',
                    'sound' => 'default',
                    "content_available"=> true,
                ],
                'data' => [
                    'customer_name' => $customer->name,
                    'data_notification' => "quote_reminder",
                    'unique_job_number' => $quote->unique_job_number,
                    'amount' => $quote->final_amount,
                    'plan_name' => $plan->title,

                ],
                'click_action'=>'FLUTTER_NOTIFICATION_CLICK'
            ])
                ->setApiKey('AAAAfOmmId0:APA91bFAFAjNjvpC3-Oua0JrJmCO07MHwLVpPbNNr-uhdUGWyE1_4GXyxFTOdozcls7gsh9yUx1vPtUXCyRPupll3pjdDveNW39zHoMQ2jfDicq7TpHF75b2D2YC5bKm12ftyC7o4FI2')
                ->setDevicesToken($customer->device_token)
                ->send();
            $push->getFeedback();
        }
        return 'success';
    }
}
