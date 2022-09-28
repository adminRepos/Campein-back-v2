<?php

namespace App\Http\Controllers;

use App\Models\Partido;
use App\Http\Requests\StorePartidoPoliticoRequest;
use App\Http\Requests\UpdatePartidoPoliticoRequest;

class PartidoPoliticoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Partido::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePartidoPoliticoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePartidoPoliticoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PartidoPolitico  $partidoPolitico
     * @return \Illuminate\Http\Response
     */
    public function show(PartidoPolitico $partidoPolitico)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePartidoPoliticoRequest  $request
     * @param  \App\Models\PartidoPolitico  $partidoPolitico
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePartidoPoliticoRequest $request, PartidoPolitico $partidoPolitico)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PartidoPolitico  $partidoPolitico
     * @return \Illuminate\Http\Response
     */
    public function destroy(PartidoPolitico $partidoPolitico)
    {
        //
    }
}
