<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <-- toevoegen
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory; // <-- toevoegen

    protected $fillable = ['title', 'console', 'description', 'price', 'file_path'];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }
}
