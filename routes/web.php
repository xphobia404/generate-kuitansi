<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KuitansiController;

Route::get('/kuitansi/preview', [KuitansiController::class, 'preview']);   
Route::get('/kuitansi/download', [KuitansiController::class, 'downloadPdf']); 