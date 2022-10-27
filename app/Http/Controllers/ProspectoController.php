<?php

namespace App\Http\Controllers;

use App\Models\Prospect;
use App\Http\Requests\StoreProspectoRequest;
use App\Http\Requests\UpdateProspectoRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ProspectoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Prospect::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProspectoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProspectoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Prospecto  $prospecto
     * @return \Illuminate\Http\Response
     */
    public function show(Prospecto $prospecto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProspectoRequest  $request
     * @param  \App\Models\Prospecto  $prospecto
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProspectoRequest $request, Prospecto $prospecto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prospecto  $prospecto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prospecto $prospecto)
    {
        //
    }

    public function insertProspecto(Request $request){
        $identificacion = $request->identificacion;
        $genero = $request->genero;
        $primerNombre = $request->primerNombre;
        $segundoNombre = $request->segundoNombre;
        $primerApellido = $request->primerApellido;
        $segundoApellido = $request->segundoApellido;
        $direccion = $request->direccion;
        $email = $request->email;
        $telefono = $request->telefono;
        $whatsapp = $request->whatsapp;
        $user_id = $request->user_id;
        $rangoEdad = $request->rangoEdad;
        $longitud = $request->longitud;
        $latitud = $request->latitud;
        $intereces = $request->intereces;

        $strQuery = "CALL insertProspecto(" 
            . "'" . $identificacion . "', " 
            . "'" . $genero . "', " 
            . "'" . $primerNombre . "', ";
        $strQuery .= $segundoNombre == null ? "NULL," : "'" . $segundoNombre . "', ";
        $strQuery .= "'" . $primerApellido . "', ";
        $strQuery .= $segundoApellido == null ? "NULL," : "'" . $segundoApellido . "', " ;
        $strQuery .= "'" . $direccion  . "', "
            . "'" . $email . "', "
            . "'" . $telefono . "', ";
        $strQuery .= $whatsapp == null ? "NULL," : "'" . $whatsapp . "', ";
        $strQuery .= $user_id . ", "
            . "'" . $rangoEdad . "', "
            . "'" . $longitud . "', "
            . "'" . $latitud . "' );";

        return response()->json([
            'data' => DB::select($strQuery),
        ], 200);

    }

    public function getIntereces(Request $request){
        $campeign_id = intval($request->campeign_id);
        return response()->json([
            'data' => DB::select('CALL get_intereces_por_campeign('.$campeign_id.')'),
        ], 200);
    }
}
