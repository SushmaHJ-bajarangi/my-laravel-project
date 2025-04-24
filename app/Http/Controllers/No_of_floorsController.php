<?php

namespace App\Http\Controllers;

use App\DataTables\No_of_floorsDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateNo_of_floorsRequest;
use App\Http\Requests\UpdateNo_of_floorsRequest;
use App\Models\No_of_floors;
use App\Repositories\No_of_floorsRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Response;
use App\Models\activity;

class No_of_floorsController extends AppBaseController
{
    /** @var  No_of_floorsRepository */
    private $noOfFloorsRepository;

    public function __construct(No_of_floorsRepository $noOfFloorsRepo)
    {
        $this->middleware('auth');
        $this->noOfFloorsRepository = $noOfFloorsRepo;
    }

    /**
     * Display a listing of the No_of_floors.
     *
     * @param No_of_floorsDataTable $noOfFloorsDataTable
     * @return Response
     */
    public function index(No_of_floorsDataTable $noOfFloorsDataTable)
    {
        return $noOfFloorsDataTable->render('no_of_floors.index');
    }

    /**
     * Show the form for creating a new No_of_floors.
     *
     * @return Response
     */
    public function create()
    {
        return view('no_of_floors.create');
    }

    /**
     * Store a newly created No_of_floors in storage.
     *
     * @param CreateNo_of_floorsRequest $request
     *
     * @return Response
     */
    public function store(CreateNo_of_floorsRequest $request)
    {
        $input = $request->all();

        $noOfFloors = $this->noOfFloorsRepository->create($input);

        $entry['t_name'] = "NoOfFloors";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Inserted";
        activity::create($entry);
        $notification = array(
            'message' => 'No Of Floors saved successfully',
            'alert-type' => 'success'
        );

        return redirect(route('noOfFloors.index'))->with($notification);
    }

    /**
     * Display the specified No_of_floors.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $noOfFloors = $this->noOfFloorsRepository->find($id);

        if (empty($noOfFloors)) {
            $notification = array(
                'message' => 'No Of Floors not found',
                'alert-type' => 'error'
            );

            return redirect(route('noOfFloors.index'))->with($notification);
        }

        return view('no_of_floors.show')->with('noOfFloors', $noOfFloors);
    }

    /**
     * Show the form for editing the specified No_of_floors.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $noOfFloors = $this->noOfFloorsRepository->find($id);

        if (empty($noOfFloors)) {
            $notification = array(
                'message' => 'No Of Floors not found',
                'alert-type' => 'error'
            );

            return redirect(route('noOfFloors.index'))->with($notification);
        }

        return view('no_of_floors.edit')->with('noOfFloors', $noOfFloors);
    }

    /**
     * Update the specified No_of_floors in storage.
     *
     * @param  int              $id
     * @param UpdateNo_of_floorsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateNo_of_floorsRequest $request)
    {
        $noOfFloors = $this->noOfFloorsRepository->find($id);

        if (empty($noOfFloors)) {
            Flash::error('No Of Floors not found');
            $notification = array(
                'message' => 'No Of Floors not found',
                'alert-type' => 'error'
            );
            return redirect(route('noOfFloors.index'))->with($notification);
        }

        $noOfFloors = $this->noOfFloorsRepository->update($request->all(), $id);
        $entry['t_name'] = "NoOfFloors";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Updated";
        activity::create($entry);
        $notification = array(
            'message' => 'No Of Floors updated successfully',
            'alert-type' => 'success'
        );
        return redirect(route('noOfFloors.index'))->with($notification);
    }

    /**
     * Remove the specified No_of_floors from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $noOfFloors = $this->noOfFloorsRepository->find($id);

        if (empty($noOfFloors)) {
            $notification = array(
                'message' => 'No Of Floors not found',
                'alert-type' => 'error'
            );

            return redirect(route('noOfFloors.index'))->with($notification);
        }

//        $this->noOfFloorsRepository->delete($id);
        No_of_floors::where('id',$id)->update(['is_deleted'=>1]);
        $entry['t_name'] = "NoOfFloors";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Deleted";
        activity::create($entry);
        $notification = array(
            'message' => 'No Of Floors deleted successfully',
            'alert-type' => 'success'
        );

        return redirect(route('noOfFloors.index'))->with($notification);
    }
}
