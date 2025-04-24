<?php

namespace App\Http\Controllers;
use App\DataTables\customersDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatecustomersRequest;
use App\Http\Requests\UpdatecustomersRequest;
use App\Models\customers;
use App\Models\activity;
use App\Models\AuthorizedPerson;
use App\Repositories\customersRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;

class CustomerController extends AppBaseController
{
    /** @var  customersRepository */
    private $customersRepository;

    public function __construct(customersRepository $customersRepo)
    {
        $this->middleware('auth');
        $this->customersRepository = $customersRepo;
    }

    /**
     * Display a listing of the customers.
     *
     * @param customersDataTable $customersDataTable
     * @return Response
     */
    public function index(customersDataTable $customersDataTable)
    {
        return $customersDataTable->render('customers.index');
    }

    /**
     * Show the form for creating a new customers.
     *
     * @return Response
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created customers in storage.
     *
     * @param CreatecustomersRequest $request
     *
     * @return Response
     */
    public function store(CreatecustomersRequest $request)
    {
//        $this->validate($request, [
//            'contact_number' => 'unique:customers,contact_number|size:10',
//            'password' => 'min:6'
//        ]);
        $input = $request->all();

        $customers = $this->customersRepository->create($input);

        /*if(!empty($request['authorized_name'])){
            for($i = 0; $i<count($request['authorized_name']); $i++){
                if($request['authorized_name'][$i] != ''){
                    $persons = [];
                    $persons['customer_id'] = $customers->id;
                    $persons['name'] = $request['authorized_name'][$i];
                    $persons['contact_number'] = $request['authorized_contact_number'][$i];
                    AuthorizedPerson::create($persons);
                }
            }
        }*/

        $entry['t_name'] = "Customer";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Inserted";
        activity::create($entry);
        $notification = array(
            'message' => 'Customers saved successfully',
            'alert-type' => 'success'
        );
        return redirect(route('customers.index'))->with($notification);
    }

    /**
     * Display the specified customers.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $customers = $this->customersRepository->find($id);

        if (empty($customers)) {
            $notification = array(
                'message' => 'Customers not found',
                'alert-type' => 'error'
            );
            return redirect(route('customers.index'))->with($notification);
        }

        $persons = AuthorizedPerson::where('customer_id',$id)->where('is_deleted','0')->get();
        return view('customers.show',compact('persons'))->with('customers', $customers);
    }

    /**
     * Show the form for editing the specified customers.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $customers = $this->customersRepository->find($id);

        if (empty($customers)) {
            $notification = array(
                'message' => 'Customers not found',
                'alert-type' => 'error'
            );
            return redirect(route('customers.index'))->with($notification);
        }

        $persons = AuthorizedPerson::where('customer_id',$id)->where('is_deleted','0')->get();
        return view('customers.edit',compact('persons'))->with('customers', $customers);
    }

    /**
     * Update the specified customers in storage.
     *
     * @param  int $id
     * @param UpdatecustomersRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatecustomersRequest $request)
    {
//        $this->validate($request, [
//            'contact_number' => 'size:10|unique:customers,contact_number,'.$id,
//            'password' => 'min:6'
//        ]);
        $customers = $this->customersRepository->find($id);

        if (empty($customers)) {
            $notification = array(
                'message' => 'Customers not found',
                'alert-type' => 'error'
            );

            return redirect(route('customers.index'))->with($notification);
        }

        $customers = $this->customersRepository->update($request->all(), $id);

        /*if(!empty($request['authorized_name'])){
            for($i = 0; $i<count($request['authorized_name']); $i++){
                if($request['authorized_name'][$i] != '') {
                    $helpers = [];
                    $helpers['customer_id'] = $customers->id;
                    $helpers['name'] = $request['authorized_name'][$i];
                    $helpers['contact_number'] = $request['authorized_contact_number'][$i];
                    if (isset($request['authorized_id'][$i])) {
                        if (AuthorizedPerson::where('id', $request['authorized_id'][$i])->exists()) {
                            AuthorizedPerson::where('id', $request['authorized_id'][$i])->update($helpers);
                        } else {
                            AuthorizedPerson::create($helpers);
                        }
                    } else {
                        AuthorizedPerson::create($helpers);
                    }
                }
            }
        }*/
        $entry['t_name'] = "Customer";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Updated";
        activity::create($entry);
        $notification = array(
            'message' => 'Customers updated successfully',
            'alert-type' => 'success'
        );
        return redirect(route('customers.index'))->with($notification);
    }

    /**
     * Remove the specified customers from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $customers = $this->customersRepository->find($id);

        if (empty($customers)) {
            $notification = array(
                'message' => 'Customers not found',
                'alert-type' => 'error'
            );

            return redirect(route('customers.index'))->with($notification);
        }

//      $this->customersRepository->delete($id);
        customers::where('id',$id)->update(['is_deleted'=>'1']);
        AuthorizedPerson::where('customer_id',$id)->update(['is_deleted'=>'1']);

        $entry['t_name'] = "Customer";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Deleted";
        activity::create($entry);
        $notification = array(
            'message' => 'Customers deleted successfully',
            'alert-type' => 'success'
        );

        return redirect(route('customers.index'))->with($notification);
    }

    public function checkCustomerNumber(Request $request){
        if(customers::whereIn('contact_number',$request->contact_number)->where('id','!=',$request->customer_id)->where('is_deleted',0)->exists()){
            $customer_numbers = customers::whereIn('contact_number',$request->contact_number)->where('is_deleted',0)->where('id','!=',$request->customer_id)->pluck('contact_number');
            $data['numbers'] = $customer_numbers;
            $data['response'] = 'number_exists';
            return $data;
        }
        else{
            return 'number_not_exists';
        }
    }

    public function removePerson(Request $request){
        AuthorizedPerson::where('id',$request->id)->update(['is_deleted'=>'1']);
        return 'success';
    }
}
