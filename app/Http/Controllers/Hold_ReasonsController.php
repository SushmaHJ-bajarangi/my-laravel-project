<?php

namespace App\Http\Controllers;

use App\DataTables\Hold_ReasonsDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateHold_ReasonsRequest;
use App\Http\Requests\UpdateHold_ReasonsRequest;
use App\Repositories\Hold_ReasonsRepository;
use App\Http\Controllers\AppBaseController;
use Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Response;
use App\Models\activity;

class Hold_ReasonsController extends AppBaseController
{
    /** @var  Hold_ReasonsRepository */
    private $holdReasonsRepository;

    public function __construct(Hold_ReasonsRepository $holdReasonsRepo)
    {
        $this->middleware('auth');
        $this->holdReasonsRepository = $holdReasonsRepo;
    }

    /**
     * Display a listing of the Hold_Reasons.
     *
     * @param Hold_ReasonsDataTable $holdReasonsDataTable
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function index(Hold_ReasonsDataTable $holdReasonsDataTable)
    {
        return $holdReasonsDataTable->render('hold__reasons.index');
    }

    /**
     * Show the form for creating a new Hold_Reasons.
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function create()
    {
        return view('hold__reasons.create');
    }

    /**
     * Store a newly created Hold_Reasons in storage.
     *
     * @param CreateHold_ReasonsRequest $request
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function store(CreateHold_ReasonsRequest $request)
    {
        $input = $request->all();

        $holdReasons = $this->holdReasonsRepository->create($input);

        $entry['t_name'] = "HoldReason";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Inserted";
        activity::create($entry);
        Flash::success('Hold  Reasons saved successfully.');

        return redirect(route('holdReasons.index'));
    }

    /**
     * Display the specified Hold_Reasons.
     *
     * @param  int $id
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function show($id)
    {
        $holdReasons = $this->holdReasonsRepository->find($id);

        if (empty($holdReasons)) {
            Flash::error('Hold  Reasons not found');

            return redirect(route('holdReasons.index'));
        }

        return view('hold__reasons.show')->with('holdReasons', $holdReasons);
    }

    /**
     * Show the form for editing the specified Hold_Reasons.
     *
     * @param  int $id
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function edit($id)
    {
        $holdReasons = $this->holdReasonsRepository->find($id);

        if (empty($holdReasons)) {
            Flash::error('Hold  Reasons not found');

            return redirect(route('holdReasons.index'));
        }

        return view('hold__reasons.edit')->with('holdReasons', $holdReasons);
    }

    /**
     * Update the specified Hold_Reasons in storage.
     *
     * @param  int              $id
     * @param UpdateHold_ReasonsRequest $request
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function update($id, UpdateHold_ReasonsRequest $request)
    {
        $holdReasons = $this->holdReasonsRepository->find($id);

        if (empty($holdReasons)) {
            Flash::error('Hold  Reasons not found');

            return redirect(route('holdReasons.index'));
        }

        $holdReasons = $this->holdReasonsRepository->update($request->all(), $id);

        $entry['t_name'] = "HoldReason";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Updated";
        activity::create($entry);
        Flash::success('Hold  Reasons updated successfully.');

        return redirect(route('holdReasons.index'));
    }

    /**
     * Remove the specified Hold_Reasons from storage.
     *
     * @param  int $id
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function destroy($id)
    {
        $holdReasons = $this->holdReasonsRepository->find($id);

        if (empty($holdReasons)) {
            Flash::error('Hold  Reasons not found');

            return redirect(route('holdReasons.index'));
        }

        $this->holdReasonsRepository->delete($id);

        $entry['t_name'] = "HoldReason";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Deleted";
        activity::create($entry);
        Flash::success('Hold  Reasons deleted successfully.');

        return redirect(route('holdReasons.index'));
    }
}
