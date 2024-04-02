<?php

namespace App\Http\Controllers\PreEvaluacion;

use App\Http\Controllers\Controller;
use App\Models\PreEvaluacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PreEvaluacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function IndexSocia()
    {
        return view('PreEvaluaciones.socia');
    }

    public function IndexBC()
    {
        return view('PreEvaluaciones.bancaComunal');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        //
    }
}
