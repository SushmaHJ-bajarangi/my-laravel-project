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
use App\Models\LdOpening;

class LdOpeningController extends AppBaseController
{
    public function __construct()
    {
//        $this->middleware('auth');

    }

    public function index()
    {
        $data = LdOpening::where('is_deleted','0')->get();
        return view('ld_opening.index')->with('data',$data);
    }

    public function create()
    {
        return view('ld_opening.create');
     }

     public function store(Request $request)
     {
         $data = $request->all();
         LdOpening::create($data);
         Flash::success("ld opening added successfully");
         return redirect('ld_opening');
     }

     public function show($id)
     {
         $data= LdOpening::whereId($id)->first();
         if(empty($data))
         {
             Flash::error("Not Found");
             return redirect(url('ld_opening'));
         }
         Flash::success("Ld Opening added successfully");
         return view('ld_opening.show')->with('data',$data);
     }

     public function edit($id)
     {
         $data=LdOpening::whereId($id)->first();
         if(empty($data))
         {
             Flash::error("not found");
             return redirect('ld_opening.edit');
         }
         Flash::success("lg opening edited successfully");
         return view('ld_opening.edit')->with('data',$data);
     }

     public function update($id, Request $request)
     {
         $data = LdOpening::whereId($id)->first();
         if(empty($data))
         {
             Flash::error("Not found");
             return redirect(ld_opening);
         }

         LdOpening::whereId($id)->update(['name'=>$request->name]);
         Flash::success("lg opening updated successfully");

         return redirect(url('ld_opening'));
     }

     public function delete($id)
     {
         $data = LdOpening::whereId($id)->first();
         if(empty($data))
         {
             Flash::error("Not Found");
             return redirect('ld_opening');
         }

         LdOpening::whereId($id)->update(['is_deleted' => 1]);
         Flash::success('lg opening deleted successfully');

         return redirect(url('ld_opening'));
     }
}