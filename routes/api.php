<?php

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
Route::prefix( 'v1' )->group( function () {
    Route::post( '/auth/token', [ \App\Http\Controllers\UserController::class, 'auth' ] );
    Route::post( '/user', [ \App\Http\Controllers\UserController::class, 'store' ] );
    Route::middleware( 'auth:sanctum' )->group( function () {
        Route::get( '/livros', [ \App\Http\Controllers\BookController::class, 'index' ] );
        Route::post( '/livros', [ \App\Http\Controllers\BookController::class, 'store' ] );
    } );
} );
