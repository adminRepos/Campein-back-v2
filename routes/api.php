<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampeignController;
use App\Http\Controllers\CampeignsUsersController;
use App\Http\Controllers\CausaController;
use App\Http\Controllers\DonacionController;
use App\Http\Controllers\EncuestaController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\GrupoInterezController;
use App\Http\Controllers\PaisController;
use App\Http\Controllers\PartidoPoliticoController;
use App\Http\Controllers\PreguntaController;
use App\Http\Controllers\ProspectoController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\SubTerritorioController;
use App\Http\Controllers\TerritorioController;
use App\Http\Controllers\TipoTerritorioController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ZonasUsersController;
use App\Http\Controllers\ZonaController;
use App\Http\Controllers\ZoneController;

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::resource('/campeign', CampeignController::class);
    Route::resource('/campeign-user', CampeignsUsersController::class);
    Route::resource('/causa', CausaController::class);
    Route::resource('/donaciones', DonacionController::class);
    Route::resource('/encuesta', EncuestaController::class);
    Route::resource('/evento', EventoController::class);
    Route::resource('/grupos-interez', GrupoInterezController::class);
    Route::resource('/pais', PaisController::class);
    Route::resource('/partido-politico', PartidoPoliticoController::class);
    Route::resource('/pregunta', PreguntaController::class);
    Route::resource('/prospecto', ProspectoController::class);
    Route::resource('/rol', RolController::class);
    Route::resource('/sub-territorios', SubTerritorioController::class);
    Route::resource('/territorios', TerritorioController::class);
    Route::resource('/tipo-territorios', TipoTerritorioController::class);
    Route::resource('/zonas', ZonasUsersController::class);
    Route::resource('/zonas', ZonaController::class);
    Route::resource('/zonas', ZoneController::class);

    Route::get('/getSession', [AuthController::class, 'getSession']);
    
    
    Route::post('/getPrivilegios', [UsuarioController::class, 'getPrivilegios']);
    Route::get('/getUser', [UsuarioController::class, 'getUser']);
    Route::get('/getUsers/{rol_id}', [UsuarioController::class, 'getUsers']);
    Route::get('/getRoles', [UsuarioController::class, 'getRoles']);
    // Route::get('/perfil-usuario', [UsuarioController::class], 'getUser');
    //Formulario
    Route::get('/getIntereces/{campeign_id}', [ProspectoController::class, 'getIntereces']); // traer los intereces por campeign 
    Route::post('/insertProspecto', [ProspectoController::class, 'insertProspecto']); // traer los intereces por campeign 

});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
