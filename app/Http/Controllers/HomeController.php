<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        ;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $mazoSelected = Auth::user()->get_selected_mazo();

        $selected = $mazoSelected!=null ? $mazoSelected->cards:null;

        return Inertia::render('Home', ["mazos"=>Auth::user()->decks,"notificaciones"=>count(Auth::user()->unreadNotifications), 'selected'=>json_encode($selected)]);
        // return view('home')->with(["mazos"=>Auth::user()->decks,"notificaciones"=>count(Auth::user()->unreadNotifications), 'selected'=>json_encode($selected)]);
        // return view('home');
    }
}
