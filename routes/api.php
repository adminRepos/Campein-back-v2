<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/* __________________AUTENTICATION APIS______________________ */
Route::post('/login', [UserController::class, 'authenticate']);
Route::post('/register', [UserController::class, 'register']);

/* __________________ROUTES PROTEGIDAS CON JWT______________________ */
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('/getUser', [UserController::class, 'getAuthenticatedUser']);
    Route::get('/searchUsers', [UserController::class, 'searchUsers']);
    Route::get('/logout', [UserController::class, 'logout']);

});

