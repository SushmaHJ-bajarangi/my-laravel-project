<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateproblemsAPIRequest;
use App\Http\Requests\API\UpdateproblemsAPIRequest;
use App\Models\problems;
use App\Repositories\problemsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class problemsController
 * @package App\Http\Controllers\API
 */

class problemsAPIController extends AppBaseController
{
    /** @var  problemsRepository */
    private $problemsRepository;

    public function __construct(problemsRepository $problemsRepo)
    {
        $this->problemsRepository = $problemsRepo;
    }

    /**
     * Display a listing of the problems.
     * GET|HEAD /problems
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|Response
     */
    public function index(Request $request)
    {
        $problems = $this->problemsRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($problems->toArray(), 'Problems retrieved successfully');
    }

    /**
     * Store a newly created problems in storage.
     * POST /problems
     *
     * @param CreateproblemsAPIRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|Response
     */
    public function store(CreateproblemsAPIRequest $request)
    {
        $input = $request->all();

        $problems = $this->problemsRepository->create($input);

        return $this->sendResponse($problems->toArray(), 'Problems saved successfully');
    }

    /**
     * Display the specified problems.
     * GET|HEAD /problems/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse|Response
     */
    public function show($id)
    {
        /** @var problems $problems */
        $problems = $this->problemsRepository->find($id);

        if (empty($problems)) {
            return $this->sendError('Problems not found');
        }

        return $this->sendResponse($problems->toArray(), 'Problems retrieved successfully');
    }

    /**
     * Update the specified problems in storage.
     * PUT/PATCH /problems/{id}
     *
     * @param int $id
     * @param UpdateproblemsAPIRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|Response
     */
    public function update($id, UpdateproblemsAPIRequest $request)
    {
        $input = $request->all();

        /** @var problems $problems */
        $problems = $this->problemsRepository->find($id);

        if (empty($problems)) {
            return $this->sendError('Problems not found');
        }

        $problems = $this->problemsRepository->update($input, $id);

        return $this->sendResponse($problems->toArray(), 'problems updated successfully');
    }

    /**
     * Remove the specified problems from storage.
     * DELETE /problems/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\JsonResponse|Response
     */
    public function destroy($id)
    {
        /** @var problems $problems */
        $problems = $this->problemsRepository->find($id);

        if (empty($problems)) {
            return $this->sendError('Problems not found');
        }

        $problems->delete();

        return $this->sendSuccess('Problems deleted successfully');
    }

    public function commonIssues(){
        $problems = problems::where('is_deleted',0)->get()->pluck('title');
        if(count($problems) > 0){
            $data['success'] = true;//for success true
            $data['data'] = $problems;//for success true
            $data['code'] = 200;//for success code 200
            $data['message'] = 'Issues Found';//for error message
        }
        else{
            $data['data'] = 'No Data';
            $data['error'] = false;
            $data['code'] = 500;
            $data['message'] = 'Issues Not Found';//for error message
        }
        return $data;

    }
}
