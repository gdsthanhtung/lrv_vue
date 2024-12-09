<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EnumerationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/{id}/users', [UserController::class, 'show']);
Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/{id}/users', [UserController::class, 'update']);

Route::get('/departments', [DepartmentController::class, 'index']);

Route::get('/roles', [RoleController::class, 'index']);

Route::get('/enumerations', [EnumerationController::class, 'index']);
