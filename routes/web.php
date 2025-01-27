<?php

use App\Http\Controllers\DeckController;
use App\Http\Controllers\PlayController;
use App\Http\Controllers\ShopController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



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
        return Inertia::render('Menu');
    })->name('dashboard');

    Route::get('/deck', [DeckController::class, 'index'] )->name('deck');
    Route::get('/play', [PlayController::class, 'index'] )->name('play');
    Route::get('/shop', [ShopController::class, 'index'] )->name('shop');

});
