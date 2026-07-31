<?php

use App\Http\Controllers\KuitansiController;
use Illuminate\Support\Facades\Route;

Route::get('/kuitansi', [KuitansiController::class, 'create'])->name('kuitansi.create');
Route::post('/kuitansi/pdf', [KuitansiController::class, 'generatePdf'])->name('kuitansi.pdf');