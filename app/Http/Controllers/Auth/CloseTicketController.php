<?php

namespace App\Http\Controllers;

use App\DataTables\CloseTicketDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateCloseTicketRequest;
use App\Http\Requests\UpdateCloseTicketRequest;
use App\Repositories\CloseTicketRepository;
use App\Http\Controllers\AppBaseController;
use Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Response;

class CloseTicketController extends AppBaseController
{
    /** @var  CloseTicketRepository */
    private $closeTicketRepository;

    public function __construct(CloseTicketRepository $closeTicketRepo)
    {
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

        Flash::success('Close Ticket saved successfully.');

        return redirect(route('closeTickets.index'));
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
            Flash::error('Close Ticket not found');

            return redirect(route('closeTickets.index'));
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
            Flash::error('Close Ticket not found');

            return redirect(route('closeTickets.index'));
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
            Flash::error('Close Ticket not found');

            return redirect(route('closeTickets.index'));
        }

        $closeTicket = $this->closeTicketRepository->update($request->all(), $id);

        Flash::success('Close Ticket updated successfully.');

        return redirect(route('closeTickets.index'));
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
            Flash::error('Close Ticket not found');

            return redirect(route('closeTickets.index'));
        }

        $this->closeTicketRepository->delete($id);

        Flash::success('Close Ticket deleted successfully.');

        return redirect(route('closeTickets.index'));
    }
}
