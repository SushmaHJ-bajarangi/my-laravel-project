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
use App\Models\Priority;


class PriorityController extends AppBaseController
{

    public function __construct()
    {
//        $this->middleware('auth');

    }
    
    public function index(Request $request)
    {
        $data = Priority::where('is_deleted',0)->get();
        return view('priority.index')
            ->with('data', $data);

    }

    public function create()
    {
        return view('priority.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        Priority::create($data);
        Flash::success('Priority Saved Successfully.');

        return redirect(url('priority'));
    }

    public function show($id)
    {
        $data = Priority::whereId($id)->first();
        if (empty($data)){
            Flash::error('Priority Not Found.');
            return redirect(url('priority'));
        }
        return view('priority.show')->with('data', $data);
    }

    public function edit($id)
    {
        $data = Priority::whereId($id)->first();
        if (empty($data)){
            Flash::error('Priority Not Found.');
            return redirect(url('priority'));
        }
        return view('priority.edit')->with('data', $data);
    }

    public function update($id, Request $request)
    {
        $data = Priority::whereId($id)->first();
        if (empty($data)){
            Flash::error('Priority Not Found.');
            return redirect(url('priority'));
        }

        Priority::whereId($id)->update(['title' => $request->title]);
        Flash::success('Priority Updated Successfully.');
        return redirect(url('priority'));
    }

    public function delete($id)
    {
        $data = Priority::whereId($id)->first();
        if (empty($data)){
            Flash::error('Priority Not Found.');
            return redirect(url('priority'));
        }
        Priority::whereId($id)->update(['is_deleted'=>'1']);

        Flash::success('Priority Deleted Successfully.');

        return redirect(url('priority'));
    }
}
