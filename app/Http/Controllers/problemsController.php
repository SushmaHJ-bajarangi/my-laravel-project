<?php

namespace App\Http\Controllers;

use App\DataTables\problemsDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateproblemsRequest;
use App\Http\Requests\UpdateproblemsRequest;
use App\Models\problems;
use App\Models\activity;
use App\Repositories\problemsRepository;
use App\Http\Controllers\AppBaseController;
use Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Response;

class problemsController extends AppBaseController
{
    /** @var  problemsRepository */
    private $problemsRepository;

    public function __construct(problemsRepository $problemsRepo)
    {
        $this->middleware('auth');
        $this->problemsRepository = $problemsRepo;
    }

    /**
     * Display a listing of the problems.
     *
     * @param problemsDataTable $problemsDataTable
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function index(problemsDataTable $problemsDataTable)
    {
        return $problemsDataTable->render('problems.index');
    }

    /**
     * Show the form for creating a new problems.
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function create()
    {
        return view('problems.create');
    }

    /**
     * Store a newly created problems in storage.
     *
     * @param CreateproblemsRequest $request
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function store(CreateproblemsRequest $request)
    {
        $input = $request->all();

        $problems = $this->problemsRepository->create($input);

        $entry['t_name'] = "Problems";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Inserted";
        activity::create($entry);
        $notification = array(
            'message' => 'Problems saved successfully',
            'alert-type' => 'success'
        );

        return redirect(route('problems.index'))->with($notification);
    }

    /**
     * Display the specified problems.
     *
     * @param  int $id
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function show($id)
    {
        $problems = $this->problemsRepository->find($id);

        if (empty($problems)) {

            $notification = array(
                'message' => 'Problems not found',
                'alert-type' => 'error'
            );
            return redirect(route('problems.index'))->with($notification);
        }

        return view('problems.show')->with('problems', $problems);
    }

    /**
     * Show the form for editing the specified problems.
     *
     * @param  int $id
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function edit($id)
    {
        $problems = $this->problemsRepository->find($id);

        if (empty($problems)) {
            $notification = array(
                'message' => 'Problems not found',
                'alert-type' => 'error'
            );
            return redirect(route('problems.index'))->with($notification);
        }

        return view('problems.edit')->with('problems', $problems);
    }

    /**
     * Update the specified problems in storage.
     *
     * @param  int              $id
     * @param UpdateproblemsRequest $request
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function update($id, UpdateproblemsRequest $request)
    {
        $problems = $this->problemsRepository->find($id);

        if (empty($problems)) {
            $notification = array(
                'message' => 'Problems not found',
                'alert-type' => 'error'
            );
            return redirect(route('problems.index'))->with($notification);
        }

        $problems = $this->problemsRepository->update($request->all(), $id);

        $entry['t_name'] = "Problems";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Updated";
        activity::create($entry);
        $notification = array(
            'message' => 'Problems updated successfully',
            'alert-type' => 'success'
        );
        return redirect(route('problems.index'))->with($notification);
    }

    /**
     * Remove the specified problems from storage.
     *
     * @param  int $id
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function destroy($id)
    {
        $problems = $this->problemsRepository->find($id);

        if (empty($problems)) {
            $notification = array(
                'message' => 'Problems not found',
                'alert-type' => 'error'
            );
            return redirect(route('problems.index'))->with($notification);
        }

//        $this->problemsRepository->delete($id);
        problems::where('id',$id)->update(['is_deleted'=>'1']);

        $entry['t_name'] = "Problems";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Deleted";
        activity::create($entry);
        $notification = array(
            'message' => 'Problems deleted successfully',
            'alert-type' => 'success'
        );
        return redirect(route('problems.index'))->with($notification);
    }
}
