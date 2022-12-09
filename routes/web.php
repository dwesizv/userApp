<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//php artisan route:list --except-vendor

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::put('user/update', [App\Http\Controllers\HomeController::class, 'update'])->name('user.update');

Route::resource('admin', App\Http\Controllers\AdministrationController::class);
Route::get('/yate', [App\Http\Controllers\YateController::class, 'index'])->name('yate.index');