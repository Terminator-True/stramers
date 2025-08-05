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
    public function randomShopCards(Request $request)
    {
        $cards = Card::query()
            ->with('user', function ($query) use ($request) {
                $query->where('user_id', '!=', $request->user()->id);
            })
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


    public function get_ruleta_card(Request $request)
    {
        $user = $request->user();

        // Probabilidades: 4% épica, 1% legendaria, el resto común/normal
        $request->validate([
            'rarity' => 'required|in:common,normal,epic,legendary',
        ]);
        $rarity = $request->input('rarity');

        // Buscar una carta aleatoria de esa rareza y que el usuario tenga menos de 2 veces
        $card = Card::query()
            ->where('rarity', $rarity)
            ->where('obtainable', true)
            ->whereDoesntHave('user', function ($query) use ($user) {
                $query->where('user_id', $user->id)->wherePivot('quantity', '>=', 2);
            })
            ->inRandomOrder()
            ->first();

        // Si no hay carta disponible de esa rareza, buscar cualquier carta obtenible que el usuario tenga menos de 2 veces
        if (!$card) {
            $card = Card::query()
                ->where('obtainable', true)
                ->whereDoesntHave('user', function ($query) use ($user) {
                    $query->where('user_id', $user->id)->wherePivot('quantity', '>=', 2);
                })
                ->inRandomOrder()
                ->first();
        }

        // Si aún no hay carta, devolver error
        if (!$card) {
            return ['status'=>404, 'value'=>'No hay cartas disponibles'];
        }

        // Aquí podrías añadir la carta al usuario si lo deseas
        // $user->cards()->attach($card->id, ['quantity' => 1]);

        return ['status'=>200, 'value'=>$card];
    }

    // Simula una probabilidad: true si sale 1 entre $probabilidad
    private function _probabilidad($probabilidad)
    {
        return rand(1, $probabilidad) === 1;
    }



}
