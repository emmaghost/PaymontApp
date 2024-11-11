<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VideoController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\InteractionController;
use App\Http\Controllers\Api\CommentController;


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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/courses', [CourseController::class, 'index']); // 1. Listar cursos
    Route::get('/courses/search', [CourseController::class, 'search']); // 2. Buscar cursos
    Route::post('/courses/{course}/enroll', [CourseController::class, 'enroll']); // 3. Registrar usuario en curso
    
    // Rutas de videos
    Route::get('/courses/{course}/videos', [VideoController::class, 'index']); // 4. Ver videos de un curso
    
    // Rutas de interacciones con videos
    Route::post('/videos/{video}/comments', [InteractionController::class, 'addComment']); // 5. Subir comentarios
    Route::post('/videos/{video}/like', [InteractionController::class, 'likeVideo']); // 6. Dar like
    Route::post('/videos/{video}/complete', [InteractionController::class, 'markAsCompleted']); // 7. Manejar progreso de visualización

});    