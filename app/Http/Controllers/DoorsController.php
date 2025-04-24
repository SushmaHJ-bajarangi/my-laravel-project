<?php

namespace App\Http\Controllers;

use App\DataTables\DoorsDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateDoorsRequest;
use App\Http\Requests\UpdateDoorsRequest;
use App\Repositories\DoorsRepository;
use App\Http\Controllers\AppBaseController;
use Response;
use App\models\Doors;
class DoorsController extends AppBaseController
{
    /** @var  DoorsRepository */
    private $doorsRepository;

    public function __construct(DoorsRepository $doorsRepo)
    {
        $this->middleware('auth');
        $this->doorsRepository = $doorsRepo;
    }

    /**
     * Display a listing of the Doors.
     *
     * @param DoorsDataTable $doorsDataTable
     * @return Response
     */
    public function index(DoorsDataTable $doorsDataTable)
    {
        return $doorsDataTable->render('doors.index');
    }

    /**
     * Show the form for creating a new Doors.
     *
     * @return Response
     */
    public function create()
    {
        return view('doors.create');
    }

    /**
     * Store a newly created Doors in storage.
     *
     * @param CreateDoorsRequest $request
     *
     * @return Response
     */
    public function store(CreateDoorsRequest $request)
    {
        $input = $request->all();

        $doors = $this->doorsRepository->create($input);

        $notification = array(
            'message' => 'Doors saved successfully',
            'alert-type' => 'success'
        );

        return redirect(route('doors.index'))->with($notification);
    }

    /**
     * Display the specified Doors.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $doors = $this->doorsRepository->find($id);

        if (empty($doors)) {
            $notification = array(
                'message' => 'Doors not found',
                'alert-type' => 'error'
            );

            return redirect(route('doors.index'))->with($notification);
        }

        return view('doors.show')->with('doors', $doors);
    }

    /**
     * Show the form for editing the specified Doors.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $doors = $this->doorsRepository->find($id);

        if (empty($doors)) {
            $notification = array(
                'message' => 'Doors not found',
                'alert-type' => 'error'
            );

            return redirect(route('doors.index'))->with($notification);
        }

        return view('doors.edit')->with('doors', $doors);
    }

    /**
     * Update the specified Doors in storage.
     *
     * @param  int              $id
     * @param UpdateDoorsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDoorsRequest $request)
    {
        $doors = $this->doorsRepository->find($id);

        if (empty($doors)) {
            $notification = array(
                'message' => 'Doors not found',
                'alert-type' => 'error'
            );

            return redirect(route('doors.index'))->with($notification);
        }

        $doors = $this->doorsRepository->update($request->all(), $id);

        $notification = array(
            'message' => 'Doors updated successfully',
            'alert-type' => 'success'
        );
        return redirect(route('doors.index'))->with($notification);
    }

    /**
     * Remove the specified Doors from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $doors = $this->doorsRepository->find($id);

        if (empty($doors)) {
            $notification = array(
                'message' => 'Doors not found',
                'alert-type' => 'error'
            );

            return redirect(route('doors.index'))->with($notification);
        }

//        $this->doorsRepository->delete($id);
        Doors::where('id',$id)->update(['is_deleted'=>1]);

        $notification = array(
            'message' => 'Doors deleted successfully',
            'alert-type' => 'success'
        );

        return redirect(route('doors.index'))->with($notification);
    }
}
