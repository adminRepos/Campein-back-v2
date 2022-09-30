<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\UserRegisterRequest;

class UsuarioController extends Controller
{
  public function getUser()
  {
    return response()->json([
        "data" => auth()->user()
    ], 200);
  }

  public function insertUser(Request $request)
  {
    // $requestValidate = $request->validate([
    //   'name' => 'required|string',
    //   'email' => 'required|string|email|unique:users',
    //   'password' => 'required|string|min:12',
    //   'telefono' => 'required|string|min:5|max:16',
    //   'identificacion' => 'required|string|min:5|max:16'
    // ]);
  }
}
