<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Deck;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MazoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $deck;
    private $user;
    public function __construct(Deck $deck, User $user)
    {
        ;
        $this->deck = $deck;
        $this->user = $user;
    }

     /**
     * Devuelve la vista mazos
     *
     * @return view
     */
    public function index()
    {
        return Inertia::render('Mazos', ['mazos'=> Auth::user()->decks]);

    }
    /**
    * Devuelve la vista createMazo
    *
    * @return view
    */
   public function new()
   {
    return Inertia::render('createMazo', ['cartas'=>Auth::user()->cards]);
    //    return view('createMazo', ['cartas'=>Auth::user()->cards]);
   }
    /**
    * Devuelve la vista updateMazo
    *
    * @return view
    */
   public function update($id)
   {
        $mazo = $this->deck->get_deck_by_id($id);
        $mazoName = $mazo['value']->name;
        $mazo = $mazo['value']->cards->toArray();
        $mazoJSON = json_encode($mazo);
        $cards = array_map(function($carta){
            return $carta['id'];
        }, $mazo);

        return view('updateMazo', ['cartas'=>Auth::user()->cards, 'mazo'=>$mazo, 'idCartasMazo'=>$cards, 'mazoJSON'=>$mazoJSON, 'mazoName'=>$mazoName]);
   }

    /**
    * Crea el mazo para el usuario
    *
    * @return view
    */
   public function add(Request $request)
   {
    if ($request->hasAny('cards')) {
        return Deck::create($request);
    }
       return null;
   }

    /**
    * Actualiza el mazo para el usuario
    *
    * @return view
    */
   public function updateDeck(Request $request)
   {
    if ($request->hasAny('cards')) {
        return $this->deck->updateDeck($request);
    }
       return null;
   }

   /**
    * Elimina el mazo pasado por parámetro
    */
   public function remove(Request $request)
   {
    if ($request->has('id')) {
        return $this->deck->remove($request);
    }
    return null;
   }

   public function select(Request $request)
   {
    if ($request->has('name')) {
        return $this->user->select_mazo($request);
    }
    return null;
   }

}
