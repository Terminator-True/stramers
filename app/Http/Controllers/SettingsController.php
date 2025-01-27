<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Custom\User\UserValidator;

class SettingsController extends Controller
{

    public function __construct()
    {
        ;

    }

    public function index()
    {
        $cards = Auth::user()->cards->toArray();
        $backgrounds = Auth::user()->backgrounds->toArray();
        $cartas=[];

        foreach ($cards as $key => $card) {
            $cartas[$card['name']] = $card['img'];
        }
        return view('updateUser',['user'=>Auth::user(), 'cartas'=>$cartas, 'backgrounds' => $backgrounds]);
    }

    public function changeSettings(Request $request, User $user)
    {
        $respuesta = UserValidator::validateUser($request);
        $cards = Auth::user()->cards->toArray();
        $backgrounds = Auth::user()->backgrounds->toArray();
        $cartas=[];

        foreach ($cards as $key => $card) {
            $cartas[$card['name']] = $card['img'];
        }
        if($respuesta["status"]===406){
            return view('updateUser',['user'=>Auth::user(), 'cartas'=>$cartas, 'backgrounds' => $backgrounds,"error"=>"Settings not updated"]);
        }
        $user->updateUser($request);

        return view('updateUser',['user'=>Auth::user(), 'cartas'=>$cartas, 'backgrounds' => $backgrounds,"success"=>"Settings updated"]);
    }


}
