<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Background extends Model
{

    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'backgrounds';
    protected $fillable = [
        'name',
        'img',
        'color',
        'cost',
        'rarity'
    ];

    public function user()
    {
        return $this->belongsToMany(User::class);
    }

}
