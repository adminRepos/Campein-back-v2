<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use PDF;

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
    // if ($body['url'] == "" || $body['url'] == null) {
    //     $mensaje = $mensaje . "El campo url es obligatorio\n";
    // }
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
                "estado" => "401",
                "codigoMensaje" => 0,
                "mensaje" => $mensaje,
            ), 401);
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
              $mensaje = 'Evidencia guardada exitosamente';
              return json_encode(array(
                  "estado" => 200,
                  "codigoMensaje" => 0,
                  "mensaje" => $mensaje,
              ), 201);
          } else {
              $mensaje = 'Ocurrio un fallo guardando su evidencia';
              return json_encode(array(
                  "estado" => 500,
                  "codigoMensaje" => 0,
                  "mensaje" => $mensaje,
              ), 500);
          }
        } else {
          $mensaje = 'Ocurrio un fallo al subir el archivo';
          return json_encode(array(
              "estado" => 500,
              "codigoMensaje" => 0,
              "mensaje" => $mensaje,
          ), 500);
        }
        // return $mensaje;
      } else {
          $mensaje = "Solo se permite archivos .jpg y .png";
          return json_encode(array(
              "estado" => "400",
              "codigoMensaje" => 0,
              "mensaje" => $mensaje,
          ), 400);
      }
    } else {
      return json_encode(array(
          "estado" => "500",
          "codigoMensaje" => 0,
          "mensaje" => $mensaje,
      ));
    }
  }

  public function getUsersEvidencias(Request $request, $id_user){
    $user = User::find(intval($id_user));
    $data = null;
    $queryMeta = DB::select('SELECT meta_evidencias from campeigns where id = 2');
    if($user->rol_id == 2) {$data = DB::select('CALL get_dataTable_users_evidencias_admin(?)', [$user->rol_id]);}
    if($user->rol_id == 3) {$data = DB::select('CALL get_dataTable_users_evidencias(?)', [$user->id]);}

    foreach ($data as $e) {
      $nameImage = $e->image;
      if($nameImage <> null){
        // $e->image = "test";
        $dir = '../resources/images/profile-img/'.$e->image;
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

    return json_encode(array(
      "code" => "200",
      "meta" => $queryMeta[0]->meta_evidencias,
      "data" => $data
    ), 200);
  }

  public function getEvidenciasUsuario(Request $request, $id_user){
    try {

      $dataUser = DB::select("CALL get_data_user_evidencias_one(?);", [intval($id_user)]);
      $data = DB::select("SELECT eu.id, eu.red_social, eu.url, eu.image, eu.created_at, eu.activo FROM evidencias_user AS eu WHERE eu.id_user = ?;", [intval($id_user)]);

      foreach ($data as $e) {
        $nameImage = $e->image;
        if($nameImage <> null){
          // $e->image = "test";
          $dir = '../resources/images/evidencias/'.$e->image;
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

      $dataUserExport = $dataUser[0];

      $nameImage = $dataUserExport->image;
      if($nameImage <> null){
        $dir = '../resources/images/profile-img/'.$dataUserExport->image;
        if (file_exists($dir) == false) {
          $dataUserExport->image = null;
        }else{
          // Extensión de la imagen
          $type = pathinfo($dir, PATHINFO_EXTENSION);
          // Cargando la imagen
          $img = file_get_contents($dir);
          // Decodificando la imagen en base64
          $base64 = 'data:image/' . $type . ';base64,' . base64_encode($img);
          $dataUserExport->image = $base64;          
        }
      }

      return json_encode(array(
        "code" => "200",
        "data" => $data,
        "dataUser" => $dataUserExport
      ), 200);
    } catch (\Throwable $th) {
      return json_encode(array(
        "code" => "500",
        "message" => "Error interno del servidor",
        "error" => $th
      ), 200);
    }
  }


  //reporte de evidencias por 1 usuario
  public function getReporteEvidenciasUsuario(Request $request, $id_user){
    try {
      $data = null;

      $datosUser = DB::select("SELECT concat(u.nombre, ' ', u.apellido) as nombre, r.nombre_publico as rol from users as u inner join roles as r on r.id = u.rol_id where u.id = ? limit 1;", [intval($id_user)]);

      $data = DB::select("SELECT eu.id, eu.red_social, eu.url, eu.created_at, eu.activo FROM evidencias_user AS eu WHERE eu.id_user = ?;", [intval($id_user)]);

      $user = array((object)[
        'nombre' => $datosUser[0]->nombre,
        'rol' => $datosUser[0]->rol,
        'evidencias' => count($data)
      ]);
      $dir = '../resources/images/pdfImages/logo-campein.png';
      $type = pathinfo($dir, PATHINFO_EXTENSION);
      $img = file_get_contents($dir);
      $base64 = 'data:image/' . $type . ';base64,' . base64_encode($img);

      $dir2 = '../resources/images/pdfImages/circle-user.svg';
      $type2 = pathinfo($dir2, PATHINFO_EXTENSION);
      $img2 = file_get_contents($dir2);
      $base64_2 = 'data:image/' . $type2 . ';base64,' . base64_encode($img2);
      $date = date('d/m/Y - H:m');

      $parametrosPDF = [
        'user'=>$user, 
        'data' => $data, 
        'i'=> 0, 
        'imagePDF1' => $base64, 
        'imagePDF2'=> $base64_2,
        'date' => $date
      ];

      $pdf = PDF::loadView('reporte-evidencias-usuario-mobile-pdf',$parametrosPDF )->setPaper('a4', 'landscape');;

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

  //reporte de evidencias completo
  public function getReporteEvidencias(Request $request, $id_user){
    try {
      $data = null;

      $datosUser = DB::select("SELECT concat(u.nombre, ' ', u.apellido) as nombre, r.nombre_publico as rol, r.jerarquia, r.campeigns_id from users as u inner join roles as r on r.id = u.rol_id where u.id = ? limit 1;", [intval($id_user)]);

      if($datosUser[0]->jerarquia == 1){
        $data = DB::select("SELECT 
                          eu.id, 
                          eu.red_social, 
                          eu.url, 
                          eu.created_at, 
                          eu.activo,
                          CONCAT(u.nombre, ' ', u.apellido) as nombre,
                          r.nombre_publico as rol
                          FROM evidencias_user AS eu 
                              inner join users as u on u.id = eu.id_user
                              inner join roles as r on r.id = u.rol_id
                              inner join campeigns as c on c.id = r.campeigns_id
                          where c.id = ?;", 
        [$datosUser[0]->campeigns_id]);
      } else $data = DB::select("SELECT 
        eu.id, 
        eu.red_social, 
        eu.url, 
        eu.created_at, 
        eu.activo,
        CONCAT(u.nombre, ' ', u.apellido) as nombre,
        r.nombre_publico as rol
        FROM evidencias_user AS eu 
            inner join users_users as d on d.menor = eu.id_user
            inner join users as u on u.id = eu.id_user
            inner join roles as r on r.id = u.rol_id
        WHERE d.mayor = ?;", [intval($id_user)]); 
      

      $user = array((object)[
        'nombre' => $datosUser[0]->nombre,
        'rol' => $datosUser[0]->rol,
        'evidencias' => count($data)
      ]);


      $dir = '../resources/images/pdfImages/logo-campein.png';
      $type = pathinfo($dir, PATHINFO_EXTENSION);
      $img = file_get_contents($dir);
      $base64 = 'data:image/' . $type . ';base64,' . base64_encode($img);

      $dir2 = '../resources/images/pdfImages/circle-user.svg';
      $type2 = pathinfo($dir2, PATHINFO_EXTENSION);
      $img2 = file_get_contents($dir2);
      $base64_2 = 'data:image/' . $type2 . ';base64,' . base64_encode($img2);
      $date = date('d/m/Y - H:m');

      $parametrosPDF = [
        'user'=>$user, 
        'data' => $data, 
        'i'=> 0, 
        'imagePDF1' => $base64, 
        'imagePDF2'=> $base64_2,
        'date' => $date
      ];

      $pdf = PDF::loadView('reporte-evidencias-total-mobile-pdf', $parametrosPDF)->setPaper('a4', 'landscape');

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

  // get_report_xls_evidencias_x_usuario
  public function getXlsEvidencias(Request $request, $id_user, $isLeader){
    try {
      $query = null;
      if($isLeader == 0){
        $query = DB::select("SELECT 
            e.red_social,
            e.url,
            e.image,
            e.created_at
          from evidencias_user as e 
          where e.id_user = ?;", [intval($id_user)]);
      }else{
        $user = User::find(intval($id_user));
        if($user->rol_id == 2){
          $query = DB::select("SELECT 
            concat(u.nombre, ' ', u.apellido) as user,
            e.red_social,
            e.url,
            e.image,
            e.created_at
          from evidencias_user as e
          inner join users as u on u.id = e.id_user
          inner join roles as r on r.id = u.rol_id
          where r.campeigns_id = 2 and r.id <> 2;");
        }else{
          $query = DB::select("SELECT 
            concat(u.nombre, ' ', u.apellido) as user,
            e.red_social,
            e.url,
            e.image,
            e.created_at
          from evidencias_user as e
          inner join users as u on u.id = e.id_user
          inner join users_users as uu on uu.menor = e.id_user
          where uu.mayor = ?;", [intval($id_user)]);
        }
      }
      // $query = DB::select("CALL get_report_xls_evidencias_x_usuario(?);", [intval($id_user)]);
      return json_encode(array(
        "code" => "200",
        "data" => $query,
      ), 200);
    } catch (\Throwable $th) {
      return json_encode(array(
        "code" => "500",
        "message" => "Error interno del servidor",
        "error" => $th
      ), 500);
    }
  }


}