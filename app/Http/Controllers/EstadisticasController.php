<?php 
namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use PDF;

class EstadisticasController extends Controller{

    public function getEstadisticasTotalUsuarios(Request $request, $id_user){
        try {
            $user = User::find(intval($id_user));
            $data = null;
            if($user->rol_id == 2){
                $data = DB::select('CALL get_estadistica_total_usuarios(?);', [ intval($id_user) ]);
            }else{
                $data = DB::select('CALL get_estadisticas_total_usuarios_betas_x_alfa(?);', [ intval($id_user) ]);
            }
            return response()->json([
                'code' => 200, // warning
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'code' => 500, // warning
                'message' => "Error interno del servidor",
                'error' => $th 
            ], 500);
        }
    }

    public function getPorcentajesProspectosXRol(Request $request, $id_user){
        try {
            // $user = User::find(intval($id_user));
            $data = DB::select('CALL get_estadisticas_porcentajes_prospectos_x_rol(?);', [ intval($id_user) ]);
            $total = intval($data[0]->alfas) + intval($data[0]->betas);
            $return = array((object)['total'=>$total, 'alfas' => $data[0]->alfas, 'betas' => $data[0]->betas]);
            return response()->json([
                'code' => 200, // warning
                'data' => $return
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'code' => 500, // warning
                'message' => "Error interno del servidor",
                'error' => $th 
            ], 500);
        }
    }

    public function getEstadisticaLocalidades(Request $request, $id_user){
        try {
            // $user = User::find(intval($id_user));
            $data = DB::select('CALL get_estadisticas_localidades();');
            return response()->json([
                'code' => 200, // warning
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'code' => 500, // warning
                'message' => "Error interno del servidor",
                'error' => $th 
            ], 500);
        }
    }

    public function getLideresBetaRanking(Request $request, $id_user){
        try {
            $user = User::find(intval($id_user));
            $meta = DB::select("SELECT c.meta from campeigns as c where c.id = 2;");
            if($user->rol_id == 2){
                $dataBetas = DB::select("CALL get_estadistica_ranking_prospectos_x_rol_admin(?)", [4]);
            }else{
                $dataBetas = DB::select("CALL get_estadistica_ranking_prospectos_x_rol(?)", [$id_user]);
            }
            $data = array();
            foreach($dataBetas as $item){
                if($item->conteo >= $meta[0]->meta || $item->conteo >= ($meta[0]->meta * 0.7) ){
                    $nameImage = $item->image;
                    if($nameImage <> null){
                        // $e->image = "test";
                        $dir = '../resources/images/profile-img/'.$item->image;
                        if (file_exists($dir) == false) {
                            $item->image = null;
                        }else{
                            // Extensión de la imagen
                            $type = pathinfo($dir, PATHINFO_EXTENSION);
                            // Cargando la imagen
                            $img = file_get_contents($dir);
                            // Decodificando la imagen en base64
                            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($img);
                            $item->image = $base64;          
                        }
                    }
                    $porcentaje = ($item->conteo * 1)/$meta[0]->meta;
                    array_push($data, (object)['nombre' => $item->nombre, 'image'=> $item->image, 'conteo'=>$item->conteo, 'porcentaje'=>$porcentaje]);
                }
            }
            return response()->json([
                'code' => 200, // success
                'meta' => $meta[0]->meta,
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'code' => 500, // warning
                'message' => "Error interno del servidor",
                'error' => $th 
            ], 500);
        }
    }

