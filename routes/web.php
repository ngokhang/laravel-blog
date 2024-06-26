<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReplyCommentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:user,admin'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/posts', [PostController::class, 'index'])->name('post.index');
    Route::get('/posts/{post:slug}', [PostController::class, 'show'])->withTrashed()->name('post.show');
    Route::get('/new-post', [PostController::class, 'create'])->name('post.create');
    Route::post('/post', [PostController::class, 'store'])->name('post.store');
    Route::get('post/{post_id}/edit', [PostController::class, 'edit'])->name('post.edit');
    Route::put('/post/{post:slug}', [PostController::class, 'update'])->name('post.update');

    // Comment route
    Route::post('/comment/{post:slug}', [CommentController::class, 'store'])->name('comment.store');
    Route::put('/comment/{comment}', [CommentController::class, 'update'])->name('comment.update');
    Route::delete('/comment/{post_id}', [CommentController::class, 'destroy'])->name('comment.destroy');
    // Reply comment route
    Route::post('/reply/{comment}', [ReplyCommentController::class, 'store'])->name('reply.store');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/edit', [AdminController::class, 'index'])->name('admin.index');
    Route::put('/admin/accept/{post:slug}', [AdminController::class, 'update'])->withTrashed()->name('admin.update');
    Route::delete('/admin/destroy/{slug}', [AdminController::class, 'destroy'])->name('admin.destroy');
    Route::delete('/admin/force-delete/{slug}', [AdminController::class, 'forceDel'])->name('admin.force-delete');

    Route::get('/admin/category', [CategoryController::class, 'index'])->name('category.index');
    Route::post('/admin/category', [CategoryController::class, 'store'])->name('category.store');
    Route::put('/admin/category', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/admin/category', [CategoryController::class, 'destroy'])->name('category.delete');
});

require __DIR__ . '/auth.php';
