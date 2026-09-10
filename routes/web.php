<?php

use App\Http\Controllers\WebGisController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WebGisController::class, 'index'])->name('webgis.index');

Route::prefix('api')->group(function () {
    Route::get('/ringkasan', [WebGisController::class, 'getRingkasan'])->name('api.ringkasan');
    Route::get('/geojson/rute', [WebGisController::class, 'getRuteGeoJson'])->name('api.geojson.rute');
    Route::get('/geojson/titik-ujung', [WebGisController::class, 'getTitikUjungGeoJson'])->name('api.geojson.titik-ujung');
    Route::get('/gps-mentah', [WebGisController::class, 'getGpsMentah'])->name('api.gps-mentah');
});
