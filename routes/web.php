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

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['middleware' => 'auth'], function (){
    Route::group(['middleware' => 'manager'], function (){
        Route::get('/manager', [\App\Http\Controllers\Manager\ManagerController::class, 'index'])->name('manager.index');
        Route::get('/application-status/{id}', [\App\Http\Controllers\Client\ClientController::class, 'changeStatus'])->name('application.status');
    });
    Route::group(['middleware' => 'client'], function () {
        Route::get('/client', [\App\Http\Controllers\Client\ClientController::class, 'index'])->name('client.index');
        Route::post('/client-application', [\App\Http\Controllers\Client\ClientController::class, 'application'])->name('client.application');
    });
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
