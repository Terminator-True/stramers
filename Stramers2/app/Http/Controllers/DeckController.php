<?php

namespace App\Http\Controllers;

use App\Models\Deck;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DeckController extends Controller
{
    /**
     * Devuelve la vista principal de los mazos del usuario autenticado
     *
     * @return \Inertia\Response
     */
    public function index() {
        $userId = Auth::id();
        $decks = Deck::getAllByUserId($userId);
        return Inertia::render('Deck/Deck', [
            'decks' => $decks
        ]);
    }
}
