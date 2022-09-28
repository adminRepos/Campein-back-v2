<?php

namespace App\Http\Controllers;

use App\Models\Interest;
use App\Http\Requests\StoreGrupoInterezRequest;
use App\Http\Requests\UpdateGrupoInterezRequest;

class GrupoInterezController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Interest::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGrupoInterezRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGrupoInterezRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GrupoInterez  $grupoInterez
     * @return \Illuminate\Http\Response
     */
    public function show(GrupoInterez $grupoInterez)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGrupoInterezRequest  $request
     * @param  \App\Models\GrupoInterez  $grupoInterez
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGrupoInterezRequest $request, GrupoInterez $grupoInterez)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GrupoInterez  $grupoInterez
     * @return \Illuminate\Http\Response
     */
    public function destroy(GrupoInterez $grupoInterez)
    {
        //
    }
}
