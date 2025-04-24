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
use App\Models\RopeAvailable;

class RopeAvailableController extends AppBaseController
{
    public function __construct()
    {
//        $this->middleware('auth');

    }

    public function index()
    {
        $data = RopeAvailable::where('is_deleted',0)->get();
        return view('rope_available.index')->with('data',$data);
    }

    public function create()
    {
        return view('rope_available.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
            RopeAvailable::create($data);
            Flash::success('rope available added successfully');
            return redirect(url('rope_available'));
    }

    public function show($id,Request $request)
    {
        $data = RopeAvailable::whereId($id)->first();
        if(empty($data))
        {
            Flash::error('not found');
            return redirect(url('rope_available'));
        }
       return view('rope_available.show')->with('data',$data);
    }
    public function edit($id,Request $request)
    {
        $data = RopeAvailable::whereId($id)->first();
        if(empty($data))
        {
            Flash::error('not found');
            return redirect(url('rope_available'));
        }
        return view('rope_available.edit')->with('data',$data);
    }

    public function update($id,Request $request)
    {
        $data = RopeAvailable::whereId($id)->first();
        if (empty($data)) {
            Flash::error('not found');
            return redirect(url('rope_available'));
        }
        RopeAvailable::whereId($id)->update(['name'=>$request->name]);
        Flash::success('rope available updated successfully');
        return redirect(url('rope_available'));
    }

    public function delete($id,Request $request)
    {
        $data = RopeAvailable::whereId($id)->first();
        if (empty($data)) {
            Flash::error('not found');
            return redirect(url('rope_available'));
        }
        RopeAvailable::whereId($id)->update(['is_deleted'=>'1']);
        Flash::success('rope available Deleted successfully');
        return redirect(url('rope_available'));
    }
}