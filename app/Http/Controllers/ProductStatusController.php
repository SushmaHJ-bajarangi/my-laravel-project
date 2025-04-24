<?php

namespace App\Http\Controllers;
use App\DataTables\ProductStatusDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateProductStatusRequest;
use App\Http\Requests\UpdateProductStatusRequest;
use App\Repositories\ProductStatusRepository;
use App\Http\Controllers\AppBaseController;
use Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Response;
use App\Models\ProductStatus;
use App\Models\activity;

class ProductStatusController extends AppBaseController
{
    /** @var  ProductStatusRepository */
    private $productStatusRepository;

    public function __construct(ProductStatusRepository $productStatusRepo)
    {
        $this->middleware('auth');
        $this->productStatusRepository = $productStatusRepo;
    }

    /**
     * Display a listing of the ProductStatus.
     *
     * @param ProductStatusDataTable $productStatusDataTable
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function index(ProductStatusDataTable $productStatusDataTable)
    {
        return $productStatusDataTable->render('product_statuses.index');
    }

    /**
     * Show the form for creating a new ProductStatus.
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function create()
    {
        return view('product_statuses.create');
    }

    /**
     * Store a newly created ProductStatus in storage.
     *
     * @param CreateProductStatusRequest $request
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function store(CreateProductStatusRequest $request)
    {
        $input = $request->all();

        $productStatus = $this->productStatusRepository->create($input);
        $entry['t_name'] = "ProductStatus";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Inserted";
        activity::create($entry);
        $notification = array(
            'message' => 'Product Status saved successfully',
            'alert-type' => 'success'
        );
        return redirect(route('productStatuses.index'))->with($notification);
    }

    /**
     * Display the specified ProductStatus.
     *
     * @param  int $id
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function show($id)
    {
        $productStatus = $this->productStatusRepository->find($id);

        if (empty($productStatus)) {
            $notification = array(
                'message' => 'Product Status not found',
                'alert-type' => 'error'
            );
            return redirect(route('productStatuses.index'))->with($notification);
        }

        return view('product_statuses.show')->with('productStatus', $productStatus);
    }

    /**
     * Show the form for editing the specified ProductStatus.
     *
     * @param  int $id
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function edit($id)
    {
        $productStatus = $this->productStatusRepository->find($id);

        if (empty($productStatus)) {
            $notification = array(
                'message' => 'Product Status not found',
                'alert-type' => 'error'
            );
            return redirect(route('productStatuses.index'))->with($notification);
        }

        return view('product_statuses.edit')->with('productStatus', $productStatus);
    }

    /**
     * Update the specified ProductStatus in storage.
     *
     * @param  int              $id
     * @param UpdateProductStatusRequest $request
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function update($id, UpdateProductStatusRequest $request)
    {
        $productStatus = $this->productStatusRepository->find($id);

        if (empty($productStatus)) {
            $notification = array(
                'message' => 'Product Status not found',
                'alert-type' => 'error'
            );
            return redirect(route('productStatuses.index'))->with($notification);
        }

        $productStatus = $this->productStatusRepository->update($request->all(), $id);

        $entry['t_name'] = "ProductStatus";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Inserted";
        activity::create($entry);
        $notification = array(
            'message' => 'Product Status updated successfully',
            'alert-type' => 'success'
        );

        return redirect(route('productStatuses.index'))->with($notification);
    }

    /**
     * Remove the specified ProductStatus from storage.
     *
     * @param  int $id
     *
     * @return Response|Factory|RedirectResponse|Redirector|View
     */
    public function destroy($id)
    {
        $productStatus = $this->productStatusRepository->find($id);

        if (empty($productStatus)) {
            $notification = array(
                'message' => 'Product Status not found',
                'alert-type' => 'error'
            );
            return redirect(route('productStatuses.index'))->with($notification);
        }

//        $this->productStatusRepository->delete($id);
        ProductStatus::where('id',$id)->update(['is_deleted'=>1]);

        $entry['t_name'] = "ProductStatus";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Deleted";
        activity::create($entry);
        $notification = array(
            'message' => 'Product Status deleted successfully',
            'alert-type' => 'success'
        );
        return redirect(route('productStatuses.index'))->with($notification);
    }
}
