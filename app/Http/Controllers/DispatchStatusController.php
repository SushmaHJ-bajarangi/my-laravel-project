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
use App\Models\DispatchStatus;


class DispatchStatusController extends AppBaseController
{

    public function __construct()
    {
//        $this->middleware('auth');

    }

    public function index(Request $request)
    {
        $data = DispatchStatus::where('is_deleted',0)->get();
        return view('dispatch_status.index')
            ->with('data', $data);

    }

    public function create()
    {
        return view('dispatch_status.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        DispatchStatus::create($data);
        Flash::success('Dispatch status Saved Successfully.');

        return redirect(url('dispatch_status'));
    }

    public function show($id)
    {
        $data = DispatchStatus::whereId($id)->first();
        if (empty($data)){
            Flash::error('Dispatch status Not Found.');
            return redirect(url('dispatch_status'));
        }
        return view('dispatch_status.show')->with('data', $data);
    }

    public function edit($id)
    {
        $data = DispatchStatus::whereId($id)->first();
        if (empty($data)){
            Flash::error('Dispatch status Not Found.');
            return redirect(url('dispatch_status'));
        }
        return view('dispatch_status.edit')->with('data', $data);
    }

    public function update($id, Request $request)
    {
        $data = DispatchStatus::whereId($id)->first();
        if (empty($data)){
            Flash::error('Dispatch status Not Found.');
            return redirect(url('dispatch_status'));
        }

        DispatchStatus::whereId($id)->update(['title' => $request->title]);
        Flash::success('Dispatch status Updated Successfully.');
        return redirect(url('dispatch_status'));
    }

    public function delete($id)
    {
        $data = DispatchStatus::whereId($id)->first();
        if (empty($data)){
            Flash::error('Dispatch status Not Found.');
            return redirect(url('dispatch_status'));
        }
        DispatchStatus::whereId($id)->update(['is_deleted'=>'1']);

        Flash::success('Dispatch status Deleted Successfully.');

        return redirect(url('dispatch_status'));
    }
}
