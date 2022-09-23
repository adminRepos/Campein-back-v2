<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\User;
use JWTAuth;

class UserController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json(compact('token'));
    }

    public function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token-expirado'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token-invalido'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_ausente'], $e->getStatusCode());
        }
        return response()->json(compact('user'));
    }

    public function logout()
    {
        try {
           JWTAuth::invalidate(true);
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['Logout fallido'], $e->getStatusCode());
        }
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombres' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'identificacion' => 'required|string|min:10',
            'genero' => 'string|min:1',
            'apellidos' => 'required|string|min:6',
            'direccion' => 'required|string|min:6',
            'telefono_principal' => 'required|string|min:6',
            'rol_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'nombres' => $request->get('nombres'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'identificacion' => $request->get('identificacion'),
            'genero' => $request->get('genero'),
            'apellidos' => $request->get('apellidos'),
            'direccion' => $request->get('direccion'),
            'fecha_nacimiento' => $request->get('fecha_nacimiento'),
            'telefono_principal' => $request->get('telefono_principal'),
            'telefono_alterno' => $request->get('telefono_alterno'),
            'rol_id' => $request->get('rol_id'),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }

    public function searchUsers()
    {
      return response()->json(User::all(), 201);
    }
}
