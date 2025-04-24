<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAnnouncementAPIRequest;
use App\Http\Requests\API\UpdateAnnouncementAPIRequest;
use App\Models\Announcement;
use App\Repositories\AnnouncementRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class AnnouncementController
 * @package App\Http\Controllers\API
 */

class AnnouncementAPIController extends AppBaseController
{
    /** @var  AnnouncementRepository */
    private $announcementRepository;

    public function __construct(AnnouncementRepository $announcementRepo)
    {
        $this->announcementRepository = $announcementRepo;
    }

    /**
     * Display a listing of the Announcement.
     * GET|HEAD /announcements
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $announcements = $this->announcementRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($announcements->toArray(), 'Announcements retrieved successfully');
    }

    /**
     * Store a newly created Announcement in storage.
     * POST /announcements
     *
     * @param CreateAnnouncementAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateAnnouncementAPIRequest $request)
    {
        $input = $request->all();

        $announcement = $this->announcementRepository->create($input);

        return $this->sendResponse($announcement->toArray(), 'Announcement saved successfully');
    }

    /**
     * Display the specified Announcement.
     * GET|HEAD /announcements/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Announcement $announcement */
        $announcement = $this->announcementRepository->find($id);

        if (empty($announcement)) {
            return $this->sendError('Announcement not found');
        }

        return $this->sendResponse($announcement->toArray(), 'Announcement retrieved successfully');
    }

    /**
     * Update the specified Announcement in storage.
     * PUT/PATCH /announcements/{id}
     *
     * @param int $id
     * @param UpdateAnnouncementAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAnnouncementAPIRequest $request)
    {
        $input = $request->all();

        /** @var Announcement $announcement */
        $announcement = $this->announcementRepository->find($id);

        if (empty($announcement)) {
            return $this->sendError('Announcement not found');
        }

        $announcement = $this->announcementRepository->update($input, $id);

        return $this->sendResponse($announcement->toArray(), 'Announcement updated successfully');
    }

    /**
     * Remove the specified Announcement from storage.
     * DELETE /announcements/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Announcement $announcement */
        $announcement = $this->announcementRepository->find($id);

        if (empty($announcement)) {
            return $this->sendError('Announcement not found');
        }

        $announcement->delete();

        return $this->sendSuccess('Announcement deleted successfully');
    }
}
