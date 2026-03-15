<?php

use App\Http\Controllers\Api\OfertaApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Endpoints públicos
Route::get('/ofertas', [OfertaApiController::class, 'index']);
Route::get('/ofertas/{oferta}', [OfertaApiController::class, 'show']);
Route::get('/estadisticas', [OfertaApiController::class, 'estadisticas']);
Route::get('/categorias', [OfertaApiController::class, 'categorias']);
Route::get('/departamentos', [OfertaApiController::class, 'departamentos']);
