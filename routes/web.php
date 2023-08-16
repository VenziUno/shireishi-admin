<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthorizationController;
use App\Http\Controllers\Admin\AdminGroupController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\WebProfileController;
use App\Http\Controllers\Admin\SocialMediaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GameCategoryController;
use App\Http\Controllers\Admin\GamesController;
use App\Http\Controllers\Admin\GameNewsCategoryController;
use App\Http\Controllers\Admin\GameNewsController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\HashtagController;
use App\Http\Controllers\Admin\PromotionalVideoController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'viewlogin'])->name('login');
Route::post('/login', [AuthController::class, 'proccesslogin']);
Route::get('/logout', [AuthController::class, 'proccesslogout']);

Route::namespace('Admin')->middleware(['auth', 'otorisasi'])->group(function () {
	Route::get('/dashboard', [DashboardController::class, 'view'])->name('dashboard_view');

	Route::prefix('/web-profile')->group(function () {
		Route::get('/', [WebProfileController::class, 'index'])->name('web-profile_view_index');
		Route::post('/upload', [WebProfileController::class, 'upload'])->name('web-profile_add_upload');
		Route::post('/edit', [WebProfileController::class, 'editPatch'])->name('web-profile_add_post');
		Route::post('/uploadContent', [WebProfileController::class, 'uploadContent'])->name('web-profile_add_upload_content');
	});

	Route::prefix('/banner')->group(function () {
		Route::get('/', [BannerController::class, 'index'])->name('banner_view_index');
		Route::get('/data', [BannerController::class, 'data'])->name('banner_view');
		Route::get('/add', [BannerController::class, 'addView'])->name('banner_add');
		Route::get('/edit/{id}', [BannerController::class, 'editView'])->name('banner_edit');
		Route::post('/uploadContent', [BannerController::class, 'uploadContent'])->name('banner_add_upload_content');
		Route::post('/add', [BannerController::class, 'addPost'])->name('banner_add_post');
		Route::post('/upload/{type}', [BannerController::class, 'upload'])->name('banner_add_upload');
		Route::patch('/edit/{id}', [BannerController::class, 'editPatch'])->name('banner_edit_patch');
		Route::patch('/status/{id}/{status}', [BannerController::class, 'editStatus'])->name('banner_edit_status');
		Route::delete('/delete/{id}', [BannerController::class, 'delete'])->name('banner_delete');
	});

	Route::prefix('/game-category')->group(function () {
		Route::get('/', [GameCategoryController::class, 'index'])->name('game-category_view_index');
		Route::get('/data', [GameCategoryController::class, 'data'])->name('game-category_view');
		Route::get('/add', [GameCategoryController::class, 'addView'])->name('game-category_add');
		Route::get('/edit/{id}', [GameCategoryController::class, 'editView'])->name('game-category_edit');
		Route::post('/add', [GameCategoryController::class, 'addPost'])->name('game-category_add_post');
		Route::patch('/edit/{id}', [GameCategoryController::class, 'editPatch'])->name('game-category_edit_patch');
		Route::delete('/delete/{id}', [GameCategoryController::class, 'delete'])->name('game-category_delete');
	});

	Route::prefix('/game')->group(function () {
		Route::get('/', [GamesController::class, 'index'])->name('game_view_index');
		Route::get('/data', [GamesController::class, 'data'])->name('game_view');
		Route::get('/add', [GamesController::class, 'addView'])->name('game_add');
		Route::get('/edit/{id}', [GamesController::class, 'editView'])->name('game_edit');
		Route::post('/add', [GamesController::class, 'addPost'])->name('game_add_post');
		Route::post('/upload/{type}', [GamesController::class, 'upload'])->name('game_add_upload');
		Route::post('/uploadContent', [GameNewsController::class, 'uploadContent'])->name('game_add_upload_content');
		Route::patch('/edit/{id}', [GamesController::class, 'editPatch'])->name('game_edit_patch');
		Route::patch('/status/{id}/{status}', [GamesController::class, 'editStatus'])->name('game_edit_status');
		Route::delete('/delete/{id}', [GamesController::class, 'delete'])->name('game_delete');
	});

	Route::prefix('/social-media')->group(function () {
		Route::get('/', [SocialMediaController::class, 'index'])->name('social-media_view_index');
		Route::get('/data', [SocialMediaController::class, 'data'])->name('social-media_view');
		Route::get('/add', [SocialMediaController::class, 'addView'])->name('social-media_add');
		Route::get('/edit/{id}', [SocialMediaController::class, 'editView'])->name('social-media_edit');
		Route::post('/add', [SocialMediaController::class, 'addPost'])->name('social-media_add_post');
		Route::post('/upload', [SocialMediaController::class, 'upload'])->name('social-media_upload');
		Route::patch('/edit/{id}', [SocialMediaController::class, 'editPatch'])->name('social-media_edit_patch');
		Route::delete('/delete/{id}', [SocialMediaController::class, 'delete'])->name('social-media_delete');
	});

	Route::prefix('/promotional-video')->group(function () {
		Route::get('/', [PromotionalVideoController::class, 'index'])->name('promotional-video_view_index');
		Route::get('/data', [PromotionalVideoController::class, 'data'])->name('promotional-video_view');
		Route::get('/add', [PromotionalVideoController::class, 'addView'])->name('promotional-video_add');
		Route::get('/edit/{id}', [PromotionalVideoController::class, 'editView'])->name('promotional-video_edit');
		Route::post('/add', [PromotionalVideoController::class, 'addPost'])->name('promotional-video_add_post');
		Route::patch('/edit/{id}', [PromotionalVideoController::class, 'editPatch'])->name('promotional-video_edit_patch');
		Route::delete('/delete/{id}', [PromotionalVideoController::class, 'delete'])->name('promotional-video_delete');
	});

	Route::prefix('/game-news-category')->group(function () {
		Route::get('/', [GameNewsCategoryController::class, 'index'])->name('game-news-category_view_index');
		Route::get('/data', [GameNewsCategoryController::class, 'data'])->name('game-news-category_view');
		Route::get('/add', [GameNewsCategoryController::class, 'addView'])->name('game-news-category_add');
		Route::get('/edit/{id}', [GameNewsCategoryController::class, 'editView'])->name('game-news-category_edit');
		Route::post('/add', [GameNewsCategoryController::class, 'addPost'])->name('game-news-category_add_post');
		Route::patch('/edit/{id}', [GameNewsCategoryController::class, 'editPatch'])->name('game-news-category_edit_patch');
		Route::delete('/delete/{id}', [GameNewsCategoryController::class, 'delete'])->name('game-news-category_delete');
	});

	Route::prefix('/game-news')->group(function () {
		Route::get('/', [GameNewsController::class, 'index'])->name('game-news_view_index');
		Route::get('/data', [GameNewsController::class, 'data'])->name('game-news_view');
		Route::get('/add', [GameNewsController::class, 'addView'])->name('game-news_add');
		Route::get('/edit/{id}', [GameNewsController::class, 'editView'])->name('game-news_edit');
		Route::post('/add', [GameNewsController::class, 'addPost'])->name('game-news_add_post');
		Route::post('/upload', [GameNewsController::class, 'upload'])->name('game-news_add_upload');
		Route::post('/uploadContent', [GameNewsController::class, 'uploadContent'])->name('game-news_add_upload_content');
		Route::patch('/edit/{id}', [GameNewsController::class, 'editPatch'])->name('game-news_edit_patch');
		Route::delete('/delete/{id}', [GameNewsController::class, 'delete'])->name('game-news_delete');
	});

	Route::prefix('/blog-category')->group(function () {
		Route::get('/', [BlogCategoryController::class, 'index'])->name('blog-category_view_index');
		Route::get('/data', [BlogCategoryController::class, 'data'])->name('blog-category_view');
		Route::get('/add', [BlogCategoryController::class, 'addView'])->name('blog-category_add');
		Route::get('/edit/{id}', [BlogCategoryController::class, 'editView'])->name('blog-category_edit');
		Route::post('/add', [BlogCategoryController::class, 'addPost'])->name('blog-category_add_post');
		Route::patch('/edit/{id}', [BlogCategoryController::class, 'editPatch'])->name('blog-category_edit_patch');
		Route::delete('/delete/{id}', [BlogCategoryController::class, 'delete'])->name('blog-category_delete');
	});

	Route::prefix('/blog')->group(function () {
		Route::get('/', [BlogController::class, 'index'])->name('blog_view_index');
		Route::get('/data', [BlogController::class, 'data'])->name('blog_view');
		Route::get('/add', [BlogController::class, 'addView'])->name('blog_add');
		Route::get('/edit/{id}', [BlogController::class, 'editView'])->name('blog_edit');
		Route::post('/add', [BlogController::class, 'addPost'])->name('blog_add_post');
		Route::post('/upload', [BlogController::class, 'upload'])->name('blog_add_upload');
		Route::post('/uploadContent', [BlogController::class, 'uploadContent'])->name('blog_add_upload_content');
		Route::patch('/edit/{id}', [BlogController::class, 'editPatch'])->name('blog_edit_patch');
		Route::delete('/delete/{id}', [BlogController::class, 'delete'])->name('blog_delete');
	});

	Route::prefix('/hashtag')->group(function () {
		Route::get('/', [HashtagController::class, 'index'])->name('hashtag_view_index');
		Route::get('/data', [HashtagController::class, 'data'])->name('hashtag_view');
		Route::get('/add', [HashtagController::class, 'addView'])->name('hashtag_add');
		Route::get('/edit/{id}', [HashtagController::class, 'editView'])->name('hashtag_edit');
		Route::post('/add', [HashtagController::class, 'addPost'])->name('hashtag_add_post');
		Route::patch('/edit/{id}', [HashtagController::class, 'editPatch'])->name('hashtag_edit_patch');
		Route::delete('/delete/{id}', [HashtagController::class, 'delete'])->name('hashtag_delete');
	});

	Route::prefix('/admin-group')->group(function () {
		Route::get('/', [AdminGroupController::class, 'index'])->name('admin-group_view_index');
		Route::get('/data/{status}', [AdminGroupController::class, 'data'])->name('admin-group_view');
		Route::get('/add', [AdminGroupController::class, 'addView'])->name('admin-group_add');
		Route::get('/edit/{id}', [AdminGroupController::class, 'editView'])->name('admin-group_edit');
		Route::post('/add', [AdminGroupController::class, 'addPost'])->name('admin-group_add_post');
		Route::patch('/edit/{id}', [AdminGroupController::class, 'editPatch'])->name('admin-group_edit_patch');
		Route::delete('/delete/{id}', [AdminGroupController::class, 'delete'])->name('admin-group_delete');
	});

	Route::prefix('/admin')->group(function () {
		Route::get('/', [AdminController::class, 'index'])->name('admin_view_index');
		Route::get('/data/{status}', [AdminController::class, 'data'])->name('admin_view');
		Route::get('/add', [AdminController::class, 'addView'])->name('admin_add');
		Route::get('/edit/{id}', [AdminController::class, 'editView'])->name('admin_edit');
		Route::get('/editpass/{id}', [AdminController::class, 'passwordView'])->name('admin_edit_pass');
		Route::post('/add', [AdminController::class, 'addPost'])->name('admin_add_post');
		Route::post('/upload', [AdminController::class, 'upload'])->name('admin_add_upload');
		Route::patch('/edit/{id}', [AdminController::class, 'editPatch'])->name('admin_edit_patch');
		Route::patch('/editpass/{id}', [AdminController::class, 'passwordChange'])->name('admin_edit_pass');
		Route::patch('/archive/{id}', [AdminController::class, 'archive'])->name('admin_delete');
		Route::patch('/unarchive/{id}', [AdminController::class, 'unarchive'])->name('admin_delete');
		Route::delete('/delete/{id}', [AdminController::class, 'delete'])->name('admin_delete');
	});

	Route::prefix('/authorization')->group(function () {
		Route::get('/', [AuthorizationController::class, 'index'])->name('authorization_view');
		Route::get('/data/{employee}', [AuthorizationController::class, 'data'])->name('authorization_view');
		Route::post('/', [AuthorizationController::class, 'update'])->name('authorization_add');
	});

});
