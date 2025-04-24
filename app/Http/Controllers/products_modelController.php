<?php

namespace App\Http\Controllers;

use App\DataTables\products_modelDataTable;
use App\Http\Requests;
use App\Http\Requests\Createproducts_modelRequest;
use App\Http\Requests\Updateproducts_modelRequest;
use App\Models\products_model;
use App\Models\activity;
use App\Repositories\products_modelRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Response;

class products_modelController extends AppBaseController
{
    /** @var  products_modelRepository */
    private $productsModelRepository;

    public function __construct(products_modelRepository $productsModelRepo)
    {
        $this->middleware('auth');
        $this->productsModelRepository = $productsModelRepo;
    }

    /**
     * Display a listing of the products_model.
     *
     * @param products_modelDataTable $productsModelDataTable
     * @return Response
     */
    public function index(products_modelDataTable $productsModelDataTable)
    {
        return $productsModelDataTable->render('products_models.index');
    }

    /**
     * Show the form for creating a new products_model.
     *
     * @return Response
     */
    public function create()
    {
        return view('products_models.create');
    }

    /**
     * Store a newly created products_model in storage.
     *
     * @param Createproducts_modelRequest $request
     *
     * @return Response
     */
    public function store(Createproducts_modelRequest $request)
    {
        $input = $request->all();

        $productsModel = $this->productsModelRepository->create($input);

        $entry['t_name'] = "ProductsModal";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Inserted";
        activity::create($entry);
        $notification = array(
            'message' => 'Products Model saved successfully',
            'alert-type' => 'success'
        );
        return redirect(route('productsModels.index'))->with($notification);
    }

    /**
     * Display the specified products_model.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $productsModel = $this->productsModelRepository->find($id);

        if (empty($productsModel)) {
            $notification = array(
                'message' => 'Products Model not found',
                'alert-type' => 'error'
            );
            return redirect(route('productsModels.index'))->with($notification);
        }

        return view('products_models.show')->with('productsModel', $productsModel);
    }

    /**
     * Show the form for editing the specified products_model.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $productsModel = $this->productsModelRepository->find($id);

        if (empty($productsModel)) {
            $notification = array(
                'message' => 'Products Model not found',
                'alert-type' => 'error'
            );

            return redirect(route('productsModels.index'))->with($notification);
        }

        return view('products_models.edit')->with('productsModel', $productsModel);
    }

    /**
     * Update the specified products_model in storage.
     *
     * @param  int              $id
     * @param Updateproducts_modelRequest $request
     *
     * @return Response
     */
    public function update($id, Updateproducts_modelRequest $request)
    {
        $productsModel = $this->productsModelRepository->find($id);

        if (empty($productsModel)) {
            $notification = array(
                'message' => 'Products Model not found',
                'alert-type' => 'error'
            );
            return redirect(route('productsModels.index'))->with($notification);
        }

        $productsModel = $this->productsModelRepository->update($request->all(), $id);

        $entry['t_name'] = "ProductsModal";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Updated";
        activity::create($entry);
        $notification = array(
            'message' => 'Products Model updated successfully',
            'alert-type' => 'success'
        );
        return redirect(route('productsModels.index'))->with($notification);
    }

    /**
     * Remove the specified products_model from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $productsModel = $this->productsModelRepository->find($id);

        if (empty($productsModel)) {

            $notification = array(
                'message' => 'Products Model not found',
                'alert-type' => 'error'
            );
            return redirect(route('productsModels.index'))->with($notification);
        }

//        $this->productsModelRepository->delete($id);
        products_model::where('id',$id)->update(['is_deleted'=>1]);

        $entry['t_name'] = "ProductsModal";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Deleted";
        activity::create($entry);
        $notification = array(
            'message' => 'Products Model deleted successfully',
            'alert-type' => 'success'
        );
        return redirect(route('productsModels.index'))->with($notification);
    }


}
