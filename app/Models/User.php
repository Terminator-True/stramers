<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Custom\User\UserValidator;
use App\Jobs\MatchMaking;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

//TODO Crear funciónes para modificación de usuarios (Quitar dinero, añadir dinero, ¿Avatar?)

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'money',
        'nick',
        'superadmin',
        'avatar',
        'background_profile',
        'is_online',
        'last_online',
        'is_banned',
        'ban_reason',
        'ban_expires_at',
        'experience_points',
        'level'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relaciones
     */
    public function decks()
    {
        return $this->hasMany(Deck::class, 'user_id');
    }

    public function cards()
    {
        return $this->belongsToMany(Card::class)->withPivot('quantity');
    }

    public function friends()
    {
        return $this->belongsToMany(User::class,'user_user','user_id_slave','user_id_master')->withPivot('friendship_status');
    }

    public function backgrounds()
    {
        return $this->belongsToMany(Background::class);
    }

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class)->withPivot('unlocked_at');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function transactions()
    {
        return $this->hasMany(StoreTransaction::class);
    }

    /**
    * @return money devuelve el dinero del usuario
    */
    public function get_money()
    {
        try {
            return $this->money;
        } catch (Exception $e) {
            return ['status'=>500,'value'=>$e];
        }
    }

     /**
     * @return money actualiza el dinero del usuario
     */
    public function set_money($cantidad=0)
    {
        try {
            if (! is_int($cantidad)) return null;

            $this->money = $cantidad;
            $this->save();
        } catch (Exception $e) {
            return ['status'=>500,'value'=>$e];
        }
    }
    /**
     * Asigna socket id al usuario
     * @param socketId String del socket ID
     * @return void
     */
    public function set_socket_id($socketId = null)
    {
        try
        {
            $this->socket_id = $socketId;
            $this->save();
        } catch (Exception $e)
        {
            return null;
        }
    }

    /**
     * @return boolean devuelve si el usuario es super admin o no
     */
    public function is_sa()
    {
        return $this->superadmin;
    }

    /**
     * Añade las cartas pasadas por parámetro al usuario pasado por parámetro
     * @param Request: <Array> id_cartas , id_user
     * @return Boolean
     */
    public static function AddCard(Request $request)
    {
        try {
            if ($request->has('data') && $request->has('user')) {
                $money = 0;
                $user = User::query()->where('nick',$request['user'])->first();
                $request_cards = $request['data'];
                //Hacemos una búsqueda de las IDs de las cartas que actualmente tiene el usuario
                if(count($user->cards)>0)
                {
                    $cartas_user = $user->cards->toQuery()->pluck('id')->toArray();
                    //Comparamos las cartas, las que el usuario ya tiene no se añadirán
                    $cartas_nuevas = array_diff($request_cards, $cartas_user);
                }else{
                    $cartas_nuevas = $request_cards;
                }
                // Añade todas las tarjetas nuevas al usuario de una sola vez
                $user->cards()->attach($cartas_nuevas);

                $cartas_repetidas = array_diff($request_cards, $cartas_nuevas);
                //Si hay cartas repetidas, suma una cantidad de dinero por cada repetición
                if (count($cartas_repetidas)>0) {
                    $categories = Card::whereIn('id', $cartas_repetidas)
                                        ->pluck('category');
                    for ($i=0; $i < count($cartas_repetidas); $i++) {

                        if ($categories[$i]=='legendaria') {
                            $money+=2000;
                        }

                        if($categories[$i]=='epica'){
                            $money+=1000;
                        }

                        if($categories[$i]==' pocoComun'){
                            $money+=400;
                        }

                        if($categories[$i]=='comun'){
                            $money+=300;
                        }
                    }
                    $user->money = $user->money+$money;
                    $user->save();
                }

                return ['status'=>200, 'value'=>$money];
                // return ['status'=>200, 'value'=>$tarjetas_nuevas]; //DEBUG
            }
            return null;
        } catch (Exception $e) {
            // return ['status'=>500, 'value'=>$e->getMessage()];
            return ['status'=>500, 'value'=>$e->getMessage()];
        }
    }

    /**
     * Agrega como amigo a un usuario pasado por parámetro
     * @param Int Id del usuario a agregar
     * @return Boolean
     */
    public static function AddFriend($id)
    {
        try {
            if (is_int($id) && $id>0) {
                $user_master = User::where('id',$id)->first();
                $user_slave = Auth::user();
                $user_slave->friends()->attach($user_master->id);
                $user_master->friends()->attach($user_slave->id);

                return true;
            }
            return null;
        } catch (Exception $e) {
            // return ['status'=>500, 'value'=>$e->getMessage()]; //DEBUG
            return false;
        }
    }

    /**
     * Cambia el estatus al usuario que pasamos por parámetro
     * @param $status
     * @param $user Usuario a cambiar el status
     * @return bool
     */
    public function changeStatus($status)
    {
        try {

            if (is_int($status)) {
               $this->status = $status;
               $this->save();
               return true;
            }
            return false;

        } catch (Exception $e) {
            return null;
        }
    }

    public function updateUser(Request $request)
    {
        try {
            if ($request->has('name')
            && $request->has('nick'))
            {
                $updates = ['name'=>$request->input('name'),'nick'=>$request->input('nick')];
                $user = User::query()->where('nick',$request->input('nick'));

                if ($request->has('avatar') && $request->input('avatar')!=null) {
                    $img = Card::query()->where('name',$request->input('avatar'))->first();
                    $updates['avatar'] =  $img->img;
                }

                if ($request->has('background') && $request->input('background')!=null) {
                    $back = Background::query()->where('name', $request->input('background'))->first();
                    $updates['background_profile'] = $back->id;
                }

                $user->update($updates);

                return $user;
            }
        } catch (Exception $e) {
            return null;
            // return $e->getMessage();
        }
    }

    /**
     * Selecciona el mazo que utilizará el usuario por defecto
     */
    public function select_mazo(Request $request)
    {
        try
        {
            if ($request->has('name')) {
                $mazo = Deck::query()
                ->where('name',$request->input('name'))
                ->where('user_id',Auth::user()->id)
                ->first();
                if($mazo->selected == 1)return false;

                $desMazo = Deck::query()
                                ->where('selected',1)
                                ->where('user_id',Auth::user()->id)
                                ->first();

                if($desMazo) $desMazo->update(['selected'=>0]);

                $mazo->update(['selected'=>1]);
                return $mazo->cards;
            }
            return false;
        } catch (Exception $e)
        {
            return null;
            // return $e->getMessage();
        }
    }

    public function get_selected_mazo()
    {
        try
        {
            $selected = Deck::query()
                        ->where('selected', 1)
                        ->where('user_id',Auth::user()->id)
                        ->first();
            return $selected;

        } catch (Exception $e)
        {
            return null;
        }
    }

    /**
     * Cambia el status del jugador al pasado por parámetro
     */
    public function set_status($status)
    {
        try
        {
            $this->status = $status;
            $this->save();


        } catch(Exception $e)
        {
            return $e->getMessage();
        }
    }

}
