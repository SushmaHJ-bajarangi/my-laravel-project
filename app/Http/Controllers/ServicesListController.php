<?php

namespace App\Http\Controllers;

use App\DataTables\ServicesListDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateServicesListRequest;
use App\Http\Requests\UpdateServicesListRequest;
use App\Repositories\ServicesListRepository;
use App\Http\Controllers\AppBaseController;
use Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Response;
use App\Models\activity;
use App\Models\Serviceslist;

class ServicesListController extends AppBaseController
{
    /** @var  ServicesListRepository */
    private $servicesListRepository;

    public function __construct(ServicesListRepository $servicesListRepo)
    {
        $this->middleware('auth');
        $this->servicesListRepository = $servicesListRepo;
    }

    /**
     * Display a listing of the ServicesList.
     *
     * @param ServicesListDataTable $servicesListDataTable
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function index(ServicesListDataTable $servicesListDataTable)
    {
        return $servicesListDataTable->render('services_lists.index');
    }

    /**
     * Show the form for creating a new ServicesList.
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function create()
    {
        return view('services_lists.create');
    }

    /**
     * Store a newly created ServicesList in storage.
     *
     * @param CreateServicesListRequest $request
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function store(CreateServicesListRequest $request)
    {
        $input = $request->all();

        $servicesList = $this->servicesListRepository->create($input);

        $entry['t_name'] = "ServiceList";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Inserted";
        activity::create($entry);
        $notification = array(
            'message' => 'Services List saved successfully',
            'alert-type' => 'success'
        );


        return redirect(route('servicesLists.index'))->with($notification);
    }

    /**
     * Display the specified ServicesList.
     *
     * @param  int $id
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function show($id)
    {
        $servicesList = $this->servicesListRepository->find($id);

        if (empty($servicesList)) {
            $notification = array(
                'message' => 'Services List not found',
                'alert-type' => 'success'
            );

            return redirect(route('servicesLists.index'))->with($notification);
        }

        return view('services_lists.show')->with('servicesList', $servicesList);
    }

    /**
     * Show the form for editing the specified ServicesList.
     *
     * @param  int $id
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function edit($id)
    {
        $servicesList = $this->servicesListRepository->find($id);

        if (empty($servicesList)) {
            $notification = array(
                'message' => 'Services List not found',
                'alert-type' => 'success'
            );

            return redirect(route('servicesLists.index'))->with($notification);
        }

        return view('services_lists.edit')->with('servicesList', $servicesList);
    }

    /**
     * Update the specified ServicesList in storage.
     *
     * @param  int              $id
     * @param UpdateServicesListRequest $request
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function update($id, UpdateServicesListRequest $request)
    {
        $servicesList = $this->servicesListRepository->find($id);

        if (empty($servicesList)) {
            $notification = array(
                'message' => 'Services List not found',
                'alert-type' => 'success'
            );

            return redirect(route('servicesLists.index'))->with($notification);
        }

        $servicesList = $this->servicesListRepository->update($request->all(), $id);
        $entry['t_name'] = "ServiceList";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Updated";
        activity::create($entry);
        $notification = array(
            'message' => 'Services List updated successfully.',
            'alert-type' => 'success'
        );

        return redirect(route('servicesLists.index'))->with($notification);
    }

    /**
     * Remove the specified ServicesList from storage.
     *
     * @param  int $id
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function destroy($id)
    {
        $servicesList = $this->servicesListRepository->find($id);

        if (empty($servicesList)) {
            $notification = array(
                'message' => 'Services List not found',
                'alert-type' => 'success'
            );
            return redirect(route('servicesLists.index'))->with($notification);
        }

        ServicesList::where('id',$id)->update(['is_deleted'=>1]);

        $entry['t_name'] = "ServiceList";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Deleted";
        activity::create($entry);
        $notification = array(
            'message' => 'Services List deleted successfully.',
            'alert-type' => 'success'
        );

        return redirect(route('servicesLists.index'))->with($notification);
    }
}
