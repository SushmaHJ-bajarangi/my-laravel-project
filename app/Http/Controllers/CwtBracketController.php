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
use App\Models\CwtBracket;

class CwtBracketController extends AppBaseController
{
    public function __construct()
    {
//        $this->middleware('auth');

    }
    public function index()
    {
        $data=CwtBracket::where('is_deleted',0)->get();
        return view('cwt_bracket.index')->with('data',$data);
    }

    public function create()
    {
        return view('cwt_bracket.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        CwtBracket::create($data);
        Flash::success("cwt added successfully");
        return redirect(url('cwt_bracket'));
    }
    public function show($id)
    {
        $data = CwtBracket::whereId($id)->first();
        if(empty($data))
        {
            Flash::error("Not found");
            return redirect(url('cwt_bracket'));
        }
        Flash::success("cwt bracket added successfully");
        return view('cwt_bracket.show')->with('data',$data);
    }

    public function edit($id,Request $request)
    {
        $data=CwtBracket::whereId($id)->first();

        if(empty($id))
        {
            Flash::error("not found");
            return redirect(url('cwt_bracket'));
        }
        return view('cwt_bracket.edit')->with('data',$data);
    }

    public function update($id,Request $request)
    {
        $data = CwtBracket::whereId($id)->first();
        if(empty($data))
        {
            Flash::error("not found");
            return redirect(url('cwt_bracket'));
        }

        CwtBracket::whereId($id)->update(['name'=> $request->name]);
        Flash::success("cwt bracket Updated successfully");

        return redirect(url('cwt_bracket'));
    }

    public function delete($id)
    {
        $data = CwtBracket::whereId($id)->first();
        if(empty($data))
        {
            Flash::error("Not found");
            return redirect(url('cwt_bracket'));
        }
        CwtBracket::whereId($id)->update(['is_deleted'=>1]);
        Flash::success("deleted successfully");

        return redirect('cwt_bracket');
    }
}