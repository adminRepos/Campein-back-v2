<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\UserAuthRequest;
use App\Http\Requests\UserRegisterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    // public function register(UserRegisterRequest $request)
    public function register(Request $request)
    {
        $requestValidate = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:12',
            'telefono' => 'required|string|min:5|max:16',
            'identificacion' => 'required|string|min:5|max:16'
        ]);

        $newUser = User::create([
            'name' => $requestValidate['name'],
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

        if(!Auth::attempt(['email' => $requestEmail , 'password' => $requestPassword])) {
            return response()->json([
                'message' => 'Invalid login credentials. Please trying again',
                'error' => 'Unauthorized access'
            ], 401);
        }

        $userData = User::where('email', '=', $requestEmail)->firstOrFail();
        $authToken = $userData->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $authToken,
            'token_type' => 'Bearer',
        ], 200);
    }

    public function getUser(Request $request)
    {
        return response()->json([
            'message' => 'Access success',
            'data' => ['user' => $request->user()],
        ], 200);
    }
}
