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
use App\Models\MachineChannel;

class MachineChannelController extends AppBaseController
{
    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function index()
    {
        $data = MachineChannel::where('is_deleted','0')->get();
        return view('machine_channel.index')->with('data',$data);
    }

    public function create()
    {
        return view('machine_channel.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        MachineChannel::create($data);
        Flash::success("Machine Channel added successfully");
        return redirect(url('machine_channel'));
    }
    public function show($id)
    {
        $data = MachineChannel::whereId($id)->first();
        if(empty($data))
        {
            Flash::error('Not found');
            return redirect(url('machine_channel'));
        }
        return view('machine_channel.show')->with('data',$data);
    }

    public function edit($id)
    {
        $data = MachineChannel::whereId($id)->first();

        if(empty($data))
        {
            Flash::error('Not Found');
            return redirect(url('machine_channel'));
        }

        Flash::success("machine channel eddited successfully ");
        return view('machine_channel.edit')->with('data',$data);
    }

    public function update($id,Request $request)
    {
        $data = MachineChannel::whereId($id)->first();
        if(empty($data))
        {
            Flash::error('Not Found');
            return redirect(url('machine_channel'));
        }
        MachineChannel::whereId($id)->update(['name'=>$request->name]);
        return redirect(url('machine_channel'));

    }

    public function delete($id)
    {
        $data = MachineChannel::whereId($id)->first();
        if(empty($data))
        {
            Flash::error('Not Found');
            return redirect(url('machine_channel'));
        }
        MachineChannel::whereId($id)->update(['is_deleted'=>'1']);
        return redirect(url('machine_channel'));
    }

}