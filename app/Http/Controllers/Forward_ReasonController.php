<?php

namespace App\Http\Controllers;

use App\DataTables\Forward_ReasonDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateForward_ReasonRequest;
use App\Http\Requests\UpdateForward_ReasonRequest;
use App\Repositories\Forward_ReasonRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Response;
use App\Models\Forward_Reason;
use App\Models\activity;

class Forward_ReasonController extends AppBaseController
{
    /** @var  Forward_ReasonRepository */
    private $forwardReasonRepository;

    public function __construct(Forward_ReasonRepository $forwardReasonRepo)
    {
        $this->middleware('auth');
        $this->forwardReasonRepository = $forwardReasonRepo;
    }

    /**
     * Display a listing of the Forward_Reason.
     *
     * @param Forward_ReasonDataTable $forwardReasonDataTable
     * @return Response
     */
    public function index(Forward_ReasonDataTable $forwardReasonDataTable)
    {
        return $forwardReasonDataTable->render('forward__reasons.index');
    }

    /**
     * Show the form for creating a new Forward_Reason.
     *
     * @return Response
     */
    public function create()
    {
        return view('forward__reasons.create');
    }

    /**
     * Store a newly created Forward_Reason in storage.
     *
     * @param CreateForward_ReasonRequest $request
     *
     * @return Response
     */
    public function store(CreateForward_ReasonRequest $request)
    {
        $input = $request->all();

        $forwardReason = $this->forwardReasonRepository->create($input);

        $entry['t_name'] = "ForwardReason";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Inserted";
        activity::create($entry);
        $notification = array(
            'message' => 'Forward Reason saved successfully',
            'alert-type' => 'success'
        );
        return redirect(route('forwardReasons.index'))->with($notification);
    }

    /**
     * Display the specified Forward_Reason.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $forwardReason = $this->forwardReasonRepository->find($id);

        if (empty($forwardReason)) {
            $notification = array(
                'message' => 'Forward Reason Not Found',
                'alert-type' => 'success'
            );

            return redirect(route('forwardReasons.index'))->with($notification);
        }

        return view('forward__reasons.show')->with('forwardReason', $forwardReason);
    }

    /**
     * Show the form for editing the specified Forward_Reason.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $forwardReason = $this->forwardReasonRepository->find($id);

        if (empty($forwardReason)) {
            $notification = array(
                'message' => 'Forward Reason Not Found',
                'alert-type' => 'success'
            );

            return redirect(route('forwardReasons.index'))->with($notification);
        }

        return view('forward__reasons.edit')->with('forwardReason', $forwardReason);
    }

    /**
     * Update the specified Forward_Reason in storage.
     *
     * @param  int              $id
     * @param UpdateForward_ReasonRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateForward_ReasonRequest $request)
    {
        $forwardReason = $this->forwardReasonRepository->find($id);

        if (empty($forwardReason)) {
            $notification = array(
                'message' => 'Forward Reason Not Found',
                'alert-type' => 'success'
            );

            return redirect(route('forwardReasons.index'))->with($notification);
        }

        $forwardReason = $this->forwardReasonRepository->update($request->all(), $id);

        $entry['t_name'] = "ForwardReason";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Updated";
        activity::create($entry);
        $notification = array(
            'message' => 'Forward Reason updated successfully',
            'alert-type' => 'success'
        );

        return redirect(route('forwardReasons.index'))->with($notification);
    }

    /**
     * Remove the specified Forward_Reason from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $forwardReason = $this->forwardReasonRepository->find($id);

        if (empty($forwardReason)) {
            $notification = array(
                'message' => 'Forward Reason Not Found',
                'alert-type' => 'success'
            );
            return redirect(route('forwardReasons.index'))->with($notification);
        }

//        $this->forwardReasonRepository->delete($id);

        Forward_Reason::where('id',$id)->update(['is_deleted'=>1]);

        $entry['t_name'] = "ForwardReason";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Deleted";
        activity::create($entry);
        $notification = array(
            'message' => 'Forward Reason deleted successfully',
            'alert-type' => 'success'
        );

        return redirect(route('forwardReasons.index'))->with($notification);
    }
}
