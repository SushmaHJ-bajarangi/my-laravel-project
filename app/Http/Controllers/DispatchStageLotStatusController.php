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
use App\Models\DispatchStageLotStatus;

class DispatchStageLotStatusController extends AppBaseController
{
    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $data = DispatchStageLotStatus::where('is_deleted', 0)->get();
//        return $data;
        return view('dispatch_stage_lot_status.index')->with('data', $data);
    }
    public function create()
    {
        return view('dispatch_stage_lot_status.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        DispatchStageLotStatus::create($data);
        Flash::success('DispatchStageLotStatus Saved Successfully.');
        return redirect(url('dispatch_stage_lot_status'));
    }

    public function show($id)
    {
        $data = DispatchStageLotStatus::whereId($id)->first();
        if(empty($data)){
            Flash::error('DispatchStageLotStatus Not Found.');
            return redirect(url('dispatch_stage_lot_status'));
        }
        return view('dispatch_stage_lot_status.show')->with('data', $data);
    }

    public function edit($id)
    {
        $data = DispatchStageLotStatus::whereId($id)->first();
        if (empty($data)){
            Flash::error('DispatchStageLotStatus Not Found.');
            return redirect(url('dispatch_stage_lot_status'));
        }
        return view('dispatch_stage_lot_status.edit')->with('data', $data);
    }

    public function update($id, Request $request)
    {
        $data = DispatchStageLotStatus::whereId($id)->first();
        if (empty($data)){
            Flash::error('DispatchStageLotStatus Not Found.');
            return redirect(url('dispatch_stage_lot_status'));
        }
        DispatchStageLotStatus::whereId($id)->update(['name' => $request->name]);
        Flash::success('DispatchStageLotStatus Updated Successfully.');
        return redirect(url('dispatch_stage_lot_status'));
    }

    public function delete($id)
    {
        $data = DispatchStageLotStatus::whereId($id)->first();
        if (empty($data)){
            Flash::error('Dispatch Stage/Lot Status Not Found.');
            return redirect(url('dispatch_stage_lot_status'));
        }
        DispatchStageLotStatus::whereId($id)->update(['is_deleted'=>'1']);

        Flash::success('Dispatch Stage/Lot Status Deleted Successfully.');

        return redirect(url('dispatch_stage_lot_status'));
    }
}