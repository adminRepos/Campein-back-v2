<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\UserRegisterRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Mail\CorreoElectronico;
use Illuminate\Support\Facades\Mail;

class UsuarioController extends Controller
{

  public function insertUser(Request $request){
    // $body = $request;
    $body = $_REQUEST;
    $files = $_FILES;
    $dest_path = "";
    $validacionCampos = self::validarCamposUser($body, 'insert');
    if(is_bool($validacionCampos)){
      $validacionEmail = User::where('email', '=', $body['email'])->first();
      $validacionIdentificacion = User::where('identificacion', '=', $body['identificacion'])->first();
      if($validacionEmail == null && $validacionIdentificacion == null){
        // if(intval($body['rol_id']) == 4) $userSession = User::find(intval($body['id_user_session']));
        if ($files == null || $files == []) {
          $dest_path = null;
          $newUser = User::create([
            'rol_id' => intval($body['rol_id']),
            'email' => $body['email'],
            'password' => Hash::make($body['password']),
            'telefono' => $body['telefono'],
            'identificacion' => $body['identificacion'],
            'tipo_documento' => $body['tipo_documento'],
            'genero' => $body['genero'],
            'nombre' => $body['nombre'],
            'apellido' => $body['apellido'],
            'direccion' => $body['direccion'],
            'whatsapp' => $body['whatsapp'],
            'activo' => 1,
            'fecha_nacimiento' => $body['fecha_nacimiento'],
            'image' => $dest_path
          ]);
          // $insert = User::where('email', '=', $body['email']);
          if(intval($body['rol_id']) == 4) $query = DB::select("INSERT INTO users_users (mayor, menor) VALUES (?, ?);", [intval($body['id_user_session']), intval($newUser->id)]);
          Mail::to($newUser->email)->send(new CorreoElectronico('0',($newUser->nombre . ' ' . $newUser->apellido), 'registroUsuario', $newUser->email, $body['password'], ''));
          return response()->json([
            'code' => 201, // success
            'data' => $newUser,
          ], 201);
        }else{
          $nombre_archivo = $files['image']['name'];
          $tipo_archivo = $files['image']['type'];
          $tamano_archivo = $files['image']['size'];

          $j = array_search($tipo_archivo, array(
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
          ));
          if ($j != "") {
            $bool = true;
            $newName = "";
            // Ciclo while para asegurarnos que no se repita el nombre del archivo para no generar errores al moverlo
            while ($bool == true) {
              // generacion de nuevo nombre compuesto de la identificacion del usuario y de una encriptacion de la fecha y hora, y la extencion del archivo
              $newName = $body['identificacion'] . '-perfil-' . md5(date("Y-m-d H:i:s")) . '.' . $j;
              $uploadFileDir = '../resources/images/evidencias/';
              $dest_path = $uploadFileDir . $newName;
              if (file_exists($dest_path) == false) {
                $bool = false;
              }
            }

            if (move_uploaded_file($files['image']['tmp_name'], $dest_path)) {
              $newUser = User::create([
                'rol_id' => intval($body['rol_id']),
                'email' => $body['email'],
                'password' => Hash::make($body['password']),
                'telefono' => $body['telefono'],
                'identificacion' => $body['identificacion'],
                'tipo_documento' => $body['tipo_documento'],
                'genero' => $body['genero'],
                'nombre' => $body['nombre'],
                'apellido' => $body['apellido'],
                'direccion' => $body['direccion'],
                'whatsapp' => $body['whatsapp'],
                'activo' => 1,
                'fecha_nacimiento' => $body['fecha_nacimiento'],
                'image' => $newName
              ]);
              // $insert = User::where('email', '=', $body['email']);
              if(intval($body['rol_id']) == 4) $query = DB::select("INSERT INTO users_users (mayor, menor) VALUES (?, ?);", [intval($body['id_user_session']), intval($newUser->id)]);
              Mail::to($newUser->email)->send(new CorreoElectronico('0',($newUser->nombre . ' ' . $newUser->apellido), 'registroUsuario', $newUser->email, $body['password'], ''));
              return response()->json([
                'code' => 201, // success
                'data' => $newUser,
              ], 201);
            }else{
              return response()->json([
                'code' => 500, // danger
                'message' => 'Ocurrio un fallo al subir el archivo',
                'error' => 'Carga archivo'
              ], 200);
            }
          }else{
            return response()->json([
              'code' => 400, // warning
              'message' => 'Solo se permite archivos .jpg y .png',
              'error' => 'Error formato'
            ], 200);
          }
        }
      }else{
        if($validacionEmail <> null){
          return response()->json([
            'code' => 400, // warning
            'message' => 'El email ingresado ya existe en el sistema',
            'error' => 'Email existente'
          ], 200);
        }
        if($validacionIdentificacion <> null){
          return response()->json([
            'code' => 400, // warning
            'message' => 'la identificacion ya existe en la base de datos',
            'error' => 'Identificacion existente'
          ], 200);
        }
      }
    }else{
      return response()->json([
        'code' => 404, // warning
        'message' => $validacionCampos,
        'error' => 'Validacion de campos'
      ], 200);
    }
  }

