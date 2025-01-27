<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Exception;

class PrePartidaController extends Controller
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

    public function getInMatchMaking(Request $request)
    {
        try{

            if ($request->has('nick'))
            {
                $user = User::query()->where('nick',$request->input('nick'))->first();
                // $user->set_status(2);
                return true;
            }
            return false;

        }catch(Exception $e){
            return null;
        }

    }

}
