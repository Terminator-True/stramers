<?php

namespace App\Models;
use Error;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        return $this->belongsToMany(
            Card::class,          // Modelo relacionado
            'card_deck',          // Nombre de la tabla pivote
            'deck_id',            // Clave foránea del modelo Deck (actual)
            'card_id'             // Clave foránea del modelo Card (relacionado)
        )
        ->withPivot('quantity');  // Incluir el campo 'quantity'
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
            DB::enableQueryLog();
            
            $deck = new Deck();
            $deck->name = $request->input('name');
            $deck->selected = false;
            // $deck->usos = 0;
            $deck->user_id =$request->input('user_id');
            // $deck->card_count = x;
            $deck->save();
            
            // TODO attach el que deberia ser para crear pero no va
            foreach ($request->input('cards') as $card) {
                $deck->cards()->attach([
                    $card['cardId'] => ['quantity' => $card['count']]
                ]);
            }

            // Forzr el orden anque no va
            // foreach ($request->input('cards') as $card) {
            //     DB::table('card_deck')->insert([
            //         'deck_id' => $deck->id,
            //         'card_id' => $card['cardId'],
            //         'quantity' => $card['count'],
            //     ]);
            // }

            // Sync anque esto se usa para updatear y remplazar
            // $cardsToSync = [];
            // foreach ($request->input('cards') as $card) {
            //     $cardsToSync[$card['cardId']] = ['quantity' => $card['count']];
            // }
            // $deck->cards()->sync($cardsToSync);

            $queries = DB::getQueryLog();
            dd($queries);

            return response()->json(['message' => 'Deck creado exitosamente', 'deck' => $deck], 201);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
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
