<?php

namespace App\DataTables;

use App\Models\Technician_Assist;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class Technician_AssistDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'technicianAssist.datatables_actions')
            ->editColumn('PDF',function($pdf){
                $url=asset('/technician_assist/'.$pdf->PDF);
                $image = asset('/images/image.png');
                return '<a href="'.$url.'" target="_blank"><img src="'.$image.'" width="80px" height="80px"></a>';
            })
            ->rawColumns(['PDF','action']);

    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Technician_Assist $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Technician_Assist $model)
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
            'title',
            'PDF'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'technicianAssists_datatable_' . time();
    }
}
