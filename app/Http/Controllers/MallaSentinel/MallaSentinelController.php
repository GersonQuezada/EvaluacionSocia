<?php

namespace App\Http\Controllers\MallaSentinel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MallaSentinelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function IndexSocia()
    {
        return view('MallaRiesgo.socia');
    }

    public function IndexBC()
    {
        return view('MallaRiesgo.bancaComunal');
    }
}
