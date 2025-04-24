<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Response;
use App\Models\DispatchPaymentStatus;

class DispatchPaymentStatusController extends AppBaseController
{
    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $data = DispatchPaymentStatus::where('is_deleted', 0)->get();
//        return $data;
        return view('dispatch_payment_status.index')->with('data', $data);
    }
   
    public function create()
    {
        return view('dispatch_payment_status.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        DispatchPaymentStatus::create($data);
        Flash::success('DispatchPaymentStatus Saved Successfully.');
        return redirect(url('dispatch_payment_status'));
    }

    public function show($id)
    {
        $data = DispatchPaymentStatus::whereId($id)->first();
        if(empty($data)){
            Flash::error('DispatchPaymentStatus Not Found.');
            return redirect(url('dispatch_payment_status'));
        }
        return view('dispatch_payment_status.show')->with('data', $data);
    }

    public function edit($id)
    {
        $data = DispatchPaymentStatus::whereId($id)->first();
        if (empty($data)){
            Flash::error('DispatchPaymentStatus Not Found.');
            return redirect(url('dispatch_payment_status'));
        }
        return view('dispatch_payment_status.edit')->with('data', $data);
    }

    public function update($id, Request $request)
    {
        $data = DispatchPaymentStatus::whereId($id)->first();
        if (empty($data)){
            Flash::error('DispatchPaymentStatus Not Found.');
            return redirect(url('dispatch_payment_status'));
        }
        DispatchPaymentStatus::whereId($id)->update(['name' => $request->name]);
        Flash::success('DispatchPaymentStatus Updated Successfully.');
        return redirect(url('dispatch_payment_status'));
    }

    public function delete($id)
    {
        $data = DispatchPaymentStatus::whereId($id)->first();
        if (empty($data)){
            Flash::error('DispatchPaymentStatus Not Found.');
            return redirect(url('dispatch_payment_status'));
        }
        DispatchPaymentStatus::whereId($id)->update(['is_deleted'=>'1']);

        Flash::success('DispatchPaymentStatus Deleted Successfully.');

        return redirect(url('dispatch_payment_status'));
    }
}