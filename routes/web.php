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
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\ReportController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Welcome/Home Routes
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
    // Dashboard Route
    Route::get('/dashboard', function () {
        return Inertia::render('Menu');
    })->name('dashboard');

    // Main Navigation Routes
    Route::get('/play', [PlayController::class, 'index'])->name('play');
    Route::get('/shop', [ShopController::class, 'index'])->name('shop');

    // Deck Management Routes
    Route::get('/deck', [DeckController::class, 'index'])->name('deck');
    Route::get('/deck_list/{id?}', [DeckController::class, 'getUserDecks'])->name('get.decks');
    Route::post('/deck', [DeckController::class, 'store'])->name('deck.store');
    Route::put('/deck/{deck}', [DeckController::class, 'update'])->name('deck.update');
    Route::delete('/deck/{deck}', [DeckController::class, 'destroy'])->name('deck.destroy');
    Route::get('/deck/{deck}', [DeckController::class, 'show'])->name('deck.show');
    Route::get('/create_deck',[DeckController::class, 'create_deck'])->name('create.deck');
    // Route::post('/deck/{deck}/share', [DeckController::class, 'shareDeck'])->name('deck.share');
    // Route::post('/deck/import', [DeckController::class, 'importDeck'])->name('deck.import');
    // Route::get('/deck/{deck}/stats', [DeckController::class, 'deckStats'])->name('deck.stats');

    // Card Management Routes
    Route::get('/carta', [CartaController::class, 'index'])->name('carta');
    Route::post('/carta', [CartaController::class, 'newCard'])->name('carta.store');
    Route::get('/carta/{id}/edit', [CartaController::class, 'getCardId'])->name('get.card.id');
    Route::put('/carta/{id}', [CartaController::class, 'updateCard'])->name('carta.update');
    Route::get('/cartas', [CartaController::class, 'get_all_cards'])->name('carta.all');
    // Route::get('/inventory', [CartaController::class, 'inventory'])->name('carta.inventory');

    // Pack/Booster Routes
    Route::get('/sobres', [SobreController::class, 'get_cost'])->name('sobres.get');
    Route::post('/sobres/open', [SobreController::class, 'openPack'])->name('sobres.open');
    // Route::get('/sobres/history', [SobreController::class, 'openHistory'])->name('sobres.history');

    // User Management Routes
    Route::prefix('user')->group(function () {
        Route::get('/profile/{id?}', [UserController::class, 'show'])->name('user.profile');
        Route::put('/update', [UserController::class, 'update'])->name('user.update');
        Route::post('/add-friend/{id}', [UserController::class, 'addFriend'])->name('user.addFriend');
        Route::delete('/remove-friend/{id}', [UserController::class, 'removeFriend'])->name('user.removeFriend');
        Route::get('/friends', [UserController::class, 'getFriends'])->name('user.friends');
        Route::post('/select-deck', [UserController::class, 'selectDeck'])->name('user.selectDeck');
        Route::get('/stats', [UserController::class, 'stats'])->name('user.stats');
        Route::get('/match-history', [UserController::class, 'matchHistory'])->name('user.matchHistory');
        Route::put('/change-password', [UserController::class, 'changePassword'])->name('user.changePassword');
    });

    // Game Routes
    Route::prefix('game')->group(function () {
        Route::post('/matchmaking', [PrePartidaController::class, 'getInMatchMaking'])->name('game.matchmaking');
        Route::get('/{id}', [GameController::class, 'show'])->name('game.show');
        Route::post('/{id}/surrender', [GameController::class, 'surrender'])->name('game.surrender');
        Route::get('/history', [GameController::class, 'history'])->name('game.history');
        Route::get('/ranking', [RankingController::class, 'index'])->name('game.ranking');
    });

    // Shop Routes
    Route::prefix('shop')->group(function () {
        Route::get('/purchase-history', [ShopController::class, 'purchaseHistory'])->name('shop.history');
        // Route::get('/product/{id}', [ShopController::class, 'showProduct'])->name('shop.product');
    });

    // Settings Routes
    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('/preferences', [SettingsController::class, 'updatePreferences'])->name('settings.preferences');
        Route::put('/language', [SettingsController::class, 'updateLanguage'])->name('settings.language');
        Route::put('/theme', [SettingsController::class, 'updateTheme'])->name('settings.theme');
    });

    // Social Routes
    Route::prefix('social')->group(function () {
        Route::get('/player/{id}', [UserController::class, 'showPlayer'])->name('social.player');
        Route::post('/message/{id}', [MensajeController::class, 'send'])->name('social.message');
        Route::get('/messages', [MensajeController::class, 'index'])->name('social.messages');
        Route::get('/notifications', [NotificationController::class, 'index'])->name('social.notifications');
    });

    // Support Routes
    Route::prefix('support')->group(function () {
        Route::get('/faq', [HomeController::class, 'faq'])->name('support.faq');
        Route::post('/report', [ReportController::class, 'store'])->name('support.report');
        Route::get('/help', [HomeController::class, 'help'])->name('support.help');
    });
});
