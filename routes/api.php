<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ApiArtikelController;
use App\Http\Controllers\Api\ApiBookmarkController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/login', [ApiAuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [ApiAuthController::class, 'logout']);
    Route::get('/user', [ApiAuthController::class, 'user']);
    Route::post('/refresh', [ApiAuthController::class, 'refresh']);

    // Artikel Routes
    Route::get('/artikel', [ApiArtikelController::class, 'index']);
    Route::post('/artikel/show', [ApiArtikelController::class, 'show']);
    Route::post('/artikel/like', [ApiArtikelController::class, 'like']);
    Route::post('/artikel/bookmark', [ApiArtikelController::class, 'bookmark']);

    // Bookmark Routes
    Route::get('/bookmarks', [ApiBookmarkController::class, 'index']);
    Route::post('/bookmarks/toggle', [ApiBookmarkController::class, 'toggle']);
});
