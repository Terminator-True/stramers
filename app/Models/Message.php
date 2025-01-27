<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Message extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public static function new($body, $recipient_id, $sender_id)
    {
        try {

            $mensaje = new Message;
            $mensaje->sender_id = $sender_id;
            $mensaje->recipient_id = $recipient_id;
            $mensaje->body = $body;
            $mensaje->save();
            return $mensaje;
        } catch (Exception $e) {
            return null;
        }
    }

}
