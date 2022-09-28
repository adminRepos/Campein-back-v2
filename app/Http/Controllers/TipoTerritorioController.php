<?php

namespace App\Http\Controllers;

use App\Models\TerritoryType;
use App\Http\Requests\StoreTipoTerritorioRequest;
use App\Http\Requests\UpdateTipoTerritorioRequest;

class TipoTerritorioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(TerritoryType::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTipoTerritorioRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTipoTerritorioRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TipoTerritorio  $tipoTerritorio
     * @return \Illuminate\Http\Response
     */
    public function show(TipoTerritorio $tipoTerritorio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTipoTerritorioRequest  $request
     * @param  \App\Models\TipoTerritorio  $tipoTerritorio
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTipoTerritorioRequest $request, TipoTerritorio $tipoTerritorio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TipoTerritorio  $tipoTerritorio
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoTerritorio $tipoTerritorio)
    {
        //
    }
}
