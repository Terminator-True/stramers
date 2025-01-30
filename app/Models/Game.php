<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = ['name', 'status', 'winner'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function logs()
    {
        return $this->hasMany(GameLog::class);
    }

}