    public function getEstadisticasUsuario(Request $request, $id_user)
    {
        $user = User::find($id_user);
        $data = null;
        
        if($user->rol_id == 2){
            $data = (object)[
                'estado' => 'En desarrollo'
            ];
            return response()->json([
                'code' => 200, // success
                'data' => $data
            ], 200);
        }
        if($user->rol_id == 3){
            $contBetas = DB::select('SELECT count(id) as conteo from users_users where mayor = ?;', [$user->id]);
            $misFormularios = DB::select('SELECT count(id) as conteo from prospectos as p where p.user_id = ?;', [$user->id]);
            $misEvidencias = DB::select('SELECT count(id) as conteo from evidencias_user as eu where eu.id_user = ?;', [$user->id]);
            $formulariosBetas = DB::select('SELECT count(p.id) as conteo from prospectos as p inner join users_users as uu on uu.menor = p.user_id where uu.mayor = ?;', [$user->id]);
            $listaAlfas = DB::select("SELECT concat(u.nombre, ' ', u.apellido) as nombre, u.image, (select count(eu.id) from evidencias_user as eu where eu.id_user = u.id) as conteo from users as u where u.rol_id = 3 and (select count(eu.id) from evidencias_user as eu where eu.id_user = u.id) > 0;");
            $listaBetas = DB::select("SELECT concat(u.nombre, ' ', u.apellido) as nombre, u.image, (select count(eu.id) from evidencias_user as eu where eu.id_user = u.id) as conteo from users as u inner join users_users as uu on uu.menor = u.id  where uu.mayor = ? and (select count(eu.id) from evidencias_user as eu where eu.id_user = u.id) > 0;", [$user->id]);

            $conteoMayor = 0;
            $alfa = null;
            $beta = null;
            foreach($listaAlfas as $item){
                if($conteoMayor < $item->conteo) {
                    $conteoMayor = $item->conteo;
                    $nameImage = $item->image;
                    if($nameImage <> null){
                        // $e->image = "test";
                        $dir = '../resources/images/profile-img/'.$item->image;
                        if (file_exists($dir) == false) {
                            $item->image = null;
                        }else{
                            // Extensión de la imagen
                            $type = pathinfo($dir, PATHINFO_EXTENSION);
                            // Cargando la imagen
                            $img = file_get_contents($dir);
                            // Decodificando la imagen en base64
                            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($img);
                            $item->image = $base64;          
                        }
                    }
                    $alfa = $item;
                }
            }
            $conteoMayor = 0;
            foreach($listaBetas as $item){
                if($conteoMayor < $item->conteo) {
                    $conteoMayor = $item->conteo;
                    $nameImage = $item->image;
                    if($nameImage <> null){
                        // $e->image = "test";
                        $dir = '../resources/images/profile-img/'.$item->image;
                        if (file_exists($dir) == false) {
                            $item->image = null;
                        }else{
                            // Extensión de la imagen
                            $type = pathinfo($dir, PATHINFO_EXTENSION);
                            // Cargando la imagen
                            $img = file_get_contents($dir);
                            // Decodificando la imagen en base64
                            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($img);
                            $item->image = $base64;          
                        }
                    }
                    $beta = $item;
                }
            }

            $data = (object)[
                'conteoBetas' => $contBetas[0]->conteo,
                'misFormularios' => $misFormularios[0]->conteo,
                'misEvidencias' => $misEvidencias[0]->conteo,
                'formulariosBetas' => $formulariosBetas[0]->conteo,
                'alfaRanking' => $alfa,
                'betaRanking' => $beta
            ];
            return response()->json([
                'code' => 200, // success
                'data' => $data
            ], 200);
        }
        if($user->rol_id == 4){
            $misFormularios = DB::select('SELECT count(id) as conteo from prospectos as p where p.user_id = ?;', [$user->id]);
            $misEvidencias = DB::select('SELECT count(id) as conteo from evidencias_user as eu where eu.id_user = ?;', [$user->id]);
            $listaBetas = DB::select("SELECT concat(u.nombre, ' ', u.apellido) as nombre, u.image, (select count(eu.id) from evidencias_user as eu where eu.id_user = u.id) as conteo from users as u where u.rol_id = 4 and (select count(eu.id) from evidencias_user as eu where eu.id_user = u.id) > 0;");

            $conteoMayor = 0;
            $beta = null;
            foreach($listaBetas as $item){
                if($conteoMayor < $item->conteo) {
                    $conteoMayor = $item->conteo;
                    $nameImage = $item->image;
                    if($nameImage <> null){
                        // $e->image = "test";
                        $dir = '../resources/images/profile-img/'.$item->image;
                        if (file_exists($dir) == false) {
                            $item->image = null;
                        }else{
                            // Extensión de la imagen
                            $type = pathinfo($dir, PATHINFO_EXTENSION);
                            // Cargando la imagen
                            $img = file_get_contents($dir);
                            // Decodificando la imagen en base64
                            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($img);
                            $item->image = $base64;          
                        }
                    }
                    $beta = $item;
                }
            }

            $data = (object)[
                'misFormularios' => $misFormularios[0]->conteo,
                'misEvidencias' => $misEvidencias[0]->conteo,
                'betaRanking' => $beta
            ];
            return response()->json([
                'code' => 200, // success
                'data' => $data
            ], 200);

        }
    }

