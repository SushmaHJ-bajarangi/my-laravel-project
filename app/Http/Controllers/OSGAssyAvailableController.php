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
use App\Models\OSGAssyAvailable;

class OSGAssyAvailableController extends AppBaseController
{
    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function index()
    {
        $data = OSGAssyAvailable::where('is_deleted',0)->get();
        return view('osg_assy_available.index')->with('data',$data);
    }

    public function create()
    {
        return view('osg_assy_available.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        OSGAssyAvailable::create($data);
        Flash::success('osg_assy_available added successfully');
        return redirect(url('osg_assy_available'));
    }

    public function show($id,Request $request)
    {
        $data = OSGAssyAvailable::whereId($id)->first();
        if(empty($data))
        {
            Flash::error('not found');
            return redirect(url('osg_assy_available'));
        }
        return view('osg_assy_available.show')->with('data',$data);
    }

    public function edit($id,Request $request)
    {
        $data = OSGAssyAvailable::whereId($id)->first();
        if(empty($data))
        {
            Flash::error('not found');
            return redirect(url('osg_assy_available'));
        }
        return view('osg_assy_available.edit')->with('data',$data);
    }

    public function update($id,Request $request)
    {
        $data = OSGAssyAvailable::whereId($id)->first();
        if (empty($data)) {
            Flash::error('not found');
            return redirect(url('osg_assy_available'));
        }
        OSGAssyAvailable::whereId($id)->update(['name'=>$request->name]);
        Flash::success('osg_assy_available added successfully');
        return redirect(url('osg_assy_available'));
    }

    public function delete($id,Request $request)
    {
        $data = OSGAssyAvailable::whereId($id)->first();
        if (empty($data)) {
            Flash::error('not found');
            return redirect(url('osg_assy_available'));
        }
        OSGAssyAvailable::whereId($id)->update(['is_deleted'=> '1']);
        Flash::success('osg_assy_available added successfully');
        return redirect(url('osg_assy_available'));
    }
}