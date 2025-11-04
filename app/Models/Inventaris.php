<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    use HasFactory;

    protected $table = 'inventaris';

    protected $fillable = [
        'naam',
        'categorie',
        'aantal',
        'locatie',
    ];

    public function mutaties()
    
{
    return $this->hasMany(Mutatie::class);
}

}
