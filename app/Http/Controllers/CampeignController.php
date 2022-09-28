<?php

namespace App\Http\Controllers;

use App\Models\Campeign;
use App\Http\Requests\StoreCampeignRequest;
use App\Http\Requests\UpdateCampeignRequest;

class CampeignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Campeign::all()) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCampeignRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCampeignRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Campeign  $campeign
     * @return \Illuminate\Http\Response
     */
    public function show(Campeign $campeign)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCampeignRequest  $request
     * @param  \App\Models\Campeign  $campeign
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCampeignRequest $request, Campeign $campeign)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Campeign  $campeign
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campeign $campeign)
    {
        //
    }
}
