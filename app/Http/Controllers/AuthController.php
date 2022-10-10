<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

  // public function register(UserRegisterRequest $request)
  public function register(Request $request)
  {
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


  public function login(Request $request)
  {
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
    $authToken = $userData->createToken('auth_token')->plainTextToken;
    return response()->json([
      'access_token' => $authToken,
      'token_type' => 'Bearer',
      'user' => auth()->user()
    ], 200);
  }

  public function getSession(Request $request){
    return response()->json([
      'data' => auth()->user(),
    ], 200);
  }
  
}
