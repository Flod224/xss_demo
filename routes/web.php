<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdController;
use App\Http\Controllers\LoginMaliciousController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('posts', PostController::class);
    Route::post('posts/{post}/comment', [PostController::class, 'comment'])->name('posts.comment');
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::post('/ads', [PostController::class, 'store'])->name('ads.store');
    Route::get('/loginmalicious', [LoginMaliciousController::class, 'index'])->name('loginmalicious.index');

*/

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('posts', PostController::class);
    Route::post('posts/{post}/comment', [PostController::class, 'comment'])->name('posts.comment');
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::post('/ads', [PostController::class, 'store'])->name('ads.store');
    Route::get('/loginmalicious', [LoginMaliciousController::class, 'index'])->name('loginmalicious.index');

});


require __DIR__.'/auth.php';
