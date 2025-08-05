<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShopController extends Controller
{
    /**
     * Devuelve 3 cartas aleatorias para la tienda
     * @return \Illuminate\Http\JsonResponse
     */
    public function randomShopCards()
    {
        $cards = Card::query()
            ->where('obtainable', true)
            ->inRandomOrder()
            ->limit(3)
            ->get();
        return response()->json(['status' => 200, 'cards' => $cards]);
    }

    public function index() {
        // Aquí podrías cargar los datos necesarios para la tienda, como las cartas disponibles, precios, etc.
        return Inertia::render('Shop/Shop');
    }


    /**
     * @param Request
     * @return Bool
     */
    public function addCardToUser(Request $request)
    {
        return User::AddCard($request);
    }
}
