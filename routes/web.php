<?php

use App\Http\Controllers\AntrianController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/antrian', [AntrianController::class, 'index'])->name('antrian.index');
Route::post('/antrian', [AntrianController::class, 'store'])->name('antrian.store');

