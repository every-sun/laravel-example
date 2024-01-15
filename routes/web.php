<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentLikeController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\RoleController;
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

//Route::get('/', function () {
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//});
Route::get('/', [PostController::class, 'indexPosts'])->name('posts.index');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/user/posts', [PostController::class, 'indexMyPosts'])->name('user.posts.index');
    Route::get('/user/bookmarks', [PostController::class, 'indexMyPosts'])->name('user.bookmarks.index'); // TODO
    Route::get('/user/comments', [CommentController::class, 'indexMyComments'])->name('user.comments.index');
    Route::get('/user/comments/likes', [CommentLikeController::class, 'indexLikedComments'])->name('user.comments.likes.index');

    Route::post('/comment/{comment_id}/like', [CommentLikeController::class, 'storeCommentLike'])->name('comment.like.store');
    Route::delete('/comment/{comment_id}/like', [CommentLikeController::class, 'destroyCommentLike'])->name('comment.like.destroy');

    Route::get('/post/create', [PostController::class, 'createPost'])->name('post.create');
    Route::post('/post', [PostController::class, 'storePost'])->name('post.store');
    Route::get('/post/{id}/edit', [PostController::class, 'editPost'])->name('post.edit');
    Route::put('/post/{id}', [PostController::class, 'updatePost'])->name('post.update');
    Route::delete('/post/{id}', [PostController::class, 'destroyPost'])->name('post.destroy');

    Route::post('/post/{post_id}/comment', [CommentController::class, 'storeComment'])->name('post.comment.store');
    Route::put('/post/{post_id}/comment/{id}', [CommentController::class, 'updateComment'])->name('post.comment.update');
    Route::delete('/post/{post_id}/comment/{id}', [CommentController::class, 'destroyComment'])->name('post.comment.destroy');

    Route::get('/files', [FileController::class, 'indexFiles'])->name('files.index');
    Route::get('/files/create', [FileController::class, 'createFiles'])->name('files.create');
    Route::post('/files', [FileController::class, 'storeFiles'])->name('files.store');
});

Route::get('/post', [PostController::class, 'indexPosts'])->name('posts.index');
Route::get('/post/{id}', [PostController::class, 'showPost'])->name('post.show');

// TODO 관리자만 들어갈 수 있게 하기
Route::get('/roles', [RoleController::class, 'indexRoles'])->name('roles.index');
Route::post('/role', [RoleController::class, 'storeRole'])->name('role.store');
Route::put('/user/{user_id}/role/{role_id}', [RoleController::class, 'updateUserRole'] )->name('user.role.update');

