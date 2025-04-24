<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCloseTicketAPIRequest;
use App\Http\Requests\API\UpdateCloseTicketAPIRequest;
use App\Models\CloseTicket;
use App\Repositories\CloseTicketRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class CloseTicketController
 * @package App\Http\Controllers\API
 */

class CloseTicketAPIController extends AppBaseController
{
    /** @var  CloseTicketRepository */
    private $closeTicketRepository;

    public function __construct(CloseTicketRepository $closeTicketRepo)
    {
        $this->closeTicketRepository = $closeTicketRepo;
    }

    /**
     * Display a listing of the CloseTicket.
     * GET|HEAD /closeTickets
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|Response
     */
    public function index(Request $request)
    {
        $closeTickets = $this->closeTicketRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($closeTickets->toArray(), 'Close Tickets retrieved successfully');
    }

    /**
     * Store a newly created CloseTicket in storage.
     * POST /closeTickets
     *
     * @param CreateCloseTicketAPIRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|Response
     */
    public function store(CreateCloseTicketAPIRequest $request)
    {
        $input = $request->all();

        $closeTicket = $this->closeTicketRepository->create($input);

        return $this->sendResponse($closeTicket->toArray(), 'Close Ticket saved successfully');
    }

    /**
     * Display the specified CloseTicket.
     * GET|HEAD /closeTickets/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse|Response
     */
    public function show($id)
    {
        /** @var CloseTicket $closeTicket */
        $closeTicket = $this->closeTicketRepository->find($id);

        if (empty($closeTicket)) {
            return $this->sendError('Close Ticket not found');
        }

        return $this->sendResponse($closeTicket->toArray(), 'Close Ticket retrieved successfully');
    }

    /**
     * Update the specified CloseTicket in storage.
     * PUT/PATCH /closeTickets/{id}
     *
     * @param int $id
     * @param UpdateCloseTicketAPIRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|Response
     */
    public function update($id, UpdateCloseTicketAPIRequest $request)
    {
        $input = $request->all();

        /** @var CloseTicket $closeTicket */
        $closeTicket = $this->closeTicketRepository->find($id);

        if (empty($closeTicket)) {
            return $this->sendError('Close Ticket not found');
        }

        $closeTicket = $this->closeTicketRepository->update($input, $id);

        return $this->sendResponse($closeTicket->toArray(), 'CloseTicket updated successfully');
    }

    /**
     * Remove the specified CloseTicket from storage.
     * DELETE /closeTickets/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\JsonResponse|Response
     */
    public function destroy($id)
    {
        /** @var CloseTicket $closeTicket */
        $closeTicket = $this->closeTicketRepository->find($id);

        if (empty($closeTicket)) {
            return $this->sendError('Close Ticket not found');
        }

        $closeTicket->delete();

        return $this->sendSuccess('Close Ticket deleted successfully');
    }
}
