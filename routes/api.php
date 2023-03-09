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
use App\Http\Controllers\EvidenciasController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\SubTerritorioController;
use App\Http\Controllers\TerritorioController;
use App\Http\Controllers\TipoTerritorioController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ZonasUsersController;
use App\Http\Controllers\ZonaController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\NotificacionesController;
use App\Http\Controllers\NoticiasController;
use App\Http\Controllers\EstadisticasController;

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
    
    
    // Route::get('/perfil-usuario', [UsuarioController::class], 'getUser');
    //Formulario
    Route::get('/getIntereces/{rol_id}', [ProspectoController::class, 'getIntereces']); // traer los intereces por campeign 
    Route::post('/insertProspecto', [ProspectoController::class, 'insertProspecto']); // Registrar prospecto 
    Route::post('/insertEvidencia', [EvidenciasController::class, 'insertEvidencia']); // Registrar evidencia de usuario 
    // Modulo gestion de usuarios
    Route::post('/insertUser', [UsuarioController::class, 'insertUser']);
    Route::post('/updateUser', [UsuarioController::class, 'updateUser']);
    Route::get('/activarUser/{id}', [UsuarioController::class, 'activarUser']);
    Route::get('/activarUserData/{id}', [UsuarioController::class, 'activarUserData']);
    Route::post('/getPrivilegios', [UsuarioController::class, 'getPrivilegios']);
    Route::get('/getUsersTable/{rol_id}/{id}', [UsuarioController::class, 'getUsersTable']);
    Route::get('/getUser/{id}', [UsuarioController::class, 'getUser']);
    Route::get('/getUsers/{rol_id}', [UsuarioController::class, 'getUsers']);
    Route::get('/getMyUsers/{rol_id}/{myId}', [UsuarioController::class, 'getMyUsers']);
    Route::get('/getMyUsersActivos/{rol_id}/{myId}', [UsuarioController::class, 'getMyUsersActivos']);
    Route::get('/getRoles', [UsuarioController::class, 'getRoles']);
    Route::get('/getRolesCampeign/{rol_id}', [UsuarioController::class, 'getRolesCampeign']);
    
    Route::get('/getUserGestion/{id_user}', [UsuarioController::class, 'getUserGestion']);
    Route::get('/cambioMeta/{numero}', [CampeignController::class, 'cambioMeta']);
    Route::get('/cambioMetaEvidencias/{numero}', [CampeignController::class, 'cambioMetaEvidencias']);
    // reporte Excel
    Route::get('/getDataExcel/{id_user}/{datos}', [CampeignController::class, 'getDataExcel']);
    Route::get('/getDataExcelAdminMobile/{rol_id}', [CampeignController::class, 'getDataExcelAdminMobile']);
    // EVIDENCIAS
    Route::get('/getUsersEvidencias/{id_user}', [EvidenciasController::class, 'getUsersEvidencias']);
    // NOTIFICACIONES
    Route::post('/insertNotificaciones', [NotificacionesController::class, 'insertNotificaciones']);
    Route::get('/getNotificacionesTemp/{inTipo_user}', [NotificacionesController::class, 'getNotificacionesTemp']);
    // NOTICIAS
    Route::post('/insertNoticia', [NoticiasController::class, 'insertNoticia']);
    Route::get('/selectNoticiasxCampeign/{id_user}', [NoticiasController::class, 'selectNoticias']);

    // Peticiones mobile
    Route::get('/getUsersAlfa/{id_user}', [UsuarioController::class, 'getUsersAlfa']);
    Route::get('/getUsersAlfaData/{id_user}', [UsuarioController::class, 'getUsersAlfaData']);
    Route::get('/getUsersBeta/{id_user}', [UsuarioController::class, 'getUsersBeta']);

    Route::get('/upAlfa/{id_user}', [UsuarioController::class, 'upAlfa']);

    // reporte pdf mobile
    Route::get('/getPDF/{id_user}/{datos}', [CampeignController::class, 'getPDF']);
    Route::get('/getPDFAdminMobile/{rol_id}', [CampeignController::class, 'getPDFAdminMobile']);

    Route::get('/getEvidenciasUsuario/{id_user}', [EvidenciasController::class, 'getEvidenciasUsuario']);
    Route::get('/getReporteEvidenciasUsuario/{id_user}', [EvidenciasController::class, 'getReporteEvidenciasUsuario']);
    Route::get('/getReporteEvidencias/{id_user}', [EvidenciasController::class, 'getReporteEvidencias']);
    Route::get('/getXlsEvidencias/{id_user}/{isLeader}', [EvidenciasController::class, 'getXlsEvidencias']);
    
    // Estadisticas
    Route::get('/getEstadisticasTotalUsuarios/{id_user}', [EstadisticasController::class, 'getEstadisticasTotalUsuarios']);
    Route::get('/getPorcentajesProspectosXRol/{id_user}', [EstadisticasController::class, 'getPorcentajesProspectosXRol']);
    Route::get('/getEstadisticaLocalidades/{id_user}', [EstadisticasController::class, 'getEstadisticaLocalidades']);
    Route::get('/getLideresBetaRanking/{id_user}', [EstadisticasController::class, 'getLideresBetaRanking']);

    Route::get('/getEstadisticasUsuario/{id_user}', [EstadisticasController::class, 'getEstadisticasUsuario']);
    Route::get('/getEstadisticasHome', [EstadisticasController::class, 'getEstadisticasHome']);
    Route::get('/getEstadisticaProspectosMeses/{id_user}/{ano}/{mes}/{hoy}/{ayer}', [EstadisticasController::class, 'getEstadisticaProspectosMeses']);

});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/resetPass/{email}/{date}', [AuthController::class, 'resetPass']);
Route::post('/resetPass', [AuthController::class, 'changePass']);

