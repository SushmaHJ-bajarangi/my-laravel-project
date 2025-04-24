<?php

namespace App\Http\Controllers;

use App\DataTables\passengerCapacityDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatepassengerCapacityRequest;
use App\Http\Requests\UpdatepassengerCapacityRequest;
use App\Models\passengerCapacity;
use App\Models\activity;
use App\Repositories\passengerCapacityRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Response;

class passengerCapacityController extends AppBaseController
{
    /** @var  passengerCapacityRepository */
    private $passengerCapacityRepository;

    public function __construct(passengerCapacityRepository $passengerCapacityRepo)
    {
        $this->middleware('auth');
        $this->passengerCapacityRepository = $passengerCapacityRepo;
    }

    /**
     * Display a listing of the passengerCapacity.
     *
     * @param passengerCapacityDataTable $passengerCapacityDataTable
     * @return Response
     */
    public function index(passengerCapacityDataTable $passengerCapacityDataTable)
    {
        return $passengerCapacityDataTable->render('passenger_capacities.index');
    }

    /**
     * Show the form for creating a new passengerCapacity.
     *
     * @return Response
     */
    public function create()
    {
        return view('passenger_capacities.create');
    }

    /**
     * Store a newly created passengerCapacity in storage.
     *
     * @param CreatepassengerCapacityRequest $request
     *
     * @return Response
     */
    public function store(CreatepassengerCapacityRequest $request)
    {
        $input = $request->all();

        $passengerCapacity = $this->passengerCapacityRepository->create($input);

        $entry['t_name'] = "PassengerCapacity";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Inserted";
        activity::create($entry);
        $notification = array(
            'message' => 'Passenger Capacity saved successfully',
            'alert-type' => 'success'
        );


        return redirect(route('passengerCapacities.index'))->with($notification);
    }

    /**
     * Display the specified passengerCapacity.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $passengerCapacity = $this->passengerCapacityRepository->find($id);

        if (empty($passengerCapacity)) {
            $notification = array(
                'message' => 'Passenger Capacity not found',
                'alert-type' => 'error'
            );

            return redirect(route('passengerCapacities.index'))->with($notification);
        }

        return view('passenger_capacities.show')->with('passengerCapacity', $passengerCapacity);
    }

    /**
     * Show the form for editing the specified passengerCapacity.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $passengerCapacity = $this->passengerCapacityRepository->find($id);

        if (empty($passengerCapacity)) {
            $notification = array(
                'message' => 'Passenger Capacity not found',
                'alert-type' => 'error'
            );

            return redirect(route('passengerCapacities.index'))->with($notification);
        }

        return view('passenger_capacities.edit')->with('passengerCapacity', $passengerCapacity);
    }

    /**
     * Update the specified passengerCapacity in storage.
     *
     * @param  int              $id
     * @param UpdatepassengerCapacityRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatepassengerCapacityRequest $request)
    {
        $passengerCapacity = $this->passengerCapacityRepository->find($id);

        if (empty($passengerCapacity)) {
            $notification = array(
                'message' => 'Passenger Capacity not found',
                'alert-type' => 'error'
            );

            return redirect(route('passengerCapacities.index'))->with($notification);
        }

        $passengerCapacity = $this->passengerCapacityRepository->update($request->all(), $id);

        $entry['t_name'] = "PassengerCapacity";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Updated";
        activity::create($entry);
        $notification = array(
            'message' => 'Passenger Capacity updated successfully',
            'alert-type' => 'success'
        );

        return redirect(route('passengerCapacities.index'))->with($notification);
    }

    /**
     * Remove the specified passengerCapacity from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $passengerCapacity = $this->passengerCapacityRepository->find($id);

        if (empty($passengerCapacity)) {
            $notification = array(
                'message' => 'Passenger Capacity not found',
                'alert-type' => 'error'
            );

            return redirect(route('passengerCapacities.index'))->with($notification);
        }

//        $this->passengerCapacityRepository->delete($id);
        passengerCapacity::where('id',$id)->update(['is_deleted'=>1]);

        $entry['t_name'] = "PassengerCapacity";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Deleted";
        activity::create($entry);
        $notification = array(
            'message' => 'Passenger Capacity deleted successfully',
            'alert-type' => 'success'
        );

        return redirect(route('passengerCapacities.index'))->with($notification);
    }
}
