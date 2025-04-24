<?php

namespace App\Http\Controllers;
use App\Http\Controllers\AppBaseController;
use App\Models\partDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Response;
use App\DataTables\teamDataTable;
use App\Models\PartsRequest;
use Flash;
use DataTables;
use App\Models\parts;
use App\Models\team;
use App\Models\RaiseTickets;
use App\Models\customers;
use App\Models\customer_products;
use App\Models\problems;
use App\Models\activity;
use Yajra\DataTables\Html\Editor\Fields\Radio;

class RequestController extends AppBaseController
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $parts_request = PartsRequest::get();
        return view('Parts_request.index',compact('parts_request'));
    }

    public function getParts(Request $request)
    {
        if($request->ajax()) {
                $data = DB::table('parts_request')
                ->select('parts_request.id', 'parts_request.unique_job_number', 'parts_request.customer_id','parts_request.technician_user_id','parts_request.parts_id','parts_request.final_price','parts_request.payment_method',
                    'parts_request.amt','parts_request.payment_id',
                    'parts_request.ticket_id','parts_request.payment_type','parts_request.date','parts_request.status','parts_request.admin_status','parts_request.payment_date')
                ->where('parts_request.is_deleted', '=', '0')->where('admin_status','!=','Paid')
                ->get();
             return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    if (auth()->check()){
                        if (auth()->user()->role == 1){
                            $actionBtn = '';
                            $actionBtn .= '<div class=\'plan-btn-group\'>
                                        <a href="' . url('editPartsRequest/' . $row->id) . '" class="edit btn btn-default btn-xs"> <i class="glyphicon glyphicon-eye-open"></i></a>
                                        <form method="post" action="' . url('deleteParts') . '">
                                             <input type="hidden" name="parts_id" value="' . $row->id . '">  
                                             <input type="hidden" name="_token" value="' . csrf_token() . '">  
                                             <button type="submit" onclick="return confirm(\'Are you suresdsd?\')" class="delete btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></button>
                                        </form>
                                    </div>';
                        }
                        else{

                            $actionBtn = '';

                        }
                    }

                    return $actionBtn;
                })
