<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PengingatController;
use Illuminate\Support\Facades\Auth;

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

Route::group([
    'prefix' => 'auth',
    'namespace' => 'App\Http\Controllers\API'
], function(){
    Route::post('masuk', [AuthController::class, 'masuk']);
    Route::post('daftar', [AuthController::class, 'daftar']);

    Route::group([
        'middleware' => 'auth:api'
    ], function(){
        Route::get('keluar', [AuthController::class, 'keluar']);
        Route::get('infopengguna', [AuthController::class, 'infopengguna']);
    });
});

Route::group([
    'prefix' => 'operasipengingat',
    'namespace' => 'App\Http\Controllers\API',
    'middleware' => 'auth:api'
], function(){
    Route::post('tambahpengingat', [PengingatController::class, 'tambahpengingat']);
    Route::get('lihatsemuapengingat', [PengingatController::class, 'lihatsemuapengingat']);
    Route::get('lihatsatupengingat/{id}', [PengingatController::class, 'lihatsatupengingat']);
    Route::put('ubahpengingat/{id}', [PengingatController::class, 'ubahpengingat']);
    Route::delete('hapuspengingat/{id}', [PengingatController::class, 'hapuspengingat']);
});