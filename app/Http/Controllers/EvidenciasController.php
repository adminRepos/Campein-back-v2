<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

/**
 * Controlador de las evidencias
 *
 * @author Victor Vivas
 */
class EvidenciasController extends Controller
{
  public function insertEvidencia(){
    // Capturar request
    $body = $_REQUEST;
    $files = $_FILES;

    // Validaciones de campos del request
    $mensaje = "";
    if ($body['idUser'] == "" || $body['idUser'] == null) {
        $mensaje = "Error de usuario\n";
    }
    if ($files == null || $files == []) {
        $mensaje = $mensaje . "No se ha cargado algun archivo\n";
    }
    if ($body['url'] == "" || $body['url'] == null) {
        $mensaje = $mensaje . "El campo url es obligatorio\n";
    }
    if ($body['red_social'] == "" || $body['red_social'] == null) {
        $mensaje = $mensaje . "El campo red_social es obligatorio\n";
    }

    // Validacion de mensajes de error
    if ($mensaje == "") {
      $idUser = intVal($body['idUser']);
      // Objeto de base de datos
      // $db = DatabaseConnection::getInstance()->getDb(); //

      // Datos del arhivo
      $nombre_archivo = $files['image']['name'];
      $tipo_archivo = $files['image']['type'];
      $tamano_archivo = $files['image']['size'];

      // return json_encode(array(
      //     "tipo_archivo" => $tipo_archivo,
      //     "tamano_archivo" => $tamano_archivo,
      //     "nombre_archivo" => $nombre_archivo
      // ));

      $j = array_search($tipo_archivo, array(
          'jpg' => 'image/jpeg',
          'png' => 'image/png',
      ));

      // return $j;

      if ($j != "") {
        // Traer el nombre o identificacion del usuario para anadirlo al nombre del archivo
        // $query = $db->prepare("SELECT identificacion FROM usuario WHERE idUsuario = ? LIMIT 1;"); //
        $query = DB::select("SELECT identificacion FROM users WHERE id = $idUser LIMIT 1;");
        // $query->execute([$body['idUser']]); //
        if (count($query) == 0) { //
            $mensaje = "Error de usuario";
            return json_encode(array(
                "estado" => "200",
                "codigoMensaje" => 0,
                "mensaje" => $mensaje,
            ));
        }
        // $data = $query->fetch(); //
        // $identificacion = $data['identificacion'];
        $identificacion = $query[0]->identificacion;
        $bool = true;
        // Ciclo while para asegurarnos que no se repita el nombre del archivo para no generar errores al moverlo
        while ($bool == true) {
            // generacion de nuevo nombre compuesto de la identificacion del usuario y de una encriptacion de la fecha y hora, y la extencion del archivo
            $newName = $identificacion . '-' . md5(date("Y-m-d H:i:s")) . '.' . $j;
            $uploadFileDir = '../resources/images/evidencias/';
            $dest_path = $uploadFileDir . $newName;
            if (file_exists($dest_path) == false) {
              $bool = false;
            }
        }

        if (move_uploaded_file($files['image']['tmp_name'], $dest_path)) {
          $datos = array(
              'url' => $body['url'],
              'red_social' => $body['red_social'],
              'image' => $newName,
              'id_user' => intVal($body['idUser']),
          );
          // $respuesta = Insertaintenciones::guardarEvidencias($datos);
          $respuesta = DB::insert('insert into evidencias_user (url,red_social,image,id_user) values (?, ?, ?, ?)', [$body['url'], $body['red_social'], $newName, $idUser]);
          if ($respuesta) {
              $mensaje = 'Su evidencia se a guardado correctamente';
              return json_encode(array(
                  "estado" => "200",
                  "codigoMensaje" => 0,
                  "mensaje" => $mensaje,
              ));
          } else {
              $mensaje = 'Ocurrio un fallo guardando su evidencia';
              return json_encode(array(
                  "estado" => "500",
                  "codigoMensaje" => 0,
                  "mensaje" => $mensaje,
              ));
          }
        } else {
          $mensaje = 'Ocurrio un fallo al subir el archivo';
          return json_encode(array(
              "estado" => "500",
              "codigoMensaje" => 0,
              "mensaje" => $mensaje,
          ));
        }
        // return $mensaje;
      } else {
          $mensaje = "Solo se permite archivos .jpg y .png";
          return json_encode(array(
              "estado" => "200",
              "codigoMensaje" => 0,
              "mensaje" => $mensaje,
          ));
      }
    } else {
      return json_encode(array(
          "estado" => "200",
          "codigoMensaje" => 0,
          "mensaje" => $mensaje,
      ));
    }
  }


}