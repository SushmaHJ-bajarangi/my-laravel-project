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
use App\Models\StageOfMaterial;


class StageOfMaterialController extends AppBaseController
{

    public function __construct()
    {
//        $this->middleware('auth');

    }

    /**
     * Display a listing of the BackupTeam.
     *
     * @param Request $request
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function index(Request $request)
    {
        $stageOfMaterial = StageOfMaterial::where('is_deleted',0)->get();
        return view('stage_of_materials.index')
            ->with('stageOfMaterial', $stageOfMaterial);

    }

    /**
     * Show the form for creating a new BackupTeam.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|Response
     */
    public function create()
    {
        return view('stage_of_materials.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        StageOfMaterial::create($data);
        Flash::success('Stage of material Saved Successfully.');

        return redirect(url('stage_of_materials'));
    }

    public function show($id)
    {
        $data = StageOfMaterial::whereId($id)->first();
        if (empty($data)){
            Flash::error('Stage of material Not Found.');
            return redirect(url('stage_of_materials'));
        }
        return view('stage_of_materials.show')->with('data', $data);
    }

    public function edit($id)
    {
        $data = StageOfMaterial::whereId($id)->first();
        if (empty($data)){
            Flash::error('Stage of material Not Found.');
            return redirect(url('stage_of_materials'));
        }
        return view('stage_of_materials.edit')->with('data', $data);
    }

    public function update($id, Request $request)
    {
        $data = StageOfMaterial::whereId($id)->first();
        if (empty($data)){
            Flash::error('Stage of material Not Found.');
            return redirect(url('stage_of_materials'));
        }

        StageOfMaterial::whereId($id)->update(['title' => $request->title]);
        Flash::success('Stage of material Updated Successfully.');
        return redirect(url('stage_of_materials'));
    }

    public function delete($id)
    {
        $data = StageOfMaterial::whereId($id)->first();
        if (empty($data)){
            Flash::error('Stage of material Not Found.');
            return redirect(url('stage_of_materials'));
        }
        StageOfMaterial::whereId($id)->update(['is_deleted'=>'1']);

        Flash::success('Stage of material Deleted Successfully.');

        return redirect(url('stage_of_materials'));
    }
}
