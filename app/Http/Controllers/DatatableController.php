<?php

namespace App\Http\Controllers;

use App\Models\MallaSentinel;
use App\Models\PreEvaluacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DatatableController extends Controller
{
    // private $Sucursales = DB::table('rsg_usuario_sucursal')->where('IN_usuario_ID',auth()->user()->id)->select('VC_SUCURSAL')->get();
    public function DataTablePreEvaluadores(){
        $userId = auth()->user()->id;
        $Sucursales = DB::table('rsg_usuario_sucursal')->where('IN_usuario_ID',$userId)->pluck('VC_COD_SUCURSAL');
        $query = PreEvaluacion::whereIn('CODREGION', $Sucursales);
        // return  DataTables::make($queryResult)->toJson();
        return DataTables::of($query)->toJson();
    }

    public function DataTableMallaSentinel(){
        $Sucursales = DB::table('rsg_usuario_sucursal')->where('IN_usuario_ID',auth()->user()->id)->select('VC_DES_SUCURSAL')->get();
        $queryResult = MallaSentinel::whereIn('REGION',array_column($Sucursales->toArray(), 'VC_DES_SUCURSAL'));
        return DataTables::make($queryResult)->toJson();
    }
}
