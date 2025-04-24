<?php

namespace App\DataTables;

use App\Models\team;
use App\Models\Zone;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class teamDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'teams.datatables_actions')
            ->editColumn('zone',function($zone){
                $customer_zones  = Zone ::where('id',$zone->zone)->where('is_deleted',0)->first();
                if(!empty($zone->zone)){
                    return $customer_zones->title;
                }
                else{
                    return $zone = '';
                }
            })
            -> rawColumns(['action','zone']);

    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\team $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(team $model)
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
            'name',
            'email',
            'contact_number',
            'zone'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'teamsdatatable_' . time();
    }
}
