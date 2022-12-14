<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Noticias;
use App\Models\User;

class NoticiasController extends Controller
{
    public function insertNoticia(Request $request){
        try {
            $body = $_REQUEST;
            $files = $_FILES;
            $dest_path = "";
    
            if($body["id_user_send"] == null || $body["id_user_send"] == ""){ // Validacion del usuario
                return response()->json([
                    'code' => 400, // error bad request
                    'message' => "Error de usuario",
                ], 400);
            }
            if($body["titulo"] == null || $body["titulo"] == ""){ // Validacion del titulo
                return response()->json([
                    'code' => 400, // error bad request
                    'message' => "Debe ingresar un titulo",
                ], 400);
            }
            if($body["mensaje"] == null || $body["mensaje"] == ""){ // Validacion del mensaje
                return response()->json([
                    'code' => 400, // error bad request
                    'message' => "Debe ingresar un mensaje",
                ], 400);
            }
            if($files == null || $files == []) { // Validacion de imagen
                return response()->json([
                    'code' => 400, // error bad request
                    'message' => "Debe cargar una imagen",
                ], 400);
            }
            if($body["url"] == null || $body["url"] == "") $url = null;
            else $url = $body["url"];
            
            $user = User::find(intval($body['id_user_send']));
            $rol_id = $user->rol_id;
            // $campeign = DB::select("select campeigns_id from roles where id = $rol_id;");


            $numero = DB::select('SELECT COUNT(*) as conteo FROM noticias;');
            $se_movio = false;
            $nombre_archivo = $files['image']['name'];
            $tipo_archivo = $files['image']['type'];
            $tamano_archivo = $files['image']['size'];
            $j = array_search($tipo_archivo, array(
                'jpg' => 'image/jpeg',
                'png' => 'image/png',
            ));
            if ($j != "") {
                $bool = true;
                // Ciclo while para asegurarnos que no se repita el nombre del archivo para no generar errores al moverlo
                while ($bool == true) {
                    // generacion de nuevo nombre compuesto de la identificacion del usuario y de una encriptacion de la fecha y hora, y la extencion del archivo
                    $newName = $body['id_user_send'] . '-noticia-' . $numero[0]->conteo + 1 . '-' . md5(date("Y-m-d H:i:s")) . '.' . $j;
                    $uploadFileDir = '../resources/images/noticias/';
                    $dest_path = $uploadFileDir . $newName;
                    if (file_exists($dest_path) == false) {
                        $bool = false;
                    }
                }
                if (move_uploaded_file($files['image']['tmp_name'], $dest_path)) {
                    $se_movio = true;
                }else{
                    $se_movio = false;
                }
            }else{
                return response()->json([
                  'code' => 400, // warning
                  'message' => 'Solo se permite archivos .jpg y .png',
                  'error' => 'Error formato'
                ], 400);
            }

            if($se_movio == true){ // camino correcto
                $respuesta = DB::select(
                    'CALL insertNoticia (?, ?, ?, ?, ?);', 
                    [$body['id_user_send'], $body['titulo'], $body['mensaje'], $url, $newName]
                );
                if($respuesta[0]->id){
                return response()->json([
                    'code' => 200, // warning
                    'message' => 'Se registro correctamente la noticia'
                ], 200);
                }else{
                return response()->json([
                    'code' => 500, // warning
                    'message' => 'Hubo un fallo al registrar la noticia en base de datos',
                    'error' => 'Error SQL'
                ], 500);
                }
            }else{ // Error al mover el archivo
                return response()->json([
                    'code' => 500, // success
                    'message' => "Error al subir el archivo al servidor",
                    'error' => "Carga de archivo"
                ], 500);
            } 
    

        } catch (\Throwable $th) {
            return response()->json([
                'code' => 500, // Internal server error
                'message' => "Error interno del servidor",
                'error' => $th
            ], 500);
        }


    }

    public function selectNoticias(Request $request)
    {
        $id = intval($request->id_user);
        return response()->json([
            'data' => DB::select('CALL get_noticias_x_campeign(?)', [$id]),
          ], 200);
    }
}