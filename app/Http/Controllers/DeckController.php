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

    /**
     * Store a newly created deck in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'cards' => 'required|array'
            ]);

            $request->merge(['user_id' => Auth::id()]);
            $result = Deck::create($request);
            if ($result) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Mazo creado exitosamente'
                ]);
            }

            return response()->json([
                'status' => 400,
                'message' => 'Error al crear el mazo'
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Error al crear el mazo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified deck.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $deck = new Deck();
            $result = $deck->get_deck_by_id($id);

            return response()->json($result, $result['status']);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Error al obtener el mazo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified deck in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'cards' => 'required|array'
            ]);

            $deck = new Deck();
            $result = $deck->updateDeck($request);

            if ($result) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Mazo actualizado exitosamente'
                ]);
            }

            return response()->json([
                'status' => 400,
                'message' => 'Error al actualizar el mazo'
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Error al actualizar el mazo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified deck from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $deck = new Deck();
            $result = $deck->remove(new Request(['id' => $id]));

            if ($result === true) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Mazo eliminado exitosamente'
                ]);
            }

            return response()->json([
                'status' => 400,
                'message' => $result
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Error al eliminar el mazo: ' . $e->getMessage()
            ], 500);
        }
    }
    public function create_deck(){
        return Inertia::render('Deck/CreateDeck');
    }
}
