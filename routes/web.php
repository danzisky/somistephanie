<?php

use App\Http\Controllers\Blog\BlogController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BlogController::class, 'home'])->name('home');
Route::get('/contents', [BlogController::class, 'contents'])->name('blog.contents');
Route::get('/article', [BlogController::class, 'featured'])->name('blog.featured');
Route::get('/article/{slug}', [BlogController::class, 'article'])->name('blog.article');
Route::get('/subscribe', [BlogController::class, 'subscribe'])->name('blog.subscribe');
Route::get('/shop', [BlogController::class, 'shop'])->name('blog.shop');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

require __DIR__ . '/settings.php';
