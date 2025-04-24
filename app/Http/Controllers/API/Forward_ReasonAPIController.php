<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateForward_ReasonAPIRequest;
use App\Http\Requests\API\UpdateForward_ReasonAPIRequest;
use App\Models\Forward_Reason;
use App\Repositories\Forward_ReasonRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class Forward_ReasonController
 * @package App\Http\Controllers\API
 */

class Forward_ReasonAPIController extends AppBaseController
{
    /** @var  Forward_ReasonRepository */
    private $forwardReasonRepository;

    public function __construct(Forward_ReasonRepository $forwardReasonRepo)
    {
        $this->forwardReasonRepository = $forwardReasonRepo;
    }

    /**
     * Display a listing of the Forward_Reason.
     * GET|HEAD /forwardReasons
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $forwardReasons = $this->forwardReasonRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($forwardReasons->toArray(), 'Forward  Reasons retrieved successfully');
    }

    /**
     * Store a newly created Forward_Reason in storage.
     * POST /forwardReasons
     *
     * @param CreateForward_ReasonAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateForward_ReasonAPIRequest $request)
    {
        $input = $request->all();

        $forwardReason = $this->forwardReasonRepository->create($input);

        return $this->sendResponse($forwardReason->toArray(), 'Forward  Reason saved successfully');
    }

    /**
     * Display the specified Forward_Reason.
     * GET|HEAD /forwardReasons/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Forward_Reason $forwardReason */
        $forwardReason = $this->forwardReasonRepository->find($id);

        if (empty($forwardReason)) {
            return $this->sendError('Forward  Reason not found');
        }

        return $this->sendResponse($forwardReason->toArray(), 'Forward  Reason retrieved successfully');
    }

    /**
     * Update the specified Forward_Reason in storage.
     * PUT/PATCH /forwardReasons/{id}
     *
     * @param int $id
     * @param UpdateForward_ReasonAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateForward_ReasonAPIRequest $request)
    {
        $input = $request->all();

        /** @var Forward_Reason $forwardReason */
        $forwardReason = $this->forwardReasonRepository->find($id);

        if (empty($forwardReason)) {
            return $this->sendError('Forward  Reason not found');
        }

        $forwardReason = $this->forwardReasonRepository->update($input, $id);

        return $this->sendResponse($forwardReason->toArray(), 'Forward_Reason updated successfully');
    }

    /**
     * Remove the specified Forward_Reason from storage.
     * DELETE /forwardReasons/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Forward_Reason $forwardReason */
        $forwardReason = $this->forwardReasonRepository->find($id);

        if (empty($forwardReason)) {
            return $this->sendError('Forward  Reason not found');
        }

        $forwardReason->delete();

        return $this->sendSuccess('Forward  Reason deleted successfully');
    }



    public function forwardReason(){

        $forward_reason = Forward_Reason::where('is_deleted',0)->select('id','title')->get();
        if(count($forward_reason) > 0){
            $data['data'] = $forward_reason;//for success true
            $data['success'] = true;//for success true
            $data['code'] = 200;//for success code 200
            $data['message'] = 'Forward Reasons are found';//for success message
        }
        else{
            $data['data'] = 'No Data';//for success true
            $data['error'] = false;//for success true
            $data['code'] = 500;//for success code 200
            $data['message'] = 'Not Found';//for success message
        }
        return $data;
    }




}
