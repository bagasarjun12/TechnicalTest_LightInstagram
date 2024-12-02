<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArchiveController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('auth/login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::post('/like', [HomeController::class, 'like'])->name('like');
    Route::post('/upload_content', [HomeController::class, 'upload_content'])->name('upload_content');
    Route::get('/account', [ProfileController::class, 'index'])->name('account');
    Route::get('/delete_reel/{id}', [ProfileController::class, 'del_reel'])->name('delete_reel');
    Route::get('/archive_reel/{id}', [ProfileController::class, 'archive'])->name('archive_reel');
    Route::patch('/profile_update', [ProfileController::class, 'profile_update'])->name('profile_update');
    Route::get('/archive', [ArchiveController::class, 'show'])->name('archive');
    Route::get('/archive/download', [ArchiveController::class, 'download'])->name('archive.download');
    Route::get('/archive/download/csv', [ArchiveController::class, 'downloadCsv'])->name('archive.download.csv');

    Route::get('/archive/download/pdf', [ArchiveController::class, 'downloadPdf'])->name('archive.download.pdf');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
