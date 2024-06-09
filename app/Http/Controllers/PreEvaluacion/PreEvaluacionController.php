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
