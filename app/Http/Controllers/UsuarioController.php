<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\UserRegisterRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{

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

  public function getUser(Request $request)
  {
    $id = $request->post('id');
    return response()->json([
      'data' => DB::select('CALL sp_get_user('.$id.')'),
    ], 200);
  }

  public function getUsers(Request $request)
  {
    return response()->json([
      'data' => User::get(),
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
}