//                ->editColomn('parts_id',function ($parts){
//                    $scat = explode(',',$parts->parts_id);
//                    $value = [];
//                    $request_parts = PartsRequest::where('id',$parts->id)->where('is_deleted',0)->first();
//                    $final_price = $request_parts->amt;
//                    $grand_total =  $final_price * 9/100;
//                    $sgst = $grand_total+$grand_total;
//                    $total = $sgst+$final_price;
//                    $html = "<button data-toggle='modal' data-target='#parts".$parts->id ."' class='btn btn-warning forward btn-sm' id='parts' name =\"forward\">View</button>
//                                    <div id='parts" . $parts->id . "' class=\"modal fade\" role=\"dialog\">
//                                        <div class=\"modal-dialog\">
//                                            <div class=\"modal-content\"><br>
//                                                <div class='model-heading'><h4>Parts Details</h4></div>
//                                         <div class=\"modal-body\">
//                                     <div class='panel'>
//                                               <div class=\"panel-heading\"></div>
//                                                  <form method='post' action=\".url('forwardTicket') . \">
//                                                     <input type='hidden' name='_token' value='\".csrf_token().\"'>
//                                                        <input type='hidden' name='id' value='\".$parts->id.\"' >
//                                                           <div class=\"panel-body\">
//                                                              <div class='col-md-12'>
//                                                                 <div class=\'table-responsive'\>
//
//                                                                 <table class=\"table table-bordered\" id='borede_tab'>" .
//                        "
//                                                                 <thead>
//                                                                                   <th>Title</th>
//                                                                                         <th>Description</th>
//                                                                                          <th>Price</th>
//                                                                                          </thead>";
//                                                                                         foreach ($scat as $c) {
//                                                                                             $scategory = partDetails::where('id', $c)->where('is_deleted',0)->first();
//                                                                                             $scat = parts::where('id', $scategory->part_id)->where('is_deleted',0)->first();
//                                                                                              $html .= "
//                                                                                                 <tbody>
//                                                                                               <tr>
//                                                                                                <td style='background-color:white!important'>$scat->title</td>
//                                                                                                <td style='background-color:white!important'>$scategory->description</td>
//                                                                                                <td style='background-color:white!important'>$scategory->price</td>
//                                                                                            </tr>";
//                                                                                            $html .= "
//                                                                                     </tbody>";
//
//                                                                                        }
//                                                                    $html .="</div>
//                                                                    </table>
//                                                                </div>
//                                                                <div class='col-md-6'></div>
//                                                                    <div class='card parts_requests col-md-6' id='sttt'>
//                                                                    <div class='col-md-6'>
//                                                                        <h5>CGST</h5>
//                                                                            </div>
//                                                                        <div class='col-md-6'>
//                                                                             <h5> ₹$sgst</h5>
//                                                                         </div>
//                                                                <br>
//                                                                     <div class='col-md-6'>
//                                                                       <h5> SGST</h5>
//                                                                        </div>
//                                                                        <div class='col-md-6'>
//                                                                             <h5> ₹$sgst</h5>
//                                                                            </div>
//                                                                 <hr>
//                                                                        <div class='col-md-6'>
//                                                                        <h4>Total</h4>
//                                                                        </div>
//                                                                        <div class='col-md-6'>
//                                                                        <h5>Rs.$total</h5>
//                                                                        </div>
//                                                                </div>
//                                                       </div>
//                                                        </form>
//                                                 </div>
//                                                <div class=\"modal-footer\">
//                                                    <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>
//                                                </div>
//                                                </div>
//                                        </div>
//                                    </div>";
//                    return $html;
//                })
                ->editColumn('technician_user_id',function ($team){
                    $team = team ::where('id',$team->technician_user_id)->where('is_deleted',0)->first();
                    if(empty($team))
                    {
                        return '-';
                    }
                    else
                    {
                        return $team->name;
                    }
                })
                ->editColumn('customer_id',function ($customer){
                    $customer = customers ::where('id',$customer->customer_id)->where('is_deleted',0)->first();
                    return $customer->name;
                })
                ->editColumn('ticket_id',function ($ticket){
                    $ticket = RaiseTickets ::where('id',$ticket->ticket_id)->where('is_deleted',0)->first();
                    return $ticket->title;
                })
                ->editColumn('admin_status',function ($ticket){
                  if($ticket->status == 'Paid')
                  {
                      return '<button class="btn btn-danger" onclick="adminstatus('.$ticket->id.')">Unpaid</button>';
                  }
                  else if($ticket->admin_status =='Paid')
                  {
                      return '<button class="btn btn-success">Paid</button>';
                  }
                  else{
                      return 'Not paid';
                  }
                })
                ->editColumn('payment',function ($ticket){

                    return '<button class="btn btn-success" onclick="Paymentnow('.$ticket->id.')">Pay Now</button>';
                })
                ->rawColumns(['action','parts_id','technician_user_id','customer_id','ticket_id','payment','admin_status'])
                 ->make(true);
        }
    }

    public function create(){
        $teams = team::where('is_deleted',0)->get();
        $customers = customer_products::where('is_deleted',0)->get();
        $parts = parts::where('is_deleted',0)->get();
        $problems = problems::where('is_deleted',0)->get();
        return view('Parts_request.create',compact('teams','customers','problems','parts'));

    }

    public function store(Request $request){
        $input['unique_job_number'] = $request->unique_job_number;
        $input['customer_id'] = $request->customer_id;
        $input['technician_user_id'] =  $request->technician_user_id;
        $input['parts_id'] = explode(',',$request->description);
        $input['final_price'] = $request->final_price;
        $input['payment_method'] = $request->payment_method;
        $input['amt'] = $request->amt;
        $input['payment_id'] = $request->payment_id;
        $input['ticket_id'] = $request->ticket_id;
        $input['payment_type'] = $request->payment_type;
        $input['date'] = $request->date;
        $input['status'] = $request->status;
        $input['admin_status'] = $request->admin_status;
        PartsRequest::create($input);

        $entry['t_name'] = "PartRequest";
        $entry['change_by'] = Auth::user()->name;
        $entry['activity'] = "Inserted";
        activity::create($entry);
        $notification = array(
            'message' => 'Parts Requests created successfully',
            'alert-type' => 'success'
        );
        return view('Parts_request.index')->with($notification);

//    return redirect()->to('Parts_request')->with($notification);
    }
    public function edit($id){
        $ticket = RaiseTickets::first();
        $parts_list = parts::first();
        $parts_request = PartsRequest::where('id',$id)->first();

            $customer = customers::where('is_deleted', '0')->get();

            $customer_products = customer_products::where('is_deleted', '0')->get();
            $teams = team::where('is_deleted', '0')->get();
            $problems = problems::where('is_deleted',0)->get();
            return view('Parts_request.edit',compact('parts_request','customer','teams','customer_products','problems','ticket','parts_list'));
    }
    public function partspayment(Request $request)
    {
        $payment_date=date('d-m-Y');
        $payment_type=$request->payment_method;
        $payment_id=rand(99999,999999);
        $payment_method=$request->payment_method;
        $partspaymentUpdate=PartsRequest::where('id',$request->parts_id)->where('is_deleted',0)->update(['payment_type'=>$payment_type,'payment_method'=>$payment_method,'payment_id'=>$payment_id,'payment_date'=>$payment_date,'status'=>'Paid','admin_status'=>'Paid']);
    }
    public function adminstatus(Request $request)
    {
        $partspaymentUpdate=PartsRequest::where('id',$request->parts_id)->where('is_deleted',0)->update(['admin_status'=>'Paid']);
    }
}