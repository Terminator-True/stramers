<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class Card extends Model
{
    protected $table = 'cards';
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'name',
        'category',
        'type',
        'cost',
        'dmg',
        'life',
        'usos',
        'text',
        'img',
        'obtainable',
        'rarity'
    ];
    /**
     * Relaciones
     */

    public function user()
    {
        return $this->belongsToMany(User::class)->withPivot('quantity');
    }

    public function decks()
    {
        return $this->belongsToMany(Deck::class)->withPivot('quantity');
    }

    /**
     * @return Array devuelve todas las cartas
     */

    public static function get_all()
    {
        try {
            return['status'=>200,'value'=> Card::query()
            ->where('obtainable', true)
            ->get()
            ];

            } catch (\Exception $e) {
                return ['status'=>500,'value'=>$e->getMessage()];
            }
    }

    /**
     * @param card_id ID de la carta a buscar
     *
     * @return Object devuelve la carta especificada por id
     */
    public static function get_card_by_id($card_id)
    {
        try {
            $card = Card::query()
               ->where('id',$card_id)
               ->get();

            if (! empty($card)) {
                return ['status'=> 200, 'value'=>$card];
            }else{
                return ['status'=> 404, 'value'=>null];
            }
        } catch (\Exception $e) {
            return ['status'=>500,'value'=>$e];
        }
    }

    /**
     * @param card_name ID de la carta a buscar
     *
     * @return Object devuelve la carta especificada por id
     */
    public static function get_card_by_name($card_name)
    {
        try {
            $card = Card::query()
               ->where('name',$card_name)
               ->get();

            if (! empty($card)) {
                return ['status'=> 200, 'value'=>$card];
            }else{
                return ['status'=> 404, 'value'=>null];
            }
        } catch (\Exception $e) {
            return ['status'=>500,'value'=>$e];
        }
    }

    /**
     * @param request Información del formulario
     *
     * @return Object
     */
    public static function set_new_card(Request $request)
    {
        if (
            $request->has('name') &&
            $request->has('category') &&
            $request->has('type') &&
            $request->has('cost') &&
            $request->has('life') &&
            $request->has('dmg') &&
            $request->has('text') &&
            $request->has('obtainable') &&
            $request->has('img')
            ) {
                $card = new Card($request->input());
                $card->img = $request->file('img')->store('imgs');
                $card->save();
                //Cargamos la imagen guardada en una variable
                $img = Image::make(Storage::get($card->img));
                //La reescalamos
                $img->resize(274, 364)->encode();
                //La volvemos a guardar
                Storage::put($card->img, (string) $img);

                return $card;
            }
            return null;
    }
    /**
     * @param request Carta a updatear
     *
     * @return Object
     */
    public static function update_card(Request $request)
    {
        $input = $request->all();
        $card = Card::where('id',$input['id'])->first();
        $card->name = $input['name'];
        $card->category = $input['category'];
        $card->type = $input['type'];
        $card->cost = $input['cost'];
        $card->life = $input['life'];
        $card->text = $input['text'];
        $card->dmg = $input['dmg'];
        $card->obtainable = $input['obtainable'];
        $card->updated_at = now();
        if (isset($input["img"])) {
            //Elimina la imagen anterior si existe
            if (Storage::exists($card->img))Storage::delete($card->img);
            // $card->img = $request->file('img')->storeAs('imgs',$request->name.".png");
            $card->img = $request->file('img')->store('imgs');
            //Cargamos la imagen guardada en una variable
            $img = Image::make(Storage::get($card->img));
            //La reescalamos
            $img->resize(274, 364)->encode();
            //La volvemos a guardar
            Storage::put($card->img, (string) $img);
        }
        $card->save();
        return $card;
    }


}
