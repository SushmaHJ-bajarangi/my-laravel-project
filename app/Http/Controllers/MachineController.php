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
use App\Models\Machine;

class MachineController extends AppBaseController
{
    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function index()
    {
        $data = Machine::where('is_deleted','0')->get();
        return view('machine.index')->with('data',$data);
    }

    public function create()
    {
        return view('machine.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        Machine::create($data);
        Flash::success("Machine Added Successfully");
        return redirect(url('machine'));
    }

    public function show($id)
    {
        $data = Machine::whereId($id)->first();
        if(empty($data))
        {
            Flash::error('Not Found');
            return redirect('machine');
        }
        return view('machine.show')->with('data',$data);
    }

    public function edit($id)
    {
        $data = Machine::whereId($id)->first();
        if(empty($data))
        {
            Flash::error('Not Found');
            return redirect('machine');
        }
        return view('machine.edit')->with('data',$data);
    }

    public function update($id,Request $request)
    {
        $data = Machine::whereId($id)->first();

        if(empty($data))
        {
            Flash::error('not found');
            return redirect(url('machine'));
        }
        Machine::whereId($id)->update(['name'=>$request->name]);
        return redirect(url('machine'));
    }

    public function delete($id,Request $request)
    {
        $data = Machine::whereId($id)->first();
        if(empty($data))
        {
            Flash::error('not found');
            return redirect(url('machine'));
        }
        Machine::whereId($id)->update(['is_deleted'=>'1']);
        return redirect(url('machine'));
    }
}