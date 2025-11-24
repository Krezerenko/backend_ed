<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/files', [HomeController::class, 'files'])->name('files.index');

Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
Route::post('/upload', [UploadController::class, 'upload'])->name('upload.pdf');

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/stats', [AdminController::class, 'stats'])->name('admin.stats');
    Route::get('/fixtures', [AdminController::class, 'fixturesForm'])->name('admin.fixtures');
    Route::post('/generate-fixtures', [AdminController::class, 'generateFixtures'])->name('admin.generate');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store']);
});
