<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PostController;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::get('/user/posts', [PostController::class, 'indexMyPosts'])->name('user.posts.index');
    Route::get('/post/create', [PostController::class, 'createPost'])->name('post.create');
});


Route::get('/post', [PostController::class, 'indexPosts'])->name('posts.index');
//Route::get('/post/create', [PostController::class, 'createPost'])->name('post.create');
Route::get('/post/{id}', [PostController::class, 'showPost'])->name('post.show');
Route::post('/post', [PostController::class, 'storePost'])->name('post.store');
Route::get('/post/{id}/edit', [PostController::class, 'editPost'])->name('post.edit');
Route::put('/post/{id}', [PostController::class, 'updatePost'])->name('post.update');
Route::delete('/post/{id}', [PostController::class, 'destroyPost'])->name('post.destroy');

