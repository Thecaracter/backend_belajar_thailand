<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KategoriLessonController;


Route::get('/', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/', [AuthController::class, 'login'])->name('admin.login.post');


// Admin routes
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Article Routes
    Route::get('/artikel', [ArticleController::class, 'index'])->name('artikel.index');
    Route::post('/artikel', [ArticleController::class, 'store'])->name('artikel.store');
    Route::put('/artikel/{id}', [ArticleController::class, 'update'])->name('artikel.update');
    Route::delete('/artikel/{id}', [ArticleController::class, 'destroy'])->name('artikel.destroy');

    // Kategori Lesson Routes
    Route::get('/kategori-lesson', [KategoriLessonController::class, 'index'])->name('kategori-lesson.index');
    Route::post('/kategori-lesson', [KategoriLessonController::class, 'store'])->name('kategori-lesson.store');
    Route::put('/kategori-lesson/{id}', [KategoriLessonController::class, 'update'])->name('kategori-lesson.update');
    Route::delete('/kategori-lesson/{id}', [KategoriLessonController::class, 'destroy'])->name('kategori-lesson.destroy');

    // Lesson Routes
    Route::get('/lesson', [LessonController::class, 'index'])->name('lesson.index');
    Route::post('/lesson', [LessonController::class, 'store'])->name('lesson.store');
    Route::put('/lesson/{lesson}', [LessonController::class, 'update'])->name('lesson.update');
    Route::delete('/lesson/{lesson}', [LessonController::class, 'destroy'])->name('lesson.destroy');
});