    // Estadisticas de usuarios en ranking
    public function getEstadisticasHome(Request $request){
        $date = date("Y-m-d H:i:s", time());
        $mes = date("m",strtotime($date));
        $ano = date("Y",strtotime($date));

        $dataAlfas = DB::select("CALL get_estadistica_ranking_prospectos_x_rol_admin(?)", [3]);
        $dataBetas = DB::select("CALL get_estadistica_ranking_prospectos_x_rol_admin(?)", [4]);

        $stringDate = $ano . '-' . $mes . '-01 00:00:00';
        $dataMes = DB::select("CALL get_estadistica_lider_destacado_mes(?)", [$stringDate]);

        $objetoRanking = null;

        foreach($dataMes as $item){
            if($objetoRanking == null) $objetoRanking = $item;
            if($objetoRanking->conteo < $item->conteo) $objetoRanking = $item;
        }

        if($objetoRanking <> null){
            $nameImage = $objetoRanking->image;
            if($nameImage <> null){
                // $e->image = "test";
                $dir = '../resources/images/profile-img/'.$objetoRanking->image;
                if (file_exists($dir) == false) {
                    $objetoRanking->image = null;
                }else{
                    // Extensión de la imagen
                    $type = pathinfo($dir, PATHINFO_EXTENSION);
                    // Cargando la imagen
                    $img = file_get_contents($dir);
                    // Decodificando la imagen en base64
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($img);
                    $objetoRanking->image = $base64;          
                }
            }
        }

        $longitud = count($dataAlfas);
        for ($i = 0; $i < $longitud; $i++) {
            for ($j = 0; $j < $longitud - 1; $j++) {
                if ($dataAlfas[$j]->conteo < $dataAlfas[$j + 1]->conteo) {
                    $temporal = $dataAlfas[$j];
                    $dataAlfas[$j] = $dataAlfas[$j + 1];
                    $dataAlfas[$j + 1] = $temporal;
                }
            }
        }

        $longitud = count($dataBetas);
        for ($i = 0; $i < $longitud; $i++) {
            for ($j = 0; $j < $longitud - 1; $j++) {
                if ($dataBetas[$j]->conteo < $dataBetas[$j + 1]->conteo) {
                    $temporal = $dataBetas[$j];
                    $dataBetas[$j] = $dataBetas[$j + 1];
                    $dataBetas[$j + 1] = $temporal;
                }
            }
        }

        $dataAlfaExport = array();
        $testeo = 0;
        foreach($dataAlfas as $item){
            if($item->conteo > 0 && $item->id <> $objetoRanking->user_id){
                $conteo = 0;
                foreach($dataAlfas as $itemCont){
                    if($item->conteo == $itemCont->conteo && $item <> $itemCont) $conteo++;
                }
                if(count($dataAlfaExport) == 0){
                    array_push($dataAlfaExport, (object)[
                        'id'=>$item->id,
                        'nombre'=>$item->nombre,
                        'image'=>$item->image,
                        'formularios'=>$item->conteo,
                        'coincidencias'=>$conteo
                    ]);
                }elseif($dataAlfaExport[$testeo]->formularios !== $item->conteo){
                    array_push($dataAlfaExport, (object)[
                        'id'=>$item->id,
                        'nombre'=>$item->nombre,
                        'image'=>$item->image,
                        'formularios'=>$item->conteo,
                        'coincidencias'=>$conteo
                    ]);
                    $testeo++;
                }

            }
        }

        $dataBetaExport = array();
        $testeo = 0;
        foreach($dataBetas as $item){
            if($item->conteo > 0 && $item->id <> $objetoRanking->user_id){
                $conteo = 0;
                foreach($dataBetas as $itemCont){
                    if($item->conteo == $itemCont->conteo) $conteo++;
                }
                if(count($dataBetaExport) == 0){
                    array_push($dataBetaExport, (object)[
                        'id'=>$item->id,
                        'nombre'=>$item->nombre,
                        'image'=>$item->image,
                        'formularios'=>$item->conteo,
                        'coincidencias'=>$conteo
                    ]);
                }elseif($dataBetaExport[$testeo]->formularios !== $item->conteo){
                    array_push($dataBetaExport, (object)[
                        'id'=>$item->id,
                        'nombre'=>$item->nombre,
                        'image'=>$item->image,
                        'formularios'=>$item->conteo,
                        'coincidencias'=>$conteo
                    ]);
                    $testeo++;
                }
            }
        }

        $ultimoAlfa = array();
        $ultimoBeta = array();

        if(count($dataAlfaExport) > 3){
            foreach($dataAlfaExport as $key => $item){
                if($key == 0 || $key == 1 || $key == 2){
                    $nameImage = $item->image;
                    if($nameImage <> null){
                        // $e->image = "test";
                        $dir = '../resources/images/profile-img/'.$item->image;
                        if (file_exists($dir) == false) {
                            $item->image = null;
                        }else{
                            // Extensión de la imagen
                            $type = pathinfo($dir, PATHINFO_EXTENSION);
                            // Cargando la imagen
                            $img = file_get_contents($dir);
                            // Decodificando la imagen en base64
                            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($img);
                            $item->image = $base64;          
                        }
                    }
                    array_push($ultimoAlfa, $item);
                }
            }
        }else{
            foreach($dataAlfaExport as $key => $item){
                $nameImage = $item->image;
                if($nameImage <> null){
                    // $e->image = "test";
                    $dir = '../resources/images/profile-img/'.$item->image;
                    if (file_exists($dir) == false) {
                        $item->image = null;
                    }else{
                        // Extensión de la imagen
                        $type = pathinfo($dir, PATHINFO_EXTENSION);
                        // Cargando la imagen
                        $img = file_get_contents($dir);
                        // Decodificando la imagen en base64
                        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($img);
                        $item->image = $base64;          
                    }
                }
            }
            $ultimoAlfa = $dataAlfaExport;
        }

        if(count($dataBetaExport) > 3){
            foreach($dataBetaExport as $key => $item){
                if($key == 0 || $key == 1 || $key == 2) {
                    $nameImage = $item->image;
                    if($nameImage <> null){
                        // $e->image = "test";
                        $dir = '../resources/images/profile-img/'.$item->image;
                        if (file_exists($dir) == false) {
                            $item->image = null;
                        }else{
                            // Extensión de la imagen
                            $type = pathinfo($dir, PATHINFO_EXTENSION);
                            // Cargando la imagen
                            $img = file_get_contents($dir);
                            // Decodificando la imagen en base64
                            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($img);
                            $item->image = $base64;          
                        }
                    }
                    array_push($ultimoBeta, $item);
                }
            }
        }else{
            foreach($dataBetaExport as $key => $item){
                $nameImage = $item->image;
                if($nameImage <> null){
                    // $e->image = "test";
                    $dir = '../resources/images/profile-img/'.$item->image;
                    if (file_exists($dir) == false) {
                        $item->image = null;
                    }else{
                        // Extensión de la imagen
                        $type = pathinfo($dir, PATHINFO_EXTENSION);
                        // Cargando la imagen
                        $img = file_get_contents($dir);
                        // Decodificando la imagen en base64
                        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($img);
                        $item->image = $base64;          
                    }
                }
            }
            $ultimoBeta = $dataBetaExport;
        }

        return response()->json([
            'code' => 200, // success
            'objetoRanking' => $objetoRanking,
            'dataAlfas' => $ultimoAlfa,
            'dataBeta' => $ultimoBeta
        ], 200);

    }

}


?>