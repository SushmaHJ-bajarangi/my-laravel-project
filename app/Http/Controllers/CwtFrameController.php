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
use App\Models\CwtFrame;

class CwtFrameController extends AppBaseController
{
    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function index()
    {
        $data = CwtFrame::where('is_deleted','0')->get();
        return view('cwt_frame.index')->with('data',$data);
    }

    public function create()
    {
        return view('cwt_frame.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        CwtFrame::create($data);
        Flash::success("Cwt frame added successfully");
        return redirect(url('cwt_frame'));
    }
    public function show($id)
    {
        $data = CwtFrame::whereId($id)->first();
        if(empty($data))
        {
            Flash::error('Not found');
            return redirect(url('cwt_frame'));
        }
        return view('cwt_frame.show')->with('data',$data);
    }
    public function edit($id)
    {
        $data = CwtFrame::whereId($id)->first();
        if(empty($data))
        {
            Flash::error('Not found');
            return redirect(url('cwt_frame'));
        }
        return view('cwt_frame.edit')->with('data',$data);
    }

    public function update($id,Request $request)
    {
        $data = CwtFrame::whereId($id)->first();
        if (empty($data)) {
            Flash::error('Not found');
            return redirect(url('cwt_frame'));
        }

        CwtFrame::whereId($id)->update(['name'=>$request->name]);
        Flash::success("Cwt frame updated successfully");
        return redirect(url('cwt_frame'));
    }

    public function delete($id,Request $request)
    {
        $data = CwtFrame::whereId($id)->first();
        if (empty($data)) {
            Flash::error('Not found');
            return redirect(url('cwt_frame'));
        }

        CwtFrame::whereId($id)->update(['is_deleted'=>'1']);
        Flash::success("Cwt frame deleted successfully");
        return redirect(url('cwt_frame'));
    }
}