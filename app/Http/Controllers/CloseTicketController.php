<?php

namespace App\Http\Controllers;

use App\DataTables\CloseTicketDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateCloseTicketRequest;
use App\Http\Requests\UpdateCloseTicketRequest;
use App\Repositories\CloseTicketRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\activity;
use App\Models\CloseTicket;
use Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Response;

class CloseTicketController extends AppBaseController
{
    /** @var  CloseTicketRepository */
    private $closeTicketRepository;

    public function __construct(CloseTicketRepository $closeTicketRepo)
    {
        $this->middleware('auth');
        $this->closeTicketRepository = $closeTicketRepo;
    }

    /**
     * Display a listing of the CloseTicket.
     *
     * @param CloseTicketDataTable $closeTicketDataTable
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function index(CloseTicketDataTable $closeTicketDataTable)
    {
        return $closeTicketDataTable->render('close_tickets.index');
    }

    /**
     * Show the form for creating a new CloseTicket.
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function create()
    {
        return view('close_tickets.create');
    }

    /**
     * Store a newly created CloseTicket in storage.
     *
     * @param CreateCloseTicketRequest $request
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function store(CreateCloseTicketRequest $request)
    {
        $input = $request->all();

        $closeTicket = $this->closeTicketRepository->create($input);
        $notification = array(
            'message' => 'Close Ticket saved successfully',
            'alert-type' => 'success'
        );


        $entry['t_name'] = "CloseTicket";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Inserted";
        activity::create($entry);
        return redirect(route('closeTickets.index'))->with($notification);
    }

    /**
     * Display the specified CloseTicket.
     *
     * @param  int $id
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function show($id)
    {
        $closeTicket = $this->closeTicketRepository->find($id);

        if (empty($closeTicket)) {
            $notification = array(
                'message' => 'Close Ticket not found',
                'alert-type' => 'error'
            );

            return redirect(route('closeTickets.index'))->with($notification);
        }

        return view('close_tickets.show')->with('closeTicket', $closeTicket);
    }

    /**
     * Show the form for editing the specified CloseTicket.
     *
     * @param  int $id
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function edit($id)
    {
        $closeTicket = $this->closeTicketRepository->find($id);

        if (empty($closeTicket)) {
            $notification = array(
                'message' => 'Close Ticket not found',
                'alert-type' => 'error'
            );

            return redirect(route('closeTickets.index'))->with($notification);
        }

        return view('close_tickets.edit')->with('closeTicket', $closeTicket);
    }

    /**
     * Update the specified CloseTicket in storage.
     *
     * @param  int              $id
     * @param UpdateCloseTicketRequest $request
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function update($id, UpdateCloseTicketRequest $request)
    {
        $closeTicket = $this->closeTicketRepository->find($id);

        if (empty($closeTicket)) {
            $notification = array(
                'message' => 'Close Ticket not found',
                'alert-type' => 'error'
            );

            return redirect(route('closeTickets.index'))->with($notification);
        }

        $closeTicket = $this->closeTicketRepository->update($request->all(), $id);
        $notification = array(
            'message' => 'Close Ticket updated successfully',
            'alert-type' => 'success'
        );

        $entry['t_name'] = "CloseTicket";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Updated";
        activity::create($entry);
        return redirect(route('closeTickets.index'))->with($notification);
    }

    /**
     * Remove the specified CloseTicket from storage.
     *
     * @param  int $id
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function destroy($id)
    {
        $closeTicket = $this->closeTicketRepository->find($id);

        if (empty($closeTicket)) {
            $notification = array(
                'message' => 'Close Ticket not found',
                'alert-type' => 'error'
            );

            return redirect(route('closeTickets.index'))->with($notification);
        }

//        $this->closeTicketRepository->delete($id);

        CloseTicket::where('id',$id)->update(['is_deleted'=>1]);
        $notification = array(
            'message' => 'Close Ticket deleted successfully',
            'alert-type' => 'success'
        );

        $entry['t_name'] = "CloseTicket";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Deleted";
        activity::create($entry);
        return redirect(route('closeTickets.index'))->with($notification);
    }
}
