<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\PlanPrice;
use App\Models\plans;
use App\Models\Settings;
use App\Models\activity;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;

class SettingController extends AppBaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function settings(){
        $plans = plans::where('is_deleted',0)->get();
        $plans_price = PlanPrice::where('is_deleted',0)->get();
        return view('settings.index',compact('plans','plans_price'));
    }

    public function postPlan(Request $request){
        $input['plan_id'] = $request->plan_id;
        $input['price'] = $request->price;
        $input['no_of_floors_from'] = $request->no_of_floors_from;
        $input['no_of_floors_to'] = $request->no_of_floors_to;
        $input['passengers_capacity_from'] = $request->passengers_capacity_from;
        $input['passengers_capacity_to'] = $request->passengers_capacity_to;
        PlanPrice::create($input);

        $entry['t_name'] = "PlanPrice";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Inserted";
        activity::create($entry);
        $notification = array(
            'message' => 'Plan Price saved successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function updatePlan(Request $request,$id){
        $input['plan_id'] = $request->plan_id;
        $input['price'] = $request->price;
        $input['no_of_floors_from'] = $request->no_of_floors_from;
        $input['no_of_floors_to'] = $request->no_of_floors_to;
        $input['passengers_capacity_from'] = $request->passengers_capacity_from;
        $input['passengers_capacity_to'] = $request->passengers_capacity_to;
        PlanPrice::where('id',$id)->update($input);

        $entry['t_name'] = "PlanPrice";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Updated";
        activity::create($entry);
        $notification = array(
            'message' => 'Plan Price updated successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function planPriceDelete($id){
        PlanPrice::where('id',$id)->update(['is_deleted'=>'1']);

        $entry['t_name'] = "PlanPrice";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Deleted";
        activity::create($entry);
        $notification = array(
            'message' => 'Plan Price deleted successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function postDistance(Request $request){
        foreach ($request->value as $key=>$value){
            if(Settings::where('key',$request['key'][$key])->exists()){
                Settings::where('key',$request['key'][$key])->update(['key'=>$request['key'][$key],'value'=>$request['value'][$key]]);
            }
            else{
                $input['key'] = $request['key'][$key];
                $input['value'] = $request['value'][$key];
                Settings::create($input);
            }
        }
        $entry['t_name'] = "PlanPrice";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Distance Price Added";
        activity::create($entry);
        $notification = array(
            'message' => 'Distance Price added successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}