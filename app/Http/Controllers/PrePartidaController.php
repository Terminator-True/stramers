<?php

namespace App\Http\Controllers;

use App\Events\MatchMakingEvent;
use App\Models\User;
use App\Models\Game;
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
                $user->set_status(2);
                $user->save();

                $game_abaliable = Game::query()->where('status',0)->first();

                if(!$game_abaliable){
                    $game = Game::create([
                        'name' => 'Partida de '.$user->nick,
                        'status' => 0,
                        'winner' => null
                    ]);
                    return ['status' => 200,'data'=>$game, 'message' => 'Esperando a otro jugador'];
                }

                $user->set_status(3);
                $user->save();
                $game_abaliable->status = 1;
                $game_abaliable->save();
                $game_abaliable->users()->attach($user->id);
                event(new MatchMakingEvent($game_abaliable));
                return ['status' => 200, 'message' => 'Partida encontrada', 'game' => $game_abaliable];

            }
            return false;

        }catch(Exception $e){
            return null;
        }
    }

    

}
