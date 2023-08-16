<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\WebProfileController;
use App\Http\Controllers\Api\SocialMediaController;
use App\Http\Controllers\Api\GamesController;
use App\Http\Controllers\Api\GameNewsController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\AllDataController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/banner')->group(function () {
    Route::get('/', [BannerController::class, 'getBanners']);
    Route::get('/{id}', [BannerController::class, 'getBanner']);
});

Route::prefix('/game')->group(function () {
    Route::get('/', [GamesController::class, 'getGames']);
    Route::get('/{id}', [GamesController::class, 'getGame']);
});

Route::prefix('/social-media')->group(function () {
    Route::get('/', [SocialMediaController::class, 'getSocialMedias']);
    Route::get('/{id}', [SocialMediaController::class, 'getSocialMedia']);
});

Route::prefix('/web-profile')->group(function () {
    Route::get('/', [WebProfileController::class, 'getWebProfile']);
});

Route::prefix('/game-news')->group(function () {
    Route::get('/', [GameNewsController::class, 'getGameNews']);
});

Route::prefix('/blog')->group(function () {
    Route::get('/', [BlogController::class, 'getBlog']);
});

Route::prefix('/all-data')->group(function () {
    Route::get('/', [AllDataController::class, 'getData']);
});
