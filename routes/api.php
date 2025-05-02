<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadImageController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CourrierController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/upload',[UploadImageController::class,'upload']);

Route::get('/services/{id}/users', [ServiceController::class, 'getUsers']);

// routes/api.php
Route::get('/services/{service}/employees', [CourrierController::class, 'employeesByService']);

