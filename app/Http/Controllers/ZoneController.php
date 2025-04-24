<?php

namespace App\Http\Controllers;

use App\DataTables\ZoneDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateZoneRequest;
use App\Http\Requests\UpdateZoneRequest;
use App\Repositories\ZoneRepository;
use App\Http\Controllers\AppBaseController;
use Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Response;
use App\Models\Zone;
use App\Models\activity;

class ZoneController extends AppBaseController
{
    /** @var  ZoneRepository */
    private $zoneRepository;

    public function __construct(ZoneRepository $zoneRepo)
    {
        $this->middleware('auth');
//        $this->zoneRepository = $zoneRepo;
    }

    /**
     * Display a listing of the Zone.
     *
     * @param ZoneDataTable $zoneDataTable
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function index(ZoneDataTable $zoneDataTable)
    {
        return $zoneDataTable->render('zones.index');
    }

    /**
     * Show the form for creating a new Zone.
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function create()
    {
        return view('zones.create');
    }

    /**
     * Store a newly created Zone in storage.
     *
     * @param CreateZoneRequest $request
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function store(CreateZoneRequest $request)
    {
        $input = $request->except('_method','_token');

        $zone = Zone::create($input);

        $entry['t_name'] = "Zone";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Inserted";
        activity::create($entry);
        $notification = array(
            'message' => 'Zone saved successfully',
            'alert-type' => 'success'
        );

        return redirect(route('zones.index'))->with($notification);
    }

    /**
     * Display the specified Zone.
     *
     * @param  int $id
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function show($id)
    {
        $zone = Zone::find($id);

        if (empty($zone)) {

            $notification = array(
                'message' => 'Zone not found',
                'alert-type' => 'success'
            );

            return redirect(route('zones.index'))->with($notification);
        }

        return view('zones.show')->with('zone', $zone);
    }

    /**
     * Show the form for editing the specified Zone.
     *
     * @param  int $id
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function edit($id)
    {
        $zone = Zone::find($id);

        if (empty($zone)) {
            $notification = array(
                'message' => 'Zone not found',
                'alert-type' => 'success'
            );

            return redirect(route('zones.index'))->with($notification);
        }

        return view('zones.edit')->with('zone', $zone);
    }

    /**
     * Update the specified Zone in storage.
     *
     * @param  int              $id
     * @param UpdateZoneRequest $request
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function update($id, UpdateZoneRequest $request)
    {
        $zone = Zone::find($id);
        if (empty($zone)) {
            $notification = array(
                'message' => 'Zone not found',
                'alert-type' => 'error'
            );

            return redirect(route('zones.index'))->with($notification);
        }

        $zone = Zone::whereId($id)->update($request->except('_method','_token'));

        $entry['t_name'] = "Zone";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Updated";
        activity::create($entry);
        $notification = array(
            'message' => 'Zone updated successfully',
            'alert-type' => 'success'
        );

        return redirect(route('zones.index'))->with($notification);
    }

    /**
     * Remove the specified Zone from storage.
     *
     * @param  int $id
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function destroy($id)
    {
        $zone = Zone::find($id);

        if (empty($zone)) {
            $notification = array(
                'message' => 'Zone not found',
                'alert-type' => 'error'
            );

            return redirect(route('zones.index'))->with($notification);
        }

//        $this->zoneRepository->delete($id);
        Zone::where('id',$id)->update(['is_deleted'=>1]);

        $entry['t_name'] = "Zone";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Deleted";
        activity::create($entry);
        $notification = array(
            'message' => 'Zone deleted successfully',
            'alert-type' => 'success'
        );

        return redirect(route('zones.index'))->with($notification);
    }
}
