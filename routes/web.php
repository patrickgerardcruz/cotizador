<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\CotizacionController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('clientes', ClienteController::class);
Route::resource('cotizaciones', CotizacionController::class)
    ->parameters(['cotizaciones' => 'cotizacion']);
Route::resource('servicios', ServicioController::class);