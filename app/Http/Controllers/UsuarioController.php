<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\UserRegisterRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{

  public function insertUser(Request $request){
    // $body = $request;
    $body = $_REQUEST;
    $files = $_FILES;
    $dest_path = "";
    $validacionCampos = self::validarCamposInsertUser($body);
    if(is_bool($validacionCampos)){
      $validacionEmail = User::where('email', '=', $body['email'])->first();
      $validacionIdentificacion = User::where('identificacion', '=', $body['identificacion'])->first();
      if($validacionEmail == null && $validacionIdentificacion == null){
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
              return response()->json([
                'code' => 201, // success
                'data' => $newUser,
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
        if($validacionEmail <> null){
          return response()->json([
            'code' => 404, // warning
            'message' => 'El email ingresado ya existe en el sistema',
            'error' => 'Email existente'
          ], 200);
        }
        if($validacionIdentificacion <> null){
          return response()->json([
            'code' => 404, // warning
            'message' => 'El usuario está registrado en la base de datos',
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

  private function validarCamposInsertUser($body){
    
    if($body["rol_id"] == "" || $body["rol_id"] == null){ // || !is_int($body["rol_id"])
      return "Debe seleccionar el rol";
    }
    if($body["email"] == "" || $body["email"] == null){
      return "Debe ingresar el email";
    }
    // elseif(strlen($body["email"]) > 60){
    //   return "El email no puede superar los 60 caracteres";
    // }
    if($body["password"] == "" || $body["password"] == null){
      return "Debe ingresar una contraseña";
    }elseif(strlen($body["email"]) < 5){
      return "La contraseña debe contener como minimo 5 caracteres";
    }
    if($body["password_again"] == "" || $body["password_again"] == null){
      return "Debe ingresar la confirmacion de la contraseña";
    }elseif($body["password"] !== $body["password_again"]){
      return "Las contraseñas deben coincidir";
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

  public function getMyUsers(Request $request, $rol_id, $myId){
    if($rol_id == 1){

    } else if($rol_id == 2){
      return response()->json([
        'data' => DB::select('CALL sp_get_users_campeing('.$rol_id.')'),
      ], 200);
    } else{
      return response()->json([
        'data' => DB::select('CALL sp_get_my_users('.$myId.')'),
      ], 200);
    }
  }

}
