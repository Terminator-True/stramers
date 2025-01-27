<?php

namespace App\Http\Controllers;

use App\Custom\Carta\Carta;
use App\Models\Sobre;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TiendaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $user;
    public $sobre;
    public function __construct(User $user, Sobre $sobre)
    {
        ;
        $this->user = $user;
        $this->sobre = $sobre;
    }

    /**
     * Muestra la vista Tienda
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $costeSobre = $this->sobre->get_cost();
        return Inertia::render('Tienda', ['sobres'=>$costeSobre]);
        // return view('tienda', ['sobres'=>$costeSobre]);
    }

     /**
     * @param Request
     * @return Array Cartas aleatorias según el mazo pasado por request
     *
     */
    public function sobre(Request $request)
    {
        try {
            if ($request->has('data')) {
                $sobre = $this->sobre->genera_sobre($request);

                if ($sobre['status'] == 400) return $sobre;


                // return view('sobre', ['cartas'=>$sobre['value']['cards'], 'id'=>json_encode($sobre['value']['id'])]);
            }
            return null;

        } catch (Exception $e) {
            return $e->getMessage();
        }

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
