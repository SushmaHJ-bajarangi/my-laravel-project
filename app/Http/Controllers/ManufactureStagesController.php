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
use App\Models\ManufactureStage;


class ManufactureStagesController extends AppBaseController
{

    public function __construct()
    {
//        $this->middleware('auth');

    }

    public function index(Request $request)
    {
        $data = ManufactureStage::where('is_deleted',0)->get();
        return view('manufacture_stages.index')
            ->with('data', $data);

    }

    public function create()
    {
        return view('manufacture_stages.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        ManufactureStage::create($data);
        Flash::success('Manufacture stages Saved Successfully.');

        return redirect(url('manufacture_stages'));
    }

    public function show($id)
    {
        $data = ManufactureStage::whereId($id)->first();
        if (empty($data)){
            Flash::error('Manufacture stages Not Found.');
            return redirect(url('manufacture_stages'));
        }
        return view('manufacture_stages.show')->with('data', $data);
    }

    public function edit($id)
    {
        $data = ManufactureStage::whereId($id)->first();
        if (empty($data)){
            Flash::error('Manufacture stages Not Found.');
            return redirect(url('manufacture_stages'));
        }
        return view('manufacture_stages.edit')->with('data', $data);
    }

    public function update($id, Request $request)
    {
        $data = ManufactureStage::whereId($id)->first();
        if (empty($data)){
            Flash::error('Manufacture stages Not Found.');
            return redirect(url('manufacture_stages'));
        }

        ManufactureStage::whereId($id)->update(['title' => $request->title]);
        Flash::success('Manufacture stages Updated Successfully.');
        return redirect(url('manufacture_stages'));
    }

    public function delete($id)
    {
        $data = ManufactureStage::whereId($id)->first();
        if (empty($data)){
            Flash::error('Manufacture stages Not Found.');
            return redirect(url('manufacture_stages'));
        }
        ManufactureStage::whereId($id)->update(['is_deleted'=>'1']);

        Flash::success('Manufacture stages Deleted Successfully.');

        return redirect(url('manufacture_stages'));
    }
}
