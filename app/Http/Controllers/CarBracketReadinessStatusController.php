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
use App\Models\CarBracketReadinessStatus;


class CarBracketReadinessStatusController extends AppBaseController
{

    public function __construct()
    {
//        $this->middleware('auth');

    }

    public function index()
    {
        $data=CarBracketReadinessStatus::where('is_deleted',0)->get()->all();
//        return $data;
        return view('car_bracket_readiness_status.index')->with('data',$data);
    }


    public function create()
    {
        return view('car_bracket_readiness_status.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        CarBracketReadinessStatus::create($data);
        Flash::success(' Car Bracket Readiness Status added successfully');
        return redirect('car_bracket_readiness_status');
    }

    public function show($id)
    {
        $data = CarBracketReadinessStatus::whereId($id)->first();
        if(empty($data))
        {
            Flass::error('Not Found');
            return redirect(url('car_bracket_readiness_status'));
        }
        return view('car_bracket_readiness_status.show')->with('data',$data);
    }

    public function edit($id)
    {
        $data=CarBracketReadinessStatus::whereId($id)->first();

        if(empty($id))
        {
            Flash::error("Not found");
            return redirect(url('car_bracket_readiness_status'));
        }
        return view('car_bracket_readiness_status.edit')->with('data',$data);
    }

    public function update($id,Request $request)
    {
        $data = CarBracketReadinessStatus::whereId($id)->first();
        if(empty($data))
        {
            Flash::error("Not found");
            return redirect(url('car_bracket_readiness_status'));
        }

        CarBracketReadinessStatus::whereId($id)->update(['title'=>$request->title]);
        Flash::success("Car Bracket Readiness Status added successfully");
        return redirect(url('car_bracket_readiness_status'));
    }

    public function delete($id)
    {
        $data=CarBracketReadinessStatus::whereId($id)->first();
        if(empty($id))
        {
            Flash::error("Not Found");
            return redirect(url('car_bracket_readiness_status'));
        }
        CarBracketReadinessStatus::whereId($id)->update(['is_deleted'=>'1']);

        Flash::success("car_bracket_readiness_status added successfully");
        return redirect(url('car_bracket_readiness_status'));
    }
}