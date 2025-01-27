<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Sobre extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'sobres';

    protected $fillable = [
        'name',
        'type',
        'cost',
        'rarity',
        'cards_count'
    ];

    private function _getCartasSobre(Array $tipoCartas, Sobre $sobre)
    {
        if ($sobre->rareza == 0) {
            //4% de posibilidades
            if ($this->_probabilidad(25)) {
                array_push($tipoCartas,'epica');
            }
            //1%
            if ($this->_probabilidad(100)) {
                array_push($tipoCartas,'legendaria');
            }
        }

        if ($sobre->rareza == 1) {
            //15% de posibilidades
            if ($this->_probabilidad(8)) {
                array_push($tipoCartas,'legendaria');
            }
        }
        if ($sobre->rareza == 2) {
            //25% de posibilidades
            if ($this->_probabilidad(4)) {
                $pos = array_search('legendaria',$tipoCartas);
                unset($tipoCartas[$pos]);
            }
        }

        return $tipoCartas;
    }

    private function _probabilidad($posibilidades)
    {
        $num = rand(0,$posibilidades);
        $num1 = rand(0,$posibilidades);

        return $num == $num1;
    }



    public function get_cost()
    {
        $costeSobres = [];
        $allSobre = $this::query()->where('id','>',0)->get(['name','cost']);

        foreach ($allSobre as $key => $value) {
            $costeSobres[$value['name']] = $value['cost'];
        }

        return $costeSobres;
    }


    public function genera_sobre(Request $request)
    {
        try {
            $cartas = [];
            $sobre = $request['data'];
            $usuarioReal = User::query()->where('nick',$request['user'])->first();
            $dinero = $usuarioReal->money;

            $tipoSobre = $this::query()->where('name',$sobre)->first();
            $tipoCartas = explode(',',$tipoSobre->type);

            if ($tipoSobre->cost > $dinero) return ['status'=>400, 'value'=>'Not enough money'];


            $usuarioReal->set_money($dinero - $tipoSobre->cost);
            $cartas = Card::where('obtainable',true);//TODO Cambiar en producción
            //Generamos el tipo de cartas que nos van a tocar en el sobre
            $tipoCartas = $this->_getCartasSobre($tipoCartas,$tipoSobre);

            $cartas = $cartas->whereIn('category',$tipoCartas)
                ->inRandomOrder()
                ->limit(5)
                ->get()
                ->toArray();

            $id = array_map(function($carta){
                return $carta['id'];
            },$cartas);

            return ['status'=>200, 'value'=>['id'=>$id,'cards'=>$cartas]];
        } catch (Exception $e) {
            return ["status"=>500,"value"=>$e];
        }
    }
}
