<?php

namespace App\Http\Controllers;

use App\Models\Territory;
use App\Http\Requests\StoreTerritorioRequest;
use App\Http\Requests\UpdateTerritorioRequest;

class TerritorioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Territory::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTerritorioRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTerritorioRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Territorio  $territorio
     * @return \Illuminate\Http\Response
     */
    public function show(Territorio $territorio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTerritorioRequest  $request
     * @param  \App\Models\Territorio  $territorio
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTerritorioRequest $request, Territorio $territorio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Territorio  $territorio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Territorio $territorio)
    {
        //
    }
}
