<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Notificaciones;

class NotificacionesController extends Controller
{
  public function insertNotificaciones(Request $request){
    // $body = $request;
    $body = $_REQUEST;
    $files = $_FILES;

    $dest_path = "";

    $validacionCampos = self::validarCamposInsert($body);
    if (is_bool($validacionCampos)) {
      $numero = DB::select('SELECT COUNT(*) as conteo FROM notificaciones;');
      $se_movio = false;
      $newName = "";
      if ($files == null || $files == []) {
        $se_movio = true;
        $dest_path = null;
      } else {
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
            $newName = $body['id_user_send'] . '-notificacion-' . $numero[0]->conteo + 1 . '-' . md5(date("Y-m-d H:i:s")) . '.' . $j;
            $uploadFileDir = '../resources/images/notificaciones/';
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
      }

      if($se_movio == true){
        // return response()->json([
        //   'code' => 200, // warning
        //   'message' => 'Bonitico',
        // ], 200);
        $respuesta = DB::select(
          'CALL insertNotificaciones (?, ?, ?, ?, ?, ?);', 
          [$body['id_user_send'], $newName, $body['titulo'], $body['mensaje'], $body['tipo_user'], $body['url']]
        );
        if($respuesta[0]->id){
          return response()->json([
            'code' => 200, // warning
            'message' => 'Se registro correctamente'
          ], 200);
        }else{
          return response()->json([
            'code' => 500, // warning
            'message' => 'Oops',
            'error' => 'Error SQL'
          ], 500);
        }

      }else{
        return response()->json([
          'code' => 500, // warning
          'message' => 'Ocurrio un fallo subiendo el archivo al servidor',
          'error' => 'Error carga de archivo'
        ], 500);
      }
    } else {
      return response()->json([
        'code' => 400, // warning
        'message' => $validacionCampos,
        'error' => 'Validación de campos'
      ], 400);
    }
  }
  
  private function validarCamposInsert($body){
    return true;
  }
  
  public function getNotificacionesTemp(Request $request){
    try {
      //code...
      $data = DB::select('CALL get_notificaciones_temp()');
      foreach ($data as $e) {
        $nameImage = $e->image;
        if($nameImage <> null){
          // $e->image = "test";
          $dir = '../resources/images/notificaciones/'.$e->image;
          if (file_exists($dir) == false) {
            $e->image = null;
          }else{
            // Extensión de la imagen
            $type = pathinfo($dir, PATHINFO_EXTENSION);
            // Cargando la imagen
            $img = file_get_contents($dir);
            // Decodificando la imagen en base64
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($img);
            $e->image = $base64;          
          }
        }
      }
      return response()->json([
        'code' => 200, // warning
        'data' => $data
      ], 200);
    } catch (\Throwable $th) {
      return response()->json([
        'code' => 500, // warning
        'message' => 'Error interno del servidor',
        'error' => $th
      ], 500);
    }
  }
}
