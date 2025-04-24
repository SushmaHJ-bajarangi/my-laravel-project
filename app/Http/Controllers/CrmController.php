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
use App\Models\Crm;

class CrmController extends AppBaseController
{
    public function __construct()
    {
//        $this->middleware('auth');

    }

    public function index(Request $request)
    {
        $data = Crm::where('is_deleted', 0)->get();
        return view('crm.index')->with('data', $data);
    }
    
    public function create()
    {
        return view('crm.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        Crm::create($data);
        Flash::success('Crm Saved Successfully.');

        return redirect(url('crm'));
    }

    public function show($id)
    {
        $data = Crm::whereId($id)->first();
        if(empty($data)){
            Flash::error('Crm Not Found.');
            return redirect(url('crm'));
        }
        return view('crm.show')->with('data', $data);
    }

    public function edit($id)
    {
        $data = Crm::whereId($id)->first();
        if (empty($data)){
            Flash::error('Crm Not Found.');
            return redirect(url('crm'));
        }
        return view('crm.edit')->with('data', $data);
    }

    public function update($id, Request $request)
    {
        $data = Crm::whereId($id)->first();
        if (empty($data)){
            Flash::error('Crm Not Found.');
            return redirect(url('crm'));
        }

        Crm::whereId($id)->update(['name' => $request->name]);
        Flash::success('Crm Updated Successfully.');
        return redirect(url('crm'));
    }

    public function delete($id)
    {
        $data = Crm::whereId($id)->first();
        if (empty($data)){
            Flash::error('Crm Not Found.');
            return redirect(url('crm'));
        }
        Crm::whereId($id)->update(['is_deleted'=>'1']);
        Flash::success('Crm Deleted Successfully.');
        return redirect(url('crm'));
    }
}
