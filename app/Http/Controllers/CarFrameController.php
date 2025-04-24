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
use App\Models\CarFrame;

class CarFrameController extends AppBaseController
{
    public function __construct()
    {
//        $this->middleware('auth');
    }
    public function index()
    {
        $data = CarFrame::where('is_deleted','0')->get();
        return view('car_frame.index')->with('data',$data);
    }
    public function create()
    {
        return view('car_frame.create');
    }

    public function store(Request $request)
    {
        $data =$request->all();
        CarFrame::create($data);
        Flash::success('car frame added successfully');
        return redirect(url('car_frame'));
    }

    public function show($id)
    {
        $data = CarFrame::whereId($id)->first();
        if(empty($data))
        {
            Flash::error('Not Found');
            return redirect('car_frame');
        }
        return view('car_frame.show')->with('data',$data);
    }
    public function edit($id)
    {
        $data = CarFrame::whereId($id)->first();
        if(empty($data))
        {
            Flash::error('Not Found');
            return redirect('car_frame');
        }
        return view('car_frame.edit')->with('data',$data);
    }

    public function update($id,Request $request)
    {
        $data = CarFrame::whereId($id)->first();
        if (empty($data)) {
            Flash::error('Not Found');
            return redirect('car_frame');
        }

        CarFrame::whereId($id)->update(['name'=> $request->name]);
        Flash::success("Car frame updated successfully");
        return redirect('car_frame');
    }

    public function delete($id,Request $request)
    {
        $data = CarFrame::whereId($id)->first();
        if (empty($data)) {
            Flash::error('Not Found');
            return redirect('car_frame');
        }

        CarFrame::whereId($id)->update(['is_deleted'=>'1']);
        Flash::success("Car frame Deleted successfully");
        return redirect('car_frame');
    }
}