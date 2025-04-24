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
use App\Models\Harness;

class HarnessController extends AppBaseController
{
    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function index()
    {
        $data = Harness::where('is_deleted',0)->get();
        return view('harness.index')->with('data',$data);
    }

    public function create()
    {
        return view('harness.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
            Harness::create($data);
            Flash::success('harness added successfully');
            return redirect(url('harness'));
    }
    public function show($id,Request $request)
    {
        $data = Harness::whereId($id)->first();

        if(empty($data))
        {
            Flash::error('not found');
            return redirect(url('harness'));
        }
        return view('harness.show')->with('data',$data);
    }

    public function edit($id,Request $request)
    {
        $data = Harness::whereId($id)->first();

        if(empty($data))
        {
            Flash::error('not found');
            return redirect(url('harness'));
        }
        return view('harness.edit')->with('data',$data);
    }
    public function update($id,Request $request)
    {
        $data = Harness::whereId($id)->first();

        if (empty($data)) {
            Flash::error('not found');
            return redirect(url('harness'));
        }
        Harness::whereId($id)->update(['name'=>$request->name]);
        Flash::success('harness updated successfully');
        return redirect(url('harness'));
    }
    public function delete($id,Request $request)
    {
        $data = Harness::whereId($id)->first();

        if (empty($data)) {
            Flash::error('not found');
            return redirect(url('harness'));
        }
        Harness::whereId($id)->update(['is_deleted'=>'1']);
        Flash::success('harness Deleted successfully');
        return redirect(url('harness'));
    }

}