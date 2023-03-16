<?php

namespace App\Http\Controllers;

use App\Models\Prospect;
use App\Http\Requests\StoreProspectoRequest;
use App\Http\Requests\UpdateProspectoRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Date;
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

    /**
     * Registrar prospecto e intereces del prospecto
     *
     * @author Victor Vivas
     */
    public function insertProspecto(Request $request){
        try {
            //code...
            // Captura de request
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
            $tipoDocumento = $request->tipoDocumento;
            $localidad = $request->localidad;
    
            // Generar consulta
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
                . "'" . $latitud . "', "
                . "'" . $tipoDocumento . "', "
                . "'" . $localidad . "');";
            // Ejecutar consulta 
            $consulta = DB::select($strQuery);
            // Retomamos el id para registrar los intereces 
            $lastInsertID = $consulta[0]->id;
            // Generar consulta 
            $strQuery = "insert into intereces_prospecto (prospecto_id, interes_id) values ";
            $i = 0;
            $count = count($intereces);
            foreach ($intereces as $i) {
                $strQuery .= "(" . $lastInsertID . ", " . $i . ")";
                if($i <= $count){
                    $strQuery .= ",";
                }else{
                    $strQuery .= ";";
                }
                $i++;
            }
            // Ejecutar consulta
            $insertIntereces = DB::select($strQuery);
            // Response
            return response()->json([
                "data" => "El prospecto se registro correctamente"
            ], 200);
        } catch (\Exception $e) {
            // Respuesta Error
            return response()->json([
                "data" => "Ocurrio un fallo al registrar el prospecto",
                "error" => $e
            ], 500);
        }
    }

    public function getIntereces(Request $request){
        $rol_id = intval($request->rol_id);
        return response()->json([
            'data' => DB::select('CALL get_intereces_por_campeign('.$rol_id.')'),
        ], 200);
    }
}
