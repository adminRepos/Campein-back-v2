<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Mail\CorreoElectronico;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{

  // public function register(UserRegisterRequest $request)
  public function register(Request $request){
    $requestValidate = $request->validate([
      'nombre' => 'required|string',
      'rol_id' => 'required',
      'email' => 'required|string|email|unique:users',
      'password' => 'required|string|min:12',
      'telefono' => 'required|string|min:5|max:16',
      'identificacion' => 'required|string|min:5|max:16'
    ]);

    $newUser = User::create([
      'nombre' => $requestValidate['nombre'],
      'rol_id' => $requestValidate['rol_id'],
      'email' => $requestValidate['email'],
      'password' => Hash::make($requestValidate['password']),
      'telefono' => $requestValidate['telefono'],
      'identificacion' => $requestValidate['identificacion']
    ]);

    $registerToken = $newUser->createToken('auth_token')->plainTextToken;

    return response()->json([
      'data' => $newUser,
      'access_token' => $registerToken,
      'token_type' => 'Bearer',
    ], 201);

    // return ['Register' => $request->all()];
  }


  public function login(Request $request){
    try {
      //code...
      $requestEmail = $request->get('email');
      $requestPassword = $request->get('password');
  
      if (!Auth::attempt(['email' => $requestEmail, 'password' => $requestPassword])) {
        return response()->json([
          // 'message' => 'Credeciales de acceso errones',
          'message' => 'Usuario y/o contraseña incorrectos',
          'error' => 'Unauthorized access'
        ], 401);
      }
  
      $userData = User::where('email', '=', $requestEmail)->firstOrFail();
      if($userData->activo == 1){
        $authToken = $userData->createToken('auth_token')->plainTextToken;

        
        $nameImage = $userData->image;
        if($nameImage <> null){
          // $e->image = "test";
          $dir = '../resources/images/profile-img/'.$userData->image;
          if (file_exists($dir) == false) {
            $userData->image = null;
          }else{
            // Extensión de la imagen
            $type = pathinfo($dir, PATHINFO_EXTENSION);
            // Cargando la imagen
            $img = file_get_contents($dir);
            // Decodificando la imagen en base64
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($img);
            $userData->image = $base64;          
          }
        }
      

        return response()->json([
          'access_token' => $authToken,
          'token_type' => 'Bearer',
          'user' => $userData
        ], 200);
      }else{
        return response()->json([
          'code' => 403,
          'message' => 'Usuario bloqueado temporalmente, Por favor
          comuníquese con su líder',
        ], 403);
      }
    } catch (\Throwable $th) {
      return response()->json([
        'code' => 500,
        'message' => 'Error interno del servidor',
        'error' => $th
      ], 500);
      //throw $th;
    }
  }

  public function getSession(Request $request){
    return response()->json([
      'data' => auth()->user(),
    ], 200);
  }
  
  public function resetPass(Request $request, $email, $date){
    try {
      $userData = User::where('email', '=', $email)->first();
      
      if($userData == null){
        return response()->json([
          'code' => 404,
          'message' => 'El usuario no existe en el sistema',
        ], 200);
      }else{
        // $today = new date('Y-m-d H:i:s');
        Mail::to($email)->send(new CorreoElectronico($userData->id,($userData->nombre . ' ' . $userData->apellido), 'recuperarPass', '', '', $date));
        return response()->json([
          'code' => 200,
          'message' => 'Envio de correo electronico satisfactorio',
        ], 200);
      }
    } catch (\Throwable $th) {
      return response()->json([
        'code' => 500,
        'message' => 'Error interno del servidor',
        'error' => $th
      ], 500);
    }

  }

  public function changePass(Request $request){
    // $body = $_REQUEST;
    if($request->get('pass') == $request->get('confPass')){
      $userData = User::where('id', '=', $request->get('id'))->first();
      $userData->password = Hash::make($request->get('pass'));
      $userData->save();
      return response()->json([
        'code' => 200,
        'message' => 'La contraseña ha sido cambiada exitosamente',
      ], 200);
    }else{
      return response()->json([
        'code' => 400,
        'message' => 'Las contraseñas no coinciden',
        'error' => 'Contraseñas no coinciden',
      ], 400);
    }
  }

}

