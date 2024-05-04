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
        $Sucursales = DB::table('rsg_usuario_sucursal')->where('IN_usuario_ID',auth()->user()->id)->select('VC_COD_SUCURSAL')->get();

        return DataTables::collection(PreEvaluacion::whereIn('CODREGION',array_column($Sucursales->toArray(), 'VC_COD_SUCURSAL'))->get())->toJson();
    }

    public function DataTableMallaSentinel(){
        $Sucursales = DB::table('rsg_usuario_sucursal')->where('IN_usuario_ID',auth()->user()->id)->select('VC_DES_SUCURSAL')->get();
        return DataTables::collection(MallaSentinel::all()->whereIn('REGION',array_column($Sucursales->toArray(), 'VC_DES_SUCURSAL')))->toJson();
    }
}
