<?php

namespace App\Http\Controllers;

use App\Custom\Carta\Carta;
use App\Models\Card;
use Illuminate\Http\Request;
use App\Custom\Carta\Facades\CartaFacade;


class CartaController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $card;
    public function __construct(Card $card)
    {
        ;

        $this->card = $card;
    }

     /**
     * Devuelve la vista carta
     *
     * @return view
     */
    public function index()
    {
        return view('carta');
    }

    /**
     * Devuelve la vista carta
     *
     * @return view
     */
    public function update(Request $request,$id)
    {
        $carta = Card::get_card_by_id($id)["value"]->first();
        return view('updateCarta')->with('carta',$carta);
    }


    /**
     * Recibe request valida con el Facade Carta y guarda carta en BBDD
     *
     * @return view
     */

    public function newCard(Request $request)
    {
        $respuesta = CartaFacade::validateCard($request);
        //Error 406 = no aceptable
        if($respuesta["status"]===406){
            return redirect('carta')
            ->withErrors($respuesta["value"])
            ->withInput();
        }
        $card = $this->card->set_new_card($respuesta["value"]);
        if (isset($card))return view('carta',["failed"=>"An error was ocurred"]);

        return view('carta',["success"=>"Card added succesfully"]);
    }

    /**
     * Recibe request valida con el Facade Carta y guarda carta en BBDD
     *
     * @return view
     */

     public function updateCard(Request $request)
     {
         $respuesta = CartaFacade::validateUpdatedCard($request);
         //Error 406 = no aceptable
         if($respuesta["status"]===406){
             return redirect()
             ->route('updateCarta',[$request->input("id")])
             ->withErrors($respuesta["value"])
             ->withInput()
             ->with("carta",$request->all());
         }
         $card = $this->card->update_card($respuesta["value"]);
        return redirect()
        ->route('updateCarta',[$request->input("id")])
        ->with(["success"=>"Card added succesfully","carta"=>$card]);
     }

     public function get_all_cards()
     {
        return $this->card->get_all();
     }
}
