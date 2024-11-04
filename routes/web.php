<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PdfSearchController;

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/upload-form', function () {
    return view('upload');
});

Route::get('/', function () {
    return view('landing');
});
Route::post('/upload', [FileController::class, 'store']);

Route::post('/search_pdf', [PdfSearchController::class, 'searchPdf'])->name('search_pdf');

