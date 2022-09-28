<?php

namespace App\Http\Controllers;

use App\Models\CampeignUser;
use Illuminate\Http\Request;

class CampeignsUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(CampeignUser::all()) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CampeignsUsers  $campeignsUsers
     * @return \Illuminate\Http\Response
     */
    public function show(CampeignsUsers $campeignsUsers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CampeignsUsers  $campeignsUsers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CampeignsUsers $campeignsUsers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CampeignsUsers  $campeignsUsers
     * @return \Illuminate\Http\Response
     */
    public function destroy(CampeignsUsers $campeignsUsers)
    {
        //
    }
}