  public function updateUser(Request $request){
    // $body = $request;
    $body = $_REQUEST;
    // var_dump($body);
    $files = $_FILES;
    $dest_path = "";
    $validacionCampos = self::validarCamposUser($body, 'update');
    if(is_bool($validacionCampos)){
      $validacion = User::where('email', '=', $body['email'])->orWhere('identificacion', '=', $body['identificacion'])->first();
      // $validacionIdentificacion = User::where('identificacion', '=', $body['identificacion'])->first();
      $user = User::find(intval($body['id']));
      if($validacion->id == $user->id){
        if ($files == null || $files == []) {
          $dest_path = null;
          $user->rol_id = intval($body['rol_id']);
          $user->email = $body['email'];
          $user->telefono = $body['telefono'];
          $user->identificacion = $body['identificacion'];
          $user->tipo_documento = $body['tipo_documento'];
          $user->genero = $body['genero'];
          $user->nombre = $body['nombre'];
          $user->apellido = $body['apellido'];
          $user->direccion = $body['direccion'];
          $user->whatsapp = $body['whatsapp'];
          $user->activo = 1;
          $user->fecha_nacimiento = $body['fecha_nacimiento'];
          $user->image = $dest_path;
          $user->save();
          return response()->json([
            'code' => 201, // success
            'data' => $user,
          ], 201);
        }else{
          $nombre_archivo = $files['image']['name'];
          $tipo_archivo = $files['image']['type'];
          $tamano_archivo = $files['image']['size'];

          $j = array_search($tipo_archivo, array(
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
          ));
          if ($j != "") {
            $bool = true;
            $newName = "";
            // Ciclo while para asegurarnos que no se repita el nombre del archivo para no generar errores al moverlo
            while ($bool == true) {
              // generacion de nuevo nombre compuesto de la identificacion del usuario y de una encriptacion de la fecha y hora, y la extencion del archivo
              $newName = $body['identificacion'] . '-perfil-' . md5(date("Y-m-d H:i:s")) . '.' . $j;
              $uploadFileDir = '../resources/images/evidencias/';
              $dest_path = $uploadFileDir . $newName;
              if (file_exists($dest_path) == false) {
                $bool = false;
              }
            }

            if (move_uploaded_file($files['image']['tmp_name'], $dest_path)) {
              $user->rol_id = intval($body['rol_id']);
              $user->email = $body['email'];
              $user->telefono = $body['telefono'];
              $user->identificacion = $body['identificacion'];
              $user->tipo_documento = $body['tipo_documento'];
              $user->genero = $body['genero'];
              $user->nombre = $body['nombre'];
              $user->apellido = $body['apellido'];
              $user->direccion = $body['direccion'];
              $user->whatsapp = $body['whatsapp'];
              $user->activo = intval($body['activo']);
              $user->fecha_nacimiento = $body['fecha_nacimiento'];
              $user->image = $dest_path;
              $user->save();
              return response()->json([
                'code' => 201, // success
                'data' => $user,
              ], 201);
            }else{
              return response()->json([
                'code' => 500, // danger
                'message' => 'Ocurrio un fallo al subir el archivo',
                'error' => 'Carga archivo'
              ], 500);
            }
          }else{
            return response()->json([
              'code' => 404, // warning
              'message' => 'Solo se permite archivos .jpg y .png',
              'error' => 'Error formato'
            ], 200);
          }
        }
      }else{
        // if($validacion <> null){
          return response()->json([
            'code' => 404, // warning
            'message' => 'El email y/o identificacion ingresado ya existe en el sistema',
            'error' => 'Email existente'
          ], 200);
        // }
        // if($validacionIdentificacion <> null){
        //   return response()->json([
        //     'code' => 404, // warning
        //     'message' => 'El usuario está registrado en la base de datos',
        //     'error' => 'Identificacion existente'
        //   ], 200);
        // }
      }
    }else{
      return response()->json([
        'code' => 404, // warning
        'message' => $validacionCampos,
        'error' => 'Validacion de campos'
      ], 200);
    }
  }

  public function activarUser(Request $request){
    try {
      //code...
      $id = intval($request->id);
      $user = User::find($id);
      if($user->activo == 1) $user->activo = 0;
      else if($user->activo == 0) $user->activo = 1;
      $user->save();
      DB::select('CALL update_user_activo('.$id.')');
      return response()->json([
        'code' => 200,
        'message' => "Se modifico el estado del usuario y sus registros de prospectos y evidencias.",
      ], 200);
      
    } catch (\Throwable $th) {
      return response()->json([
        'code' => 500, // Internal server error
        'message' => "Error interno del servidor",
        'error' => $th
      ], 500);
    }
  }

