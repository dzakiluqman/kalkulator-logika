<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogikaController;

Route::get('/kalkulator-logika', [LogikaController::class, 'index'])->name('kalkulator.index');
Route::post('/kalkulator-logika', [LogikaController::class, 'calculate'])->name('kalkulator.calculate');
