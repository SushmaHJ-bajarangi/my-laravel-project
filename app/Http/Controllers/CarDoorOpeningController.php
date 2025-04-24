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
use App\Models\CarDoorOpening;

class CarDoorOpeningController extends AppBaseController
{
    public function __construct()
    {
//        $this->middleware('auth');

    }

    public function index()
    {
        $data = CarDoorOpening::where('is_deleted','0')->get();
        return view('car_door_opening.index')->with('data',$data);
    }

    public function create()
    {
        return view('car_door_opening.create');
    }

    public function store(request $request)
    {
        $data = $request->all();
        CarDoorOpening::create($data);
        Flash::success('car door opening added successfully');
        return redirect(url('car_door_opening'));

    }
    public function show($id)
    {
        $data = CarDoorOpening::whereId($id)->first();
        if(empty($data))
        {
            Flash::error('not found');
            return redirect(url('car_door_opening'));
        }
        return view('car_door_opening.show')->with('data',$data);
    }
    public function edit($id)
    {
        $data = CarDoorOpening::whereId($id)->first();
        if(empty($data))
        {
            Flash::error('not found');
            return redirect(url('car_door_opening'));
        }
        return view('car_door_opening.edit')->with('data',$data);
    }

    public function update($id,Request $request)
    {
        $data = CarDoorOpening::whereId($id)->first();
        if (empty($data)) {
            Flash::error('not found');
            return redirect(url('car_door_opening'));
        }
        CarDoorOpening::whereId($id)->update(['name'=>$request->name]);
        Flash::success('car door opening updated successfully');
        return redirect(url('car_door_opening'));
    }

    public function delete($id,Request $request)
    {
        $data = CarDoorOpening::whereId($id)->first();
        if (empty($data)) {
            Flash::error('not found');
            return redirect(url('car_door_opening'));
        }
        CarDoorOpening::whereId($id)->update(['is_deleted'=>'1']);
        Flash::success('car door opening Deleted successfully');
        return redirect(url('car_door_opening'));
    }



}