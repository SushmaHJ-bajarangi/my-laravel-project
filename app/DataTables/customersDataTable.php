<?php

namespace App\DataTables;

use App\Models\customers;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use App\Models\review;
use App\Models\RaiseTickets;

class customersDataTable extends DataTable
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

        return
            $dataTable
            ->addColumn('action', 'customers.datatables_actions')

                ->editColumn('address',function ($post){
                $html="<div id=\"myGroup\">
                <button class=\" btn btn-warning dropdown accordion-heading btn-sm\" data-toggle=\"collapse\" id=\"toggle_icon\" data-target='#demo".$post->id."' data-parent=\"#myGroup\">view</button>
                <div class=\"accordion-group\">
                 <div class=\"collapse indent\"  id='demo".$post->id."'>
                 <div class=\"card\" id=\"toggle_text\">";
                if(isset($post->address)){
                    $html .="<p>".$post->address."</p>";
                }
                else{
                    $html .="<p>NO ADDRESS</p>";
                }
                $html .="</div</div>
                                </div>
                                </div>";
                return $html;
             })

                ->editColumn('siteaddress', function ($post) {
                    $html = "<div id=\"myGroupsite" . $post->id . "\">
                <button class=\"btn btn-warning dropdown accordion-heading btn-sm\" data-toggle=\"collapse\" 
                        id=\"toggle_icon\" data-target=\"#demoSite" . $post->id . "\" data-parent=\"#myGroupsite" . $post->id . "\">
                    View Site Address
                </button>
                <div class=\"accordion-group\">
                    <div class=\"collapse\" id=\"demoSite" . $post->id . "\">
                        <div class=\"card\" id=\"toggle_text\">";
                    if (isset($post->siteaddress)) {
                        $html .= "<p>" . $post->siteaddress . "</p>";
                    } else {
                        $html .= "<p>NO SITE ADDRESS</p>";
                    }
                    $html .= "    </div>
                    </div>
                </div>
            </div>";
                    return $html;
                })

                ->editColumn('email',function ($post){
                if(isset($post->email)){
                    return $post->email;
                }
                else{
                    return 'NO EMAIL';
                }
            })

                ->addColumn('rating',function ($post){
                    $user=Auth::user();
                    $count=review::where('customer_id',$post->id)->count();
//                    return $count;
                    $review=review::where('customer_id',$post->id)->sum('t_star');
                    if($review !=0)
                    {
                        $final_review=$review/$count;
                        return round($final_review,2);
                    }
                    else{
                        return '0.0';
                    }

                })

            ->rawColumns(['action','address','siteaddress','status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\customers $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(customers $model)
    {
        return $model->where('is_deleted',0)->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '120px', 'printable' => false]);
//            ->parameters([
//                'dom'       => 'Bfrtip',
//                'stateSave' => true,
//                'order'     => [[0, 'desc']],
////                'buttons'   => [
////                    ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner',],
////                    ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner',],
////                    ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner',],
////                    ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner',],
////                    ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner',],
////                ],
//            ]);

    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'name',
            'email',
            'contact_number',
            'address',
            'siteaddress',
            'rating'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'customersdatatable_' . time();
    }
}
