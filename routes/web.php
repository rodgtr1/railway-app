<?php

use App\Http\Controllers\ThumbnailController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::post('/thumbnail', [ThumbnailController::class, 'upload'])->name('thumbnail.upload');
    Route::post('/removeBackground', [ThumbnailController::class, 'removeBackground'])->name('thumbnail.removeBackground');
    Route::delete('/thumbnail/{thumbnail}', [ThumbnailController::class, 'destroy'])->name('thumbnail.delete');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

if (env('APP_ENV') === 'production') {
    URL::forceScheme('https');
}

require __DIR__.'/auth.php';