<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\DeckController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\PlayController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MazoController;
use App\Http\Controllers\MensajeController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TiendaController;
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

    Route::get('/deck', [DeckController::class, 'index'])->name('deck');
    Route::get('/deck_list/{id?}', [DeckController::class, 'getUserDecks'])->name('get.decks');
    Route::post('/deck', [DeckController::class, 'store'])->name('deck.store');
    Route::put('/deck/{deck}', [DeckController::class, 'update'])->name('deck.update');
    Route::delete('/deck/{deck}', [DeckController::class, 'destroy'])->name('deck.destroy');
    Route::get('/deck/{deck}', [DeckController::class, 'show'])->name('deck.show');

    Route::get('/play', [PlayController::class, 'index'])->name('play');
    Route::get('/shop', [ShopController::class, 'index'])->name('shop');
});
