<?php

namespace App\Http\Controllers;

use App\Models\Causa;
use App\Http\Requests\StoreCausaRequest;
use App\Http\Requests\UpdateCausaRequest;

class CausaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Causa::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCausaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCausaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Causa  $causa
     * @return \Illuminate\Http\Response
     */
    public function show(Causa $causa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCausaRequest  $request
     * @param  \App\Models\Causa  $causa
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCausaRequest $request, Causa $causa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Causa  $causa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Causa $causa)
    {
        //
    }
}
