<?php

use App\Http\Controllers\GameController;
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
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::middleware(['auth:sanctum'])->group(function () {
    //Rutas Web
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/tienda', [TiendaController::class, 'index'])->name('tienda');
    Route::get('/game', [GameController::class, 'index'])->name('game');
    Route::post('/sobre', [TiendaController::class, 'sobre'])->name('tienda.sobre');
    Route::post('/AddUserCard', [TiendaController::class, 'addCardToUser'])->name('user.card');

    Route::prefix('user')->group(function(){
        //Rutas Mensajes
        Route::post('/message', [MensajeController::class, 'new'])->name('user.new.message');//No se usa
        Route::post('/addFriend', [MensajeController::class, 'addFriend'])->name('user.new.friend');
        Route::post('/removeNotification', [MensajeController::class, 'removeNotifiation'])->name('user.eliminar.notificacion');
        Route::post('/friendRequest', [MensajeController::class, 'friendRequest'])->name('user.request.friend');
        Route::post('/getNotifications', [MensajeController::class, 'getNotifications'])->name('user.notifications');
        //Rutas Usuario
        Route::post('/get-friends',[MensajeController::class, 'getFriends'])->name('user.get.friends');
        Route::get('/settings', [SettingsController::class, 'index'])->name('user.settings');
        Route::post('/changeSettings', [SettingsController::class, 'changeSettings'])->name('user.update.settings');
        Route::post('/select', [MazoController::class, 'select'])->name('user.mazo.select');

        Route::get('/match', [PrePartidaController::class, 'getInMatchMaking'])->name('user.match');
        Route::get('/vs', [PrePartidaController::class, 'index'])->name('vs');
    });

    //Rutas Mazos
    Route::get('/mazo', [MazoController::class, 'index'])->name('mazo');
    Route::get('/new', [MazoController::class, 'new'])->name('new.mazo');
    Route::post('/addMazo', [MazoController::class, 'add'])->name('mazo.store');
    Route::post('/removeMazo', [MazoController::class, 'remove'])->name('mazo.remove');
    Route::get('/update/{id}', [MazoController::class, 'update'])->name('mazo.update.index');
    Route::post('/updateDeck', [MazoController::class, 'updateDeck'])->name('update.mazo');

    Route::prefix('admin')->group(function(){
        //Rutas Super admin
        Route::get('/home',[AdminController::class,'index'])->name('admin.home')->middleware('superadmin');
        Route::get('/carta', [CartaController::class, 'index'])->name('admin.carta')->middleware('superadmin');
        Route::get('/updateCarta/{id}', [CartaController::class, 'update'])->name('admin.update.carta')->middleware('superadmin');
        Route::post('/newCard', [CartaController::class, 'newCard'])->name('newCard')->middleware('superadmin');
        Route::post('/updateCard', [CartaController::class, 'updateCard'])->name('updateCard')->middleware('superadmin');

    });

    //Rutas Socket
});
