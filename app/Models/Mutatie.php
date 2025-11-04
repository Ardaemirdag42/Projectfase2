<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mutatie extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventaris_id',
        'type',
        'aantal',
        'opmerking',
    ];

    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class);
    }
}
