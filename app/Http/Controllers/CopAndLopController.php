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
use App\Models\CopAndLop;

class CopAndLopController extends AppBaseController
{
    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function index()
    {
        $data = CopAndLop::where('is_deleted','0')->get();
        return view('cop_and_lop.index')->with('data',$data);
    }

    public function create()
    {
        return view('cop_and_lop.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        CopAndLop::create($data);
        Flash::success("Cop And Lop added successfully");
        return redirect(url('cop_and_lop'));
    }

    public function show($id)
    {
        $data = CopAndLop::whereId($id)->first();
        if(empty($data))
        {
            Flash::error('not found');
            return redirect(url('cop_and_lop'));
        }
        return view('cop_and_lop.show')->with('data',$data);
    }


    public function edit($id)
    {
        $data = CopAndLop::whereId($id)->first();
        if(empty($data))
        {
            Flash::error('not found');
            return redirect(url('cop_and_lop'));
        }
        return view('cop_and_lop.edit')->with('data',$data);
    }

    public function update($id,Request $request)
    {
        $data = CopAndLop::whereId($id)->first();
        if (empty($data)) {
            Flash::error('not found');
            return redirect(url('cop_and_lop'));
        }
        CopAndLop::whereId($id)->update(['name' => $request->name]);
        Flash::success("Cop And Lop updated successfully");
        return redirect(url('cop_and_lop'));
    }
    public function delete($id,Request $request)
    {
        $data = CopAndLop::whereId($id)->first();
        if (empty($data)) {
            Flash::error('not found');
            return redirect(url('cop_and_lop'));
        }
        CopAndLop::whereId($id)->update(['is_deleted'=>'1']);
        Flash::success("Cop And Lop Deleted successfully");
        return redirect(url('cop_and_lop'));
    }
}