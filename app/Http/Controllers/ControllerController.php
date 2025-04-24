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
use App\Models\Controller;

class ControllerController extends AppBaseController
{
    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function index()
    {
        $data=Controller::where('is_deleted',0)->get();
        return view('controller.index')->with('data',$data);
    }

    public function create()
    {
        return view('controller.create');
    }

    public function store(Request $request)
    {
        $data =$request->all();
        Controller::create($data);
        Flash::success('controller added successfully');
        return redirect(url('controller'));
    }

    public function show($id)
    {
        $data = Controller::whereId($id)->first();

        if(empty($data))
        {
            Flash::error("Not found");
            return redirect(url('controller'));
        }
       return view('controller.show')->with('data',$data);

    }

    public function edit($id)
    {
        $data = Controller::whereId($id)->first();

        if(empty($data))
        {
            Flash::error("Not found");
            return redirect(url('controller'));
        }
        return view('controller.edit')->with('data',$data);

    }

    public function update($id,Request $request)
    {
        $data = Controller::whereId($id)->first();

        if(empty($data))
        {
            Flash::error("Not found");
            return redirect(url('controller'));
        }
        Controller::whereId($id)->update(['name'=>$request->name]);
        return redirect(url('controller'));
    }

    public function delete($id,Request $request)
    {
        $data = Controller::whereId($id)->first();

        if(empty($data))
        {
            Flash::error("Not found");
            return redirect(url('controller'));
        }
        Controller::whereId($id)->update(['is_deleted'=>1]);
        return redirect(url('controller'));
    }
}