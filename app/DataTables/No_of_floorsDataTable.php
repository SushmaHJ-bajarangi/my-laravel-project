<?php

namespace App\DataTables;

use App\Models\No_of_floors;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class No_of_floorsDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'no_of_floors.datatables_actions')
            ->editColumn('title',function ($data)
            {
                $final=$data->title*1;
                return$final;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\No_of_floors $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(No_of_floors $model)
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
                'order'     => [[0, 'asc']],
                'buttons'   => [],
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
            'title'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'no_of_floorsdatatable_' . time();
    }
}
