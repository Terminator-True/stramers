<?php

namespace App\Models;
use Error;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Deck extends Model
{
    use HasFactory, SoftDeletes;

    // protected $table = 'decks';
    protected $fillable = [
        'user_id',
        'name',
        'selected',
        'usos',
        'card_count'
    ];

    /**
     * Relaciones
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cards()
    {
        return $this->belongsToMany(Card::class);
    }


    /**
     * Devuelve todos los mazo relacionados con el usuario especificado
     * por su ID
     *
     * @param int $userId ID del usuario a buscar
     *
     * @return Collection Coleccion de mazos relacionados al usuario
     */
    public static function getAllByUserId($userId)
    {
        return static::where('user_id', $userId)->get();
    }

    /**
     * @param deck_id ID de la carta a buscar
     *
     * @return Object devuelve la carta especificada por id
     */
    public function get_deck_by_id($deck_id)
    {
        try {
            $deck = $this::query()
               ->where('id',$deck_id)
               ->first();
            if (! empty($deck)) {
                return ['status'=> 200, 'value'=>$deck];
            }else{
                return ['status'=> 404, 'value'=>null];
            }
        } catch (Exception $e) {
            return ['status'=>500,'value'=>$e];
        }
    }

     /**
     * @param deck_name Name del mazo a buscar
     *
     * @return Object devuelve la carta especificada por id
     */
    public function get_deck_by_name($deck_name)
    {
        try {
            $deck = $this::query()
               ->where('id',$deck_name)
               ->get();

            if (! empty($card)) {
                return ['status'=> 200, 'value'=>$deck];
            }else{
                return ['status'=> 404, 'value'=>null];
            }
        } catch (Exception $e) {
            return ['status'=>500,'value'=>$e];
        }
    }

    public static function create(Request $request)
    {
        try {
            $deck = new Deck();
            $deck->name = $request->input('name');
            $deck->selected = false;
            // $deck->usos = 0;
            $deck->user_id =$request->input('user_id');
            $deck->save();

            //TODO Añadir attach la cantidad de cartas que se mencionen en el request
            //ejemplo: [{"card_id"=>"1","quantity"=>"2"},{"card_id"=>"2","quantity"=>"1"}] 
            //Solo se tiene que hacer un for añadiendo al attach el mismo id, las veces que se mencionen en quantity
            $deck->cards()->attach($request->input('cards'));

            return true;

        } catch (Exception $e) {
           return $e->getMessage();
        }
    }

    public function updateDeck(Request $request)
    {
        try {
            if ($request->has('name') && $request->has('user_id') && $request->has('cards')) {

                $deck = $this::query()->where('user_id', $request->input('user_id'))->first();
                $deck->cards()->sync($request->input('cards'));
                $deck->update(['name'=>$request->input('name')]);

                return true;
            }
            return false;

        } catch (Exception $e) {
           return null;
        }
    }

    public function remove(Request $request)
    {
        try {
            if ($request->has('id')) {
                $deck = $this::query()->where('id',$request->input('id'))->first();
                $deck->update(['selected'=>0]);
                $deck->delete();
                return true;
            }
            return false;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
