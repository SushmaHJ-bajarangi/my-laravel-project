<?php

namespace App\Http\Controllers;

use App\DataTables\LopTypeDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateLopTypeRequest;
use App\Http\Requests\UpdateLopTypeRequest;
use App\Models\LopType;
use App\Repositories\LopTypeRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class LopTypeController extends AppBaseController
{
    /** @var  LopTypeRepository */
    private $lopTypeRepository;

    public function __construct(LopTypeRepository $lopTypeRepo)
    {
        $this->middleware('auth');
        $this->lopTypeRepository = $lopTypeRepo;
    }

    /**
     * Display a listing of the LopType.
     *
     * @param LopTypeDataTable $lopTypeDataTable
     * @return Response
     */
    public function index(LopTypeDataTable $lopTypeDataTable)
    {
        return $lopTypeDataTable->render('lop_types.index');
    }

    /**
     * Show the form for creating a new LopType.
     *
     * @return Response
     */
    public function create()
    {
        return view('lop_types.create');
    }

    /**
     * Store a newly created LopType in storage.
     *
     * @param CreateLopTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateLopTypeRequest $request)
    {
        $input = $request->all();

        $lopType = $this->lopTypeRepository->create($input);

        $notification = array(
            'message' => 'Lop Type saved successfully',
            'alert-type' => 'success'
        );

        return redirect(route('lopTypes.index'))->with($notification);
    }

    /**
     * Display the specified LopType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $lopType = $this->lopTypeRepository->find($id);

        if (empty($lopType)) {
            $notification = array(
                'message' => 'Lop Type not found',
                'alert-type' => 'error'
            );

            return redirect(route('lopTypes.index'))->with($notification);
        }

        return view('lop_types.show')->with('lopType', $lopType);
    }

    /**
     * Show the form for editing the specified LopType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $lopType = $this->lopTypeRepository->find($id);

        if (empty($lopType)) {
            $notification = array(
                'message' => 'Lop Type not found',
                'alert-type' => 'error'
            );

            return redirect(route('lopTypes.index'))->with($notification);
        }

        return view('lop_types.edit')->with('lopType', $lopType);
    }

    /**
     * Update the specified LopType in storage.
     *
     * @param  int              $id
     * @param UpdateLopTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLopTypeRequest $request)
    {
        $lopType = $this->lopTypeRepository->find($id);

        if (empty($lopType)) {
            $notification = array(
                'message' => 'Lop Type not found',
                'alert-type' => 'error'
            );

            return redirect(route('lopTypes.index'))->with($notification);
        }

        $lopType = $this->lopTypeRepository->update($request->all(), $id);

        $notification = array(
            'message' => 'Lop Type updated successfully',
            'alert-type' => 'success'
        );
        return redirect(route('lopTypes.index'))->with($notification);
    }

    /**
     * Remove the specified LopType from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $lopType = $this->lopTypeRepository->find($id);

        if (empty($lopType)) {
            $notification = array(
                'message' => 'Lop Type not found',
                'alert-type' => 'error'
            );

            return redirect(route('lopTypes.index'))->with($notification);
        }

//        $this->lopTypeRepository->delete($id);
        LopType::where('id',$id)->update(['is_deleted'=>1]);
        $notification = array(
            'message' => 'Lop Type deleted successfully',
            'alert-type' => 'success'
        );
        return redirect(route('lopTypes.index'))->with($notification);
    }
}