  public function activarUserData(Request $request){
    try {
      //code...
      $id = intval($request->id);
      $user = User::find($id);
      if($user->activo == 1) $user->activo = 0;
      else if($user->activo == 0) $user->activo = 1;
      $user->save();
      DB::select('CALL update_user_activo('.$id.')');
      DB::select('CALL update_user_activo_users('.$id.')');
      return response()->json([
        'code' => 200,
        'message' => "Se modifico el estado del usuario y sus registros de usuarios, prospectos y evidencias.",
      ], 200);
    } catch (\Throwable $th) {
      return response()->json([
        'code' => 500, // Internal server error
        'message' => "Error interno del servidor",
        'error' => $th
      ], 500);
    }
  }

  public function getUser(Request $request){
    // $id = $request->post('id');
    $id = intval($request->id);
    return response()->json([
      'data' => DB::select('CALL sp_get_user('.$id.')'),
    ], 200);
  }

  public function getUsers(Request $request){
    $rol_id = intval($request->rol_id);
    if($rol_id == 1){
      return response()->json([
        'data' => DB::select('CALL sp_get_users_super()'),
      ], 200);
    }else{
      return response()->json([
        'data' => DB::select('CALL sp_get_users_campeing('.$rol_id.')'),
      ], 200);
    }
  }

  public function getUsersTable(Request $request){
    $rol_id = intval($request->rol_id);
    $id = intval($request->id);
    return response()->json([
      'data' => DB::select('CALL get_users_x_rol('.$rol_id.','.$id.')'),
    ], 200);
  }

  public function getPrivilegios(Request $request){
    $rol_id = $request->post('rol_id');
    return response()->json([
      'data' => DB::select('CALL sp_privilegios_usuario('.$rol_id.')'),
    ], 200);
  }
  
  public function getRoles(Request $request){
    return response()->json([
      'data' => Role::all()
    ], 200);
  }

  public function getRolesCampeign(Request $request, $rol_id){
    // $rol_id = $request->get('rol_id');
    return response()->json([
      'data' => DB::select('CALL sp_get_roles_x_campeigns('.$rol_id.')'),
    ], 200);
  }

  private function validarCamposUser($body, $peticion){
    
    if($body["id_user_session"] == "" || $body["id_user_session"] == null){ // || !is_int($body["rol_id"])
      return "Debe enviar el id del usuario en sesion";
    }
    if($body["rol_id"] == "" || $body["rol_id"] == null){ // || !is_int($body["rol_id"])
      return "Debe seleccionar el rol";
    }
    if($body["email"] == "" || $body["email"] == null){
      return "Debe ingresar el email";
    }
    // elseif(strlen($body["email"]) > 60){
    //   return "El email no puede superar los 60 caracteres";
    // }
    if($peticion == 'insert'){

      if($body["password"] == "" || $body["password"] == null){
        return "Debe ingresar una contraseña";
      }elseif(strlen($body["password"]) < 5){
        return "La contraseña debe contener como minimo 5 caracteres";
      }

      if($body["password_again"] == "" || $body["password_again"] == null){
        return "Debe ingresar la confirmacion de la contraseña";
      }elseif($body["password"] !== $body["password_again"]){
        return "Las contraseñas deben coincidir";
      }
    }
    if($body["telefono"] == "" || $body["telefono"] == null){
      return "Debe ingresar un numero telefononico";
    }
    // elseif(strlen($body["telefono"]) < 5 || strlen($body["telefono"]) > 16){
    //   return "El telefono debe contener como minimo 5 caracteres y como maximo 16 caracteres";
    // }
    if($body["identificacion"] == "" || $body["identificacion"] == null){
      return "Debe ingresar el numero identificacion";
    }
    // elseif(strlen($body["identificacion"]) < 5 || strlen($body["identificacion"]) > 16){
    //   return "La identificacion debe contener como minimo 5 caracteres y como maximo 16 caracteres numericos";
    // }
    if($body["tipo_documento"] == "" || $body["tipo_documento"] == null){
      return "Debe ingresar el tipo de documento";
    }

    if($body["genero"] == "" || $body["genero"] == null){
      return "Debe ingresar un genero";
    }elseif(strlen($body["genero"]) > 1){
      return "El genero debe contener unicamente 1 caracter";
    }

    // if(strlen($body["nombre"]) > 35){
    //   return "El nombre debe contener maximo 35 caracteres";
    // }
    // if(strlen($body["apellido"]) > 35){
    //   return "El nombre debe contener maximo 35 caracteres";
    // }
    // if(strlen($body["direccion"]) > 120){
    //   return "La direccion debe contener maximo 120 caracteres";
    // }
    // if(strlen($body["whatsapp"]) > 120){
    //   return "El whatsapp debe contener maximo 16 caracteres";
    // }
    return true;

  }

