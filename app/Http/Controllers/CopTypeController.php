<?php

namespace App\Http\Controllers;

use App\DataTables\CopTypeDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateCopTypeRequest;
use App\Http\Requests\UpdateCopTypeRequest;
use App\Models\CopType;
use App\Repositories\CopTypeRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class CopTypeController extends AppBaseController
{
    /** @var  CopTypeRepository */
    private $copTypeRepository;

    public function __construct(CopTypeRepository $copTypeRepo)
    {
        $this->middleware('auth');
        $this->copTypeRepository = $copTypeRepo;
    }

    /**
     * Display a listing of the CopType.
     *
     * @param CopTypeDataTable $copTypeDataTable
     * @return Response
     */
    public function index(CopTypeDataTable $copTypeDataTable)
    {
        return $copTypeDataTable->render('cop_types.index');
    }

    /**
     * Show the form for creating a new CopType.
     *
     * @return Response
     */
    public function create()
    {
        return view('cop_types.create');
    }

    /**
     * Store a newly created CopType in storage.
     *
     * @param CreateCopTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateCopTypeRequest $request)
    {
        $input = $request->all();

        $copType = $this->copTypeRepository->create($input);

        $notification = array(
            'message' => 'Doors Type saved successfully',
            'alert-type' => 'success'
        );


        return redirect(route('copTypes.index'))->with($notification);
    }

    /**
     * Display the specified CopType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $copType = $this->copTypeRepository->find($id);

        if (empty($copType)) {
            $notification = array(
                'message' => 'cop Type not found',
                'alert-type' => 'error'
            );

            return redirect(route('copTypes.index'))->with($notification);
        }

        return view('cop_types.show')->with('copType', $copType);
    }

    /**
     * Show the form for editing the specified CopType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $copType = $this->copTypeRepository->find($id);

        if (empty($copType)) {
            $notification = array(
                'message' => 'cop Type not found',
                'alert-type' => 'error'
            );

            return redirect(route('copTypes.index'))->with($notification);
        }

        return view('cop_types.edit')->with('copType', $copType);
    }

    /**
     * Update the specified CopType in storage.
     *
     * @param  int              $id
     * @param UpdateCopTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCopTypeRequest $request)
    {
        $copType = $this->copTypeRepository->find($id);

        if (empty($copType)) {
            $notification = array(
                'message' => 'cop Type not found',
                'alert-type' => 'error'
            );

            return redirect(route('copTypes.index'))->with($notification);
        }

        $copType = $this->copTypeRepository->update($request->all(), $id);

        $notification = array(
            'message' => 'Doors Type updated successfully',
            'alert-type' => 'success'
        );


        return redirect(route('copTypes.index'))->with($notification);
    }

    /**
     * Remove the specified CopType from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $copType = $this->copTypeRepository->find($id);

        if (empty($copType)) {
            $notification = array(
                'message' => 'cop Type not found',
                'alert-type' => 'error'
            );

            return redirect(route('copTypes.index'))->with($notification);
        }

//        $this->copTypeRepository->delete($id);
        CopType::where('id',$id)->update(['is_deleted'=>1]);
        $notification = array(
            'message' => 'Doors Type deleted successfully',
            'alert-type' => 'success'
        );

        return redirect(route('copTypes.index'))->with($notification);
    }
}
