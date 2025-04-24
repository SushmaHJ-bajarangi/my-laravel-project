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
use App\Models\ManufactureStatus;


class ManufactureStatusController extends AppBaseController
{

    public function __construct()
    {
//        $this->middleware('auth');

    }

    public function index(Request $request)
    {
        $data = ManufactureStatus::where('is_deleted',0)->get();
        return view('manufacture_status.index')
            ->with('data', $data);

    }

    public function create()
    {
        return view('manufacture_status.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        ManufactureStatus::create($data);
        Flash::success('Manufacture status Saved Successfully.');

        return redirect(url('manufacture_status'));
    }

    public function show($id)
    {
        $data = ManufactureStatus::whereId($id)->first();
        if (empty($data)){
            Flash::error('Manufacture status Not Found.');
            return redirect(url('manufacture_status'));
        }
        return view('manufacture_status.show')->with('data', $data);
    }

    public function edit($id)
    {
        $data = ManufactureStatus::whereId($id)->first();
        if (empty($data)){
            Flash::error('Manufacture status Not Found.');
            return redirect(url('manufacture_status'));
        }
        return view('manufacture_status.edit')->with('data', $data);
    }

    public function update($id, Request $request)
    {
        $data = ManufactureStatus::whereId($id)->first();
        if (empty($data)){
            Flash::error('Manufacture status Not Found.');
            return redirect(url('manufacture_status'));
        }

        ManufactureStatus::whereId($id)->update(['title' => $request->title]);
        Flash::success('Manufacture status Updated Successfully.');
        return redirect(url('manufacture_status'));
    }

    public function delete($id)
    {
        $data = ManufactureStatus::whereId($id)->first();
        if (empty($data)){
            Flash::error('Manufacture status Not Found.');
            return redirect(url('manufacture_status'));
        }
        ManufactureStatus::whereId($id)->update(['is_deleted'=>'1']);

        Flash::success('Manufacture status Deleted Successfully.');

        return redirect(url('manufacture_status'));
    }
}
