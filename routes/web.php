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
use App\Http\Controllers\CartaController;
use App\Http\Controllers\PrePartidaController;
use App\Http\Controllers\SobreController;
use App\Http\Controllers\UserController;
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

    Route::get('/deck', [DeckController::class, 'index'])->name('deck.list');
    Route::get('/deck/list/{id?}', [DeckController::class, 'getUserDecks'])->name('get.decks');
    Route::post('/deck', [DeckController::class, 'store'])->name('deck.store');
    Route::put('/deck/{deck}', [DeckController::class, 'update'])->name('deck.update');
    Route::delete('/deck/{deck}', [DeckController::class, 'destroy'])->name('deck.destroy');
    Route::get('/deck/update/{deck}', [DeckController::class, 'show'])->name('deck.show');
    Route::get('/deck/create',[DeckController::class, 'create_deck'])->name('create.deck');


    Route::get('/carta', [CartaController::class, 'index'])->name('carta');
    Route::post('/carta', [CartaController::class, 'newCard'])->name('carta.store');
    Route::get('/carta/{id}/edit', [CartaController::class, 'getCardId'])->name('get.card.id');
    Route::put('/carta/{id}', [CartaController::class, 'updateCard'])->name('carta.update');
    Route::get('/cartas', [CartaController::class, 'get_all_cards'])->name('carta.all');




    // Nuevas rutas para Sobre
    Route::get('/sobres', [SobreController::class, 'get_cost'])->name('sobres.get');
    Route::post('/sobres/open', [SobreController::class, 'openPack'])->name('sobres.open');
    Route::get('/shop/random-cards', [ShopController::class, 'randomShopCards'])->name('shop.randomCards');
    // User routes
    Route::prefix('user')->group(function () {
        Route::get('/profile/{id?}', [UserController::class, 'show'])->name('user.profile');
        Route::put('/update', [UserController::class, 'update'])->name('user.update');
        Route::post('/add-friend/{id}', [UserController::class, 'addFriend'])->name('user.addFriend');
        Route::get('/friends', [UserController::class, 'getFriends'])->name('user.friends');
        Route::post('/select-deck', [UserController::class, 'selectDeck'])->name('user.selectDeck');
    });

    Route::get('/play', [PlayController::class, 'index'])->name('play');
    Route::get('/shop', [ShopController::class, 'index'])->name('shop');

    Route::post('/game/matchmaking', [PrePartidaController::class, 'getInMatchMaking'])->name('game.matchmaking');

    //game

});
