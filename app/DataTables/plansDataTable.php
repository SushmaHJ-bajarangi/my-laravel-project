<?php

namespace App\DataTables;

use App\Models\plans;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class plansDataTable extends DataTable
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
            ->addColumn('action', 'plans.datatables_actions')
            ->editColumn('duration',function ($post)
            {
                return $post->duration.' '.'Month';
            })
            ->editColumn('description',function ($post){
                $html="<button data-toggle='modal' data-target='#description".$post->id."' class='btn btn-warning btn-sm'>View</button>
                            <div id='description".$post->id."' class=\"modal fade\" role=\"dialog\">
                                <div class=\"modal-dialog\">
                                    <div class=\"modal-content\">
                                        <div class=\"modal-header\">
                                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>
                                            <h4 class=\"modal-title\">Description</h4>
                                        </div>
                                         <div class=\"modal-body\">
                                            <div class=\"panel panel-warning\">
                                                <div class=\"panel-heading\"></div>
                                                <div class=\"panel-body\">";
                                                $html .="<p>".$post->description."</p>";
                                                $html .="</div>
                                             </div>
                                         </div>
                                        <div class=\"modal-footer\">
                                            <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>";
                return $html;
            })
            ->rawColumns(['action','description']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\plans $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(plans $model)
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
            ->addAction(['width' => '120px', 'printable' => false])
            ->parameters([
                'dom'       => 'Bfrtip',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'buttons'   => [
//                    ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner',],
//                    ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner',],
//                    ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner',],
//                    ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner',],
//                    ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner',],
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
            'title',
            'description',
            'duration'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'plansdatatable_' . time();
    }
}
