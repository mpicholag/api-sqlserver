<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Test;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\CatalogoController;

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

Route::middleware(['cors', 'json.response'])->post('/login', [AuthenticationController::class, 'login']);
Route::get('/logout', [AuthenticationController::class, 'logout']);
Route::get('/refresh', [AuthenticationController::class, 'refresh']);
Route::middleware(['cors', 'json.response'])->post('/register', [AuthenticationController::class, 'register']);

Route::middleware(['cors', 'json.response', 'auth:api'])->group(function() {
  Route::post('/user', [AuthenticationController::class, 'create']);
  Route::get('/user', [AuthenticationController::class, 'index']);
  Route::post('/user-role', [AuthenticationController::class, 'createRole']);

  Route::get('/catalogo', [CatalogoController::class, 'index']);
  Route::post('/catalogo', [CatalogoController::class, 'create']);
  Route::put('/catalogo/{id}', [CatalogoController::class, 'update']);
  Route::get('/catalogo/{id}', [CatalogoController::class, 'show']);
  Route::delete('/catalogo/{id}', [CatalogoController::class, 'destroy']);

  Route::get('/me', [AuthenticationController::class, 'me']);
});
Route::get('/download', [DocumentController::class, 'download']);
Route::get('/test', [Test::class, 'index']);
