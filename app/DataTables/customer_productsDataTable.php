<?php

namespace App\DataTables;

use App\Models\customer_products;
use App\Models\Zone;
use function foo\func;
use GuzzleHttp\Psr7\Request;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use App\Models\GenerateQuoteDetails;
use App\Models\plans;
use App\Models\passengerCapacity;
use App\Models\ProductStatus;

class customer_productsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);
        return $dataTable
            ->addColumn('action', 'customer_products.datatables_actions')
            ->orderColumn('unique_job_number', '-unique_job_number $1')
            ->orderColumn('warranty_start_date', 'DATE_FORMAT(STR_TO_DATE(warranty_start_date,\'%d-%m-%Y\'),\'%Y%m%d\') $1')
            ->orderColumn('warranty_end_date', 'DATE_FORMAT(STR_TO_DATE(warranty_end_date,\'%d-%m-%Y\'),\'%Y%m%d\') $1')
            ->orderColumn('ordered_date', 'DATE_FORMAT(STR_TO_DATE(ordered_date,\'%d-%m-%Y\'),\'%Y%m%d\') $1')
            ->editColumn('detail',function($details){
            $html="  <div id=\"myGroup\">
                       <button class=\"btn dropdown btn-primary collapsible btn-sm\" data-toggle=\"collapse\" id=\"toggle_icon\" data-target='#address".$details->id."' data-parent=\"#myGroup\">+</button>
                       <div class=\"accordion-group\">
                            <div class=\"collapse indent\"  id='address".$details->id."'>
                            <div class=\"card slidingDiv\" id='cutomer_detail'>
                                    <div><lable  style=\"text - align:left;\">No of Services</lable><span style=\"float:right;\">$details->no_of_services</span></div>
                                    <div><lable  style=\"text-align:left;\">No of Floors </lable> <span style=\"float:right;\">$details->number_of_floors</span></div>
                                    <div><lable  style=\"text-align:left;\">passenger Capacity</lable><span style=\"float:right;\">$details->passenger_capacity</span></div>
                                    <div><lable  style=\"text-align:left;\">Distance </lable><span style=\"float:right;\">$details->distance</span></div>
                                    <div><lable  style=\"text - align:left;\">Lift Model</lable><span style=\"float:right;\">".$details->getModel->title."</span></div>
                                    <hr>
                                    <div>$details->address</div>
                            </div>
                        </div>
                    </div>";
                return $html;
            })
            ->editColumn('customer_id',function ($product){
                return $product->getCustomer->name;
            })
            ->addColumn('amc_plan',function ($product){
                $plans_details=GenerateQuoteDetails::where('customer_id',$product->customer_id)->where('amc_status','active')->orderBy('id','desc')->first();
                if(empty($plans_details))
                {
                    return '<button class="btn btn-danger">No Plans</button>';
                }
                else
                {
                    $plan_name=plans::where('id',$plans_details->plan)->first();
                    if(empty($plan_name)){
                        return '<button class="btn btn-danger">No Plans</button>';
                    }
                    else{
                        return '<button type="button" class="btn btn-warning" data-toggle="modal" onclick="" data-target="#myModal">AMC</button>
                    <div id="myModal" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">AMC Plan</h4>
                          </div>
                          <div class="modal-body">
                          <center>
                              <div class="panel price panel-red">
                                <div class="panel-heading  text-center">
                                <h3>'.$plan_name->title.' Plan</h3>
                                </div>
                                <ul class="list-group list-group-flush text-center">
                                    <li class="list-group-item"><i class="icon-ok text-danger"></i>Start Date: '.$plans_details->start_date.'</li>
                                    <li class="list-group-item"><i class="icon-ok text-danger"></i>End Date: '.$plans_details->end_date.'</li>
                                    <li class="list-group-item"><i class="icon-ok text-danger"></i>Amount: '.$plans_details->price.' INR</li>
                                </ul>
                            </div>
                          </center>
                        <!-- /PRICE ITEM -->
                    </div>
                  </div>

                </div>

            </div>
            </div>';
                    }
                }
            })
            ->editColumn('status',function ($row){
                if($row->status == 'Under Warranty' && $row->amc_status == 'Under AMC'){
                    return $row->amc_status;
                }
                else{
                    return $row->status;
                }
            })
            ->editColumn('warranty_start_date',function ($row){
                if($row->status == 'Under Warranty' && $row->amc_status == 'Under AMC'){
                    return $row->amc_start_date;
                }
                else{
                    return $row->warranty_start_date;
                }
            })
            ->editColumn('warranty_end_date',function ($row){
                if($row->status == 'Under Warranty' && $row->amc_status == 'Under AMC'){
                    return $row->amc_end_date;
                }
                else{
                    return $row->warranty_end_date;
                }
            })
            ->editColumn('zone',function($zone){
                $customer_zones  = Zone::where('id',$zone->zone)->where('is_deleted',0)->first();
                return $customer_zones->title;
            })
            -> rawColumns(['action','customer_id','ordered_date','status','address','zone','detail','passenger_capacity','amc_plan']);
    }
    public function query(customer_products $model)
    {
        if(isset($_GET['job_number']) && $_GET['job_number'] != ''){
            return $model->where('unique_job_number',$_GET['job_number'])->where('is_deleted',0)->newQuery();
        }
        else{
            return $model->where('is_deleted',0)->newQuery();
        }
    }
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction([ 'width' => '120px', 'printable' => true])
            ->parameters([
                'dom'       => 'Bfrtip',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'buttons'   => [
                    'extend'=> 'copyHtml5',
                    'colvis'=>true
                ],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'unique_job_number',
            'customer_id'=>['title' => 'Customer'],
            'project_name',
            'warranty_start_date'=>['title' => 'Start Date'],
            'warranty_end_date'=>['title' => 'End Date'],
            'status',
            'zone',
            'detail'=>['searchable'=> 'false','orderable'=> 'false'],
            'ordered_date'=>['title' => 'Handover Date'],
            'amc_plan'=>['title' => 'Amc Plan'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'customer_productsdatatable_' . time();
    }

}
