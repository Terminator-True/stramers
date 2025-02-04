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

    /**
     * Obtiene todos los mazos de un usuario específico
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserDecks(Request $request)
    {
        try {
            $userId = $request->user()->id;
            
            $decks = Deck::getAllByUserId($userId);
            
            return response()->json([
                'status' => 200,
                'data' => $decks
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Error al obtener los mazos: ' . $e->getMessage()
            ], 500);
        }
    }
}
