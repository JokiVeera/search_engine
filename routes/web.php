<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PdfSearchController;
use App\Http\Controllers\AdminController;

Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AdminController::class, 'login']);
Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

Route::middleware('auth:admin')->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // });

    Route::get('/upload-form', [FileController::class, 'index'])->name('upload.form');
    Route::post('/upload', [FileController::class, 'store'])->name('upload.file');
});


Route::get('/welcome', function () {
    return view('welcome');
});

// Route::get('/upload-form', function () {
//     return view('upload');
// });

Route::get('/', function () {
    return view('landing');
});
// Route::post('/upload', [FileController::class, 'store']);

Route::post('/search_pdf', [PdfSearchController::class, 'searchPdf'])->name('search_pdf');

