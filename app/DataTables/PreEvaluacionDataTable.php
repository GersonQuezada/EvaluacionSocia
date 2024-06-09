<?php

namespace App\DataTables;

use App\Models\PreEvaluacion;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;


class PreEvaluacionDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'preevaluacion.action')
            ->setRowId('id');
    }

    public function query(PreEvaluacion $model): QueryBuilder
    {
        // Obtener el ID de usuario
        $userId = auth()->id();

        // Obtener las sucursales asociadas al usuario
        $sucursales = DB::table('rsg_usuario_sucursal')
            ->where('IN_usuario_ID', $userId)
            ->select('VC_COD_SUCURSAL')
            ->get();

        // Filtrar los datos de acuerdo a las sucursales
        $queryResult = $model->whereIn('CODREGION', $sucursales->pluck('VC_COD_SUCURSAL')->toArray());

        return $queryResult;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
        ->setTableId('preevaluacion-table')
        ->columns($this->getColumns())
        ->orderBy(2) // Ordenar los datos en la columna 1
        ->dom('Bfrtip')
        ->selectStyleSingle()
        ->serverSide(true)
        ->buttons([
            Button::make('create'),
            Button::make('export'),
            Button::make('print'),
            Button::make('reset'),
            Button::make('reload')
        ]);

        // return $this->builder()
        //             ->setTableId('preevaluacion-table')
        //             ->columns($this->getColumns())
        //             ->minifiedAjax() // Asegúrate de que esto esté presente
        //             ->ajax([
        //                 'url' => route('pre-evaluaciones.data')
        //                 ])
        //             ->dom('Bfrtip')
        //             ->orderBy(1)
        //             ->serverSide(true)
        //             ->selectStyleSingle()
        //             ->buttons([
        //                 Button::make('create'),
        //                 Button::make('export'),
        //                 Button::make('print'),
        //                 Button::make('reset'),
        //                 Button::make('reload')
        //             ]);
    }

    public function getColumns(): array
    {
        return [
            'nombrecompleto',
            'dni',
            'bancocomunal',
            'fecha',
            'Asesor'
        ];
    }

    protected function filename(): string
    {
        return 'PreEvaluacion_' . date('YmdHis');
    }
}
