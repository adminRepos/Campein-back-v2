<?php

namespace App\Http\Controllers;

use App\Models\UserZone;
use Illuminate\Http\Request;

class ZonasUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(UserZone::all());
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
     * @param  \App\Models\ZonasUsers  $zonasUsers
     * @return \Illuminate\Http\Response
     */
    public function show(ZonasUsers $zonasUsers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ZonasUsers  $zonasUsers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ZonasUsers $zonasUsers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ZonasUsers  $zonasUsers
     * @return \Illuminate\Http\Response
     */
    public function destroy(ZonasUsers $zonasUsers)
    {
        //
    }
}
