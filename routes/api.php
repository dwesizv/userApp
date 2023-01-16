<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::resource('yate', App\Http\Controllers\ApiYateController::class)->except(['create', 'edit']);
Route::resource('yacht', App\Http\Controllers\ApiYachtController::class, ['names' => 'yacht'])->except(['create', 'edit']);

//definición de un grupo de rutas con un prefijo común
Route::group(['prefix' => 'auth'], function () {
    Route::get('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    //definición de un grupo de rutas con un middleware común
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
    });
});