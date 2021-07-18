<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre', 'games_id','user_id'
    ];
    
    public function game()
    {
        return $this->belongsTo(Game::class);
    }
    public function PartyUser()
    {
        return $this->hasMany(PartyUser::class);
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
