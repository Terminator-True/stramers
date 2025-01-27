<?php

namespace App\Http\Controllers;

use App\Custom\Notification\UserNotification;
use App\Models\Message;
use App\Models\User;
use App\Notifications\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MensajeController extends Controller
{
    public $mensaje;
    public $user;
    public $userNotification;
    public function __construct(Message $mensaje, User $user, UserNotification $userNotification)
    {
        $this->user = $user;
        $this->mensaje = $mensaje;
        ;
        $this->userNotification = $userNotification;
    }
    /**
     * Envía un mensaje a otro usuario
     * @param Request Body y recipient id
     * @return Boolean
     */
    public function new(Request $request)
    {
        //TODO validacion
        if ($request->has('body') && $request->has('recipient_id'))
        {
            //Guarda el nuevo mensaje en la base de datos
            $mensaje = $this->mensaje->new($request['body'], $request['recipient_id'], Auth::id());

            if (! is_null($mensaje)) {
                $recipient = User::query()->where('id', $request['recipient_id'])->first();
                //Generamos una notificación para el usuario al que le enviamos el mensaje
                $recipient->notify(new MessageSent($mensaje, Auth::user()->nick));
                return true;
            }
            return false;
        }
        return null;
    }

    public function addFriend(Request $request)
    {
        if ($request->has('nick')) {
            $user = $this->user->where('nick', $request['nick'])->first();
            return $this->user->AddFriend($user->id);
        }
        return false;
    }

    public function friendRequest(Request $request)
    {
        return $this->userNotification->friendRequest($request);
    }

    public function getNotifications()
    {
        try {

            return Auth::user()->notifications;

        } catch (Exception $e) {
           return null;
        }
    }

    public function getFriends()
    {
        try {
            return Auth::user()->friends;

        } catch (Exception $e) {
           return null;
        }
    }

    public function removeNotifiation(Request $request)
    {
        return $this->userNotification->removeNotification($request);
    }
}

