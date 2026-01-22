<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Game;

class LibraryItem extends Model
{
    protected $fillable = [
        'user_id',
        'game_id',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
