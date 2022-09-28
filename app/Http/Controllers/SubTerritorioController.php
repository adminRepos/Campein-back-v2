<?php

namespace App\Http\Controllers;

use App\Models\SubTerritory;
use App\Http\Requests\StoreSubTerritorioRequest;
use App\Http\Requests\UpdateSubTerritorioRequest;

class SubTerritorioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(SubTerritory::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSubTerritorioRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubTerritorioRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubTerritorio  $subTerritorio
     * @return \Illuminate\Http\Response
     */
    public function show(SubTerritorio $subTerritorio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSubTerritorioRequest  $request
     * @param  \App\Models\SubTerritorio  $subTerritorio
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubTerritorioRequest $request, SubTerritorio $subTerritorio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubTerritorio  $subTerritorio
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubTerritorio $subTerritorio)
    {
        //
    }
}
