<?php

namespace App\Http\Controllers\PreEvaluacion;

use App\DataTables\PreEvaluacionDataTable;
use App\DataTables\PreEvaluadoresDataTableHtml;
use App\Http\Controllers\Controller;
use App\Models\PreEvaluacion;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class PreEvaluacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $request;

    /**
     * Constructor to inject the Request dependency
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function IndexSocia()
    {
        if($this->request->ajax()){

            $userId = auth()->user()->id;
            $Sucursales = DB::table('rsg_usuario_sucursal')->where('IN_usuario_ID',$userId)->pluck('VC_COD_SUCURSAL');
            $query = PreEvaluacion::whereIn('CODREGION', $Sucursales);
            if($this->request->filled('from_date') && $this->request->filled('end_date')){
                $query = $query->whereBetween('fecha',[$this->request->from_date,$this->request->end_date]);
            }          
            // return  DataTables::make($queryResult)->toJson();
            return DataTables::of($query)->make(true);
        }

        return view('PreEvaluaciones.socia');
    }

    public function IndexBC()
    {
        return view('PreEvaluaciones.bancaComunal');
    }

    public function searchSocia() : View
    {
        return view('PreEvaluaciones.ModalBuscaSocia');
    }
}
