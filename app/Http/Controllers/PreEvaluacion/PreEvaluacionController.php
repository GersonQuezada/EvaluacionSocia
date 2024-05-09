<?php

namespace App\Http\Controllers\PreEvaluacion;

use App\Http\Controllers\Controller;
use App\Models\PreEvaluacion;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PreEvaluacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function IndexSocia():View
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
