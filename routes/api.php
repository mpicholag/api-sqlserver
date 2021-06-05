<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Test;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\RegistryController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DocumentHistoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ArchivadorController;
use App\Http\Controllers\AccessArchivadorController;

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

  Route::get('/category', [CategoryController::class, 'index']);
  Route::post('/category', [CategoryController::class, 'create']);
  Route::put('/category/{id}', [CategoryController::class, 'update']);
  Route::get('/category/{id}', [CategoryController::class, 'show']);

  Route::get('/subcategory', [SubCategoryController::class, 'index']);
  Route::post('/subcategory', [SubCategoryController::class, 'create']);
  Route::put('/subcategory/{id}', [SubCategoryController::class, 'update']);
  Route::get('/subcategory/{id}', [SubCategoryController::class, 'show']);

  Route::get('/registry', [RegistryController::class, 'index']);
  Route::post('/registry', [RegistryController::class, 'create']);
  Route::put('/registry/{id}', [RegistryController::class, 'update']);
  Route::get('/registry/{id}', [RegistryController::class, 'show']);

  Route::get('/document', [DocumentController::class, 'index']);
  Route::post('/document', [DocumentController::class, 'create']);
  Route::put('/document/{id}', [DocumentController::class, 'update']);
  Route::get('/document/{id}', [DocumentController::class, 'show']);
  Route::get('/document-archivador', [DocumentController::class, 'archivador']);

  Route::get('/document-history', [DocumentHistoryController::class, 'index']);
  Route::post('/document-history', [DocumentHistoryController::class, 'create']);
  Route::put('/document-history/{id}', [DocumentHistoryController::class, 'update']);
  Route::get('/document-history/{id}', [DocumentHistoryController::class, 'show']);

  Route::get('/archivador', [ArchivadorController::class, 'index']);
  Route::post('/archivador', [ArchivadorController::class, 'create']);
  Route::put('/archivador/{id}', [ArchivadorController::class, 'update']);
  Route::get('/archivador/{id}', [ArchivadorController::class, 'show']);

  Route::post('/upload', [DocumentController::class, 'upload']);

  Route::get('/access-archivador', [RoleController::class, 'index']);
  Route::post('/access-archivador', [RoleController::class, 'create']);
  Route::delete('/access-archivador', [RoleController::class, 'destroy']);

  Route::get('/role', [RoleController::class, 'index']);
  Route::post('/role', [RoleController::class, 'create']);
  Route::put('/role/{id}', [RoleController::class, 'update']);
  Route::get('/role/{id}', [RoleController::class, 'show']);

  Route::get('/me', [AuthenticationController::class, 'me']);
});
Route::get('/download', [DocumentController::class, 'download']);
Route::get('/test', [Test::class, 'index']);