  public function getMyUsersActivos(Request $request, $rol_id, $myId){
    $data = [];
    if($rol_id == 1){

    } else if($rol_id == 2){
      $data = DB::select('CALL sp_get_users_campeing('.$rol_id.')');
    } else{
      $data = DB::select('CALL sp_get_my_users('.$myId.')');
    }
    $newData = [];
    foreach($data as $e){
      if($e->activo == 1) array_push($newData, $e);
    }
    // var_dump($data);
    foreach ($newData as $e) { 
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
    return response()->json([
      'data' => $newData,
    ], 200);
  }

  public function getMyUsers(Request $request, $rol_id, $myId){
    $data = [];
    if($rol_id == 1){

    } else if($rol_id == 2){
      $data = DB::select('CALL sp_get_users_campeing('.$rol_id.')');
    } else{
      $data = DB::select('CALL sp_get_my_users('.$myId.')');
    }
    // var_dump($data);
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
    $queryMeta = DB::select("SELECT meta from campeigns where id = 2;");
    return response()->json([
      'code' => 200,
      'data' => $data,
      'meta' => $queryMeta[0]->meta
    ], 200);
  }

  public function getUsersAlfa(Request $request, $id_user){
    $user = User::find($id_user);
    if($user->rol_id == 2){
      $data = DB::select('CALL select_alfas_admin()');
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
      return response()->json([
        'data' => $data,
      ], 200);
    }else{
      return response()->json([
        'data' => "Un lider alfa no puede ver los demas lideres alfa",
      ], 200);
    }
  }
  
  public function getUsersAlfaData(Request $request, $id_user){
    $user = User::find($id_user);
    if($user->rol_id == 2){
      $data = DB::select("SELECT concat(nombre, ' ', apellido) as nombre, id FROM users where (rol_id = 3)");
      return response()->json([
        'data' => $data,
      ], 200);
    }else{
      return response()->json([
        'data' => "Un lider alfa no puede ver los demas lideres alfa",
      ], 200);
    }
  }

  public function getUsersBeta(Request $request, $id_user){
    $user = User::find($id_user);
    if($user->rol_id == 2){
      $queryMeta = DB::select('SELECT meta FROM campeigns where id = 2;');
      $meta = $queryMeta[0]->meta;
      $data = DB::select('CALL select_betas_admin()');
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
      return response()->json([
        'meta' => $meta,
        'data' => $data,
      ], 200);
    }else{
      $queryMeta = DB::select('SELECT meta FROM campeigns where id = 2;');
      $meta = $queryMeta[0]->meta;
      $data = DB::select('CALL sp_get_my_users('.$id_user.')');
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
      return response()->json([
        'meta' => $meta,
        'data' => $data,
      ], 200);
    }
  }


  public function getUserGestion(Request $request, $id_user){
    try {
      $dataUser = DB::select("SELECT 
          u.id,
          u.activo,
              concat(u.nombre, ' ', u.apellido) as nombre_user,
          u.email,
              r.nombre_publico as rol,
              (select count(b.id) from prospectos as b where b.user_id = u.id) as numero_formularios,
              u.image
        from users as u
          inner join roles as r on r.id = u.rol_id
        where u.id = ?", [intval($id_user)]
      );
      $prospectos = DB::select("SELECT concat(p.primer_nombre, ' ', p.primer_apellido) as nombre, p.tipo_documento, p.identificacion, p.email, p.telefono, p.localidad from prospectos as p where p.user_id = ?;", [intval($id_user)]
      );

      foreach ($dataUser as $e) {
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
      $queryMeta = DB::select("SELECT meta from campeigns where id = 2;");
      return response()->json([
        'code' => 200,
        'meta' => $queryMeta[0]->meta,
        'dataUser' => $dataUser,
        'prospectos' => $prospectos,
      ], 200);
    } catch (\Throwable $th) {
      return response()->json([
        'code' => 500, // warning
        'message' => "Error interno del servidor",
        'error' => $th 
      ], 500);
    }


  }

  public function upAlfa(Request $request, $id_user){
    try {
      $user = User::find($id_user);
      $message = '';
      $code = 0;
      if($user->rol_id == 4){
        $user->rol_id = 3;
        $user->save();
        $message = 'Usuario ascendido exitosamente';
        $code = 200;
      }else{
        $message = 'El usuario no puede ser modificado';
        $code = 400;
      }
      return response()->json([
        'code' => $code,
        'message' => $message
      ], $code);
    } catch (\Throwable $th) {
      return response()->json([
        'code' => 500,
        'message' => 'Error interno del servidor',
        'error' => $th
      ], 500);
    }
  }

}
