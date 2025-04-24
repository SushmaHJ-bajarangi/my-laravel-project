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
use App\Models\CarBracket;

class CarBracketController extends AppBaseController
{
    public function __construct()
    {
//        $this->middleware('auth');

    }

    public function index(Request $request)
    {
        $data = CarBracket::where('is_deleted', 0)->get();
//        return $data;
        return view('car_bracket.index')->with('data',$data);
    }

    public function create()
    {
        return view('car_bracket.create');
    }

    public function store(Request $request)
    {
        $data=$request->all();
//        return $data;
        CarBracket::create($data);
        Flash::success('car bracket added successfully');

        return redirect(url('car_bracket'));
    }

    public function show($id)
    {
        $data = CarBracket::whereId($id)->first();
        if(empty($data)){
            Flash::error('Car Bracket Not Found.');
            return redirect(url('car_bracket'));
        }
        return view('car_bracket.show')->with('data', $data);
    }

    public function edit($id)
    {
        $data = CarBracket::whereId($id)->first();
        if (empty($data)){
            Flash::error('Car Bracket Not Found.');
            return redirect(url('car_bracket'));
        }
        return view('car_bracket.edit')->with('data', $data);
    }

    public function update($id,Request $request)
    {
        $data = CarBracket::whereId($id)->first();
        if (empty($data)){
            Flash::error('Car Bracket Not Found.');
            return redirect(url('car_bracket'));
        }

        CarBracket::whereId($id)->update(['name' => $request->name]);
        Flash::success('Car Bracket Updated Successfully.');
        return redirect(url('car_bracket'));
    }

    public function delete($id)
    {
        $data = CarBracket::whereId($id)->first();
        if (empty($data)){
            Flash::error('Car Bracket Not Found.');
            return redirect(url('car_bracket'));
        }
        CarBracket::whereId($id)->update(['is_deleted'=>'1']);

        Flash::success('Car Bracket Deleted Successfully.');

        return redirect(url('car_bracket'));
    }
}