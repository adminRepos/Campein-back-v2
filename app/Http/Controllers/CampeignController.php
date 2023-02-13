<?php

namespace App\Http\Controllers;

use App\Models\Campeign;
use App\Http\Requests\StoreCampeignRequest;
use App\Http\Requests\UpdateCampeignRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// use Barrydvh\DomPDF\Fecade as PDF;
use PDF;

// use Barryvdh\DomPDF\Facade\Pdf;

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

    public function updateMetaCampeign(Request $request){
        try {
            $body = $_REQUEST;
            $query = DB::select("CALL update_meta_campeign(?, ?)", [$body["rol_id"], $body["meta"]]);
            return response()->json([
                'code' => 200, // success
                'message' => 'Se modifico la meta exitosamente'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'code' => 500, // internal server error
                'message' => 'Error interno del servidor',
                'error' => $th
            ], 500);
        }
    }

    public function getPDF(Request $request, $id_user, $datos){
        try {
            $user = User::find(intval($id_user));
            $data = null;
            
            if($datos == 1){
                if($user->rol_id == 2){
                    $data = DB::select("CALL get_data_report_admin(?)", [$user->rol_id]);
                }
                if($user->rol_id == 3){
                    $data = DB::select("CALL get_data_report_alfa(?)", [$user->id]);
                }
            }else if($datos == 0){
                $data = DB::select("CALL get_data_report_user(?)", [$user->id]);
            }

            $pdf = PDF::loadView('reporte-users-mobile-pdf', ['data' => $data, 'rol_id' => $user->rol_id, 'i'=>0]);
            // return $pdf->stream();

            
            return response()->json([
                'code' => 200, // succes
                'data' => base64_encode($pdf->stream()),
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'code' => 500, // warning
                'message' => "Error interno del servidor",
                'error' => $th 
            ], 500);
            //throw $th;
        }
    }

    public function getPDFAdminMobile(Request $request, $rol_id){
        try {
            // $user = User::find(intval($id_user));
            $data = null;
            $rol = null;
            if($rol_id == 'alfa') $rol = 3;
            if($rol_id == 'beta') $rol = 4;
            $data = DB::select("CALL get_data_rol_report_admin(?)", [$rol]);

            $pdf = PDF::loadView('reporte-users-mobile-pdf', ['data' => $data, 'i'=>0]);
            // return $pdf->stream();
 
            return response()->json([
                'code' => 200, // succes
                'data' => base64_encode($pdf->stream()),
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'code' => 500, // warning
                'message' => "Error interno del servidor",
                'error' => $th 
            ], 500);
            //throw $th;
        }
    }

    public function getDataExcel(Request $request, $id_user, $datos){
        try {
            $user = User::find(intval($id_user));
            $data = null;
            
            if($datos == 1){
                if($user->rol_id == 2){
                    $data = DB::select("CALL get_data_report_admin(?)", [$user->rol_id]);
                }
                if($user->rol_id == 3){
                    $data = DB::select("CALL get_data_report_alfa(?)", [$user->id]);
                }
            }else if($datos == 0){
                $data = DB::select("CALL get_data_report_user(?)", [$user->id]);
            }
            
            return response()->json([
                'code' => 200, // succes
                'data' => $data,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'code' => 500, // warning
                'message' => "Error interno del servidor",
                'error' => $th 
            ], 500);
            //throw $th;
        }
    }

    public function getDataExcelAdminMobile(Request $request, $rol_id){
        try {
            // $user = User::find(intval($id_user));
            $data = null;
            $rol = null;
            if($rol_id == 'alfa') $rol = 3;
            if($rol_id == 'beta') $rol = 4;
            $data = DB::select("CALL get_data_rol_report_admin(?)", [$rol]);

            return response()->json([
                'code' => 200, // succes
                'data' => $data,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'code' => 500, // warning
                'message' => "Error interno del servidor",
                'error' => $th 
            ], 500);
            //throw $th;
        }
    }

    public function cambioMeta(Request $request, $numero){
        try {
            $query = DB::select("UPDATE campeigns SET meta = ? WHERE id = 2;", [intval($numero)]);
            return response()->json([
                'code' => 200, // succes
                'data' => 'full',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'code' => 500, // warning
                'message' => "Error interno del servidor",
                'error' => $th 
            ], 500);
        }
    }

    public function cambioMetaEvidencias(Request $request, $numero){
        try {
            $query = DB::select("UPDATE campeigns SET meta_evidencias = ? WHERE id = 2;", [intval($numero)]);
            return response()->json([
                'code' => 200, // succes
                'data' => 'full',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'code' => 500, // warning
                'message' => "Error interno del servidor",
                'error' => $th 
            ], 500);
        }
    }
}
