<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\Createproducts_modelAPIRequest;
use App\Http\Requests\API\Updateproducts_modelAPIRequest;
use App\Models\products_model;
use App\Repositories\products_modelRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class products_modelController
 * @package App\Http\Controllers\API
 */

class products_modelAPIController extends AppBaseController
{
    /** @var  products_modelRepository */
    private $productsModelRepository;

    public function __construct(products_modelRepository $productsModelRepo)
    {
        $this->productsModelRepository = $productsModelRepo;
    }

    /**
     * Display a listing of the products_model.
     * GET|HEAD /productsModels
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $productsModels = $this->productsModelRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($productsModels->toArray(), 'Products Models retrieved successfully');
    }

    /**
     * Store a newly created products_model in storage.
     * POST /productsModels
     *
     * @param Createproducts_modelAPIRequest $request
     *
     * @return Response
     */
    public function store(Createproducts_modelAPIRequest $request)
    {
        $input = $request->all();

        $productsModel = $this->productsModelRepository->create($input);

        return $this->sendResponse($productsModel->toArray(), 'Products Model saved successfully');
    }

    /**
     * Display the specified products_model.
     * GET|HEAD /productsModels/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var products_model $productsModel */
        $productsModel = $this->productsModelRepository->find($id);

        if (empty($productsModel)) {
            return $this->sendError('Products Model not found');
        }

        return $this->sendResponse($productsModel->toArray(), 'Products Model retrieved successfully');
    }

    /**
     * Update the specified products_model in storage.
     * PUT/PATCH /productsModels/{id}
     *
     * @param int $id
     * @param Updateproducts_modelAPIRequest $request
     *
     * @return Response
     */
    public function update($id, Updateproducts_modelAPIRequest $request)
    {
        $input = $request->all();

        /** @var products_model $productsModel */
        $productsModel = $this->productsModelRepository->find($id);

        if (empty($productsModel)) {
            return $this->sendError('Products Model not found');
        }

        $productsModel = $this->productsModelRepository->update($input, $id);

        return $this->sendResponse($productsModel->toArray(), 'products_model updated successfully');
    }

    /**
     * Remove the specified products_model from storage.
     * DELETE /productsModels/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var products_model $productsModel */
        $productsModel = $this->productsModelRepository->find($id);

        if (empty($productsModel)) {
            return $this->sendError('Products Model not found');
        }

        $productsModel->delete();

        return $this->sendSuccess('Products Model deleted successfully');
    }

    public function getModels(){
        $parts = products_model::where('is_deleted',0)->select('id','title')->get();
        if(count($parts) > 0){
            $data['data'] = $parts;//for success true
            $data['success'] = true;//for success true
            $data['code'] = 200;//for success code 200
            $data['message'] = 'Models found';//for success message
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
