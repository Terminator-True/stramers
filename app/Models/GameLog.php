<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameLog extends Model
{
    protected $fillable = ['action'];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
