<?php

namespace App\Http\Controllers;

use App\DataTables\Technician_AssistDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateTechnician_AssistRequest;
use App\Http\Requests\UpdateTechnician_AssistRequest;
use App\Repositories\Technician_AssistRepository;
use App\Http\Controllers\AppBaseController;
use Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Response;
use App\Models\Technician_Assist;
use App\Models\activity;

class Technician_AssistController extends AppBaseController
{
    /** @var  Technician_AssistRepository */
    private $technicianAssistRepository;

    public function __construct(Technician_AssistRepository $technicianAssistRepo)
    {
        $this->middleware('auth');
        $this->technicianAssistRepository = $technicianAssistRepo;
    }

    /**
     * Display a listing of the Technician_Assist.
     *
     * @param Technician_AssistDataTable $technicianAssistDataTable
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function index(Technician_AssistDataTable $technicianAssistDataTable)
    {
        return $technicianAssistDataTable->render('technicianAssist.index');
    }

    /**
     * Show the form for creating a new Technician_Assist.
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function create()
    {
        return view('technicianAssist.create');
    }

    /**
     * Store a newly created Technician_Assist in storage.
     *
     * @param CreateTechnician_AssistRequest $request
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function store(CreateTechnician_AssistRequest $request)
    {
        $input = $request->except('PDF');

        if($request->file('PDF')) {
            $file = $request->file('PDF');
            $filename = time() . '.' . $request->file('PDF')->extension();
            $input['PDF'] = $filename;
            $filePath = public_path('/technician_assist');
            $file->move($filePath, $filename);
        }
        $technicianAssist = $this->technicianAssistRepository->create($input);

        $entry['t_name'] = "TechnicianAssist";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Inserted";
        activity::create($entry);
        $notification = array(
            'message' => 'Technician Assist saved successfully',
            'alert-type' => 'success'
        );
        return redirect(route('technicianAssists.index'))->with($notification);
    }

    /**
     * Display the specified Technician_Assist.
     *
     * @param  int $id
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function show($id)
    {
        $technicianAssist = $this->technicianAssistRepository->find($id);

        if (empty($technicianAssist)) {
            $notification = array(
                'message' => 'Technician  Assist not found',
                'alert-type' => 'error'
            );
            return redirect(route('technicianAssists.index'))->with($notification);
        }

        return view('technicianAssist.show')->with('technicianAssist', $technicianAssist);
    }

    /**
     * Show the form for editing the specified Technician_Assist.
     *
     * @param  int $id
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function edit($id)
    {
        $technicianAssist = $this->technicianAssistRepository->find($id);

        if (empty($technicianAssist)) {
            $notification = array(
                'message' => 'Technician  Assist not found',
                'alert-type' => 'error'
            );
            return redirect(route('technicianAssists.index'))->with($notification);
        }

        return view('technicianAssist.edit')->with('technicianAssist', $technicianAssist);
    }

    /**
     * Update the specified Technician_Assist in storage.
     *
     * @param  int              $id
     * @param UpdateTechnician_AssistRequest $request
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function update($id, UpdateTechnician_AssistRequest $request)
    {
        $input = $request->except('PDF');
        if($request->file('PDF')) {
            $file = $request->file('PDF');
            $filename = time() . '.' . $request->file('PDF')->extension();
            $input['PDF'] = $filename;
            $filePath = public_path('/technician_assist');
            $file->move($filePath, $filename);
        }
        $technicianAssist = $this->technicianAssistRepository->find($id);
        if (empty($technicianAssist)) {
            $notification = array(
                'message' => 'Technician  Assist not found',
                'alert-type' => 'error'
            );
            return redirect(route('technicianAssists.index'))->with($notification);
        }

        $technicianAssist = $this->technicianAssistRepository->update($input, $id);

        $entry['t_name'] = "TechnicianAssist";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Updated";
        activity::create($entry);
        $notification = array(
            'message' => 'Technician  Assist updated successfully.',
            'alert-type' => 'success'
        );
        return redirect(route('technicianAssists.index'))->with($notification);
    }

    public function destroy($id)
    {
        $technicianAssist = $this->technicianAssistRepository->find($id);

        if (empty($technicianAssist)) {
            $notification = array(
                'message' => 'Technician  Assist not found',
                'alert-type' => 'error'
            );
            return redirect(route('technicianAssists.index'))->with($notification);
        }

//        $this->technicianAssistRepository->delete($id);
        Technician_Assist::where('id',$id)->update(['is_deleted'=>1]);

        $entry['t_name'] = "TechnicianAssist";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Deleted";
        activity::create($entry);
        $notification = array(
            'message' => 'Technician  Assist deleted successfully.',
            'alert-type' => 'success'
        );
        return redirect(route('technicianAssists.index'))->with($notification);    }
}
