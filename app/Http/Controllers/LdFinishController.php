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
use App\Models\LdFinish;

class LdFinishController extends AppBaseController
{
    public function __construct()
    {
//        $this->middleware('auth');

    }
    public function index()
    {
        $data=LdFinish::where('is_deleted', '0')->get();
        return view('ld_finish.index')->with('data',$data);
    }

    public function create()
    {
        return view('ld_finish.create');
    }

    public function store(Request $request)
    {
        $data=$request->all();
        LdFinish::create($data);
        Flash::success("Finish added successfully");

        return redirect(url('ld_finish'));
    }
    public function show($id)
    {
        $data=LdFinish::whereId($id)->first();
        if(empty($data))
        {
            Flash::error("not found");
            return redirect(url('ld_finish'));
        }
        return view('ld_finish.show')->with('data',$data);
    }

    public function edit($id)
    {
        $data = LdFinish::whereId($id)->first();
        if(empty($data))
        {
            Flash::error("not found");
            return redirect(url('ld_finish'));
        }

        return view('ld_finish.edit')->with('data',$data);
    }

    public function update($id,Request $request)
    {
        $data = LdFinish::whereId($id)->first();
        if(empty($data))
        {
            Flash::error("not found");
            return redirect(url('ld_finish'));
        }

        LdFinish::whereId($id)->update(['name'=>$request->name]);
        return redirect(url('ld_finish'));

    }

    public function delete($id)
    {
        $data = LdFinish::whereId($id)->first();

        if(empty($data))
        {
            Flash::error("not found");
            return redirect(url('ld_finish'));
        }

        LdFinish::whereId($id)->update(['is_deleted'=>1]);
        return redirect(url('ld_finish'));

    }

}