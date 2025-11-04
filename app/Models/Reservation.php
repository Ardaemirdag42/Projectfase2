<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['employee_name', 'item_name', 'date', 'time', 'status'];
}
