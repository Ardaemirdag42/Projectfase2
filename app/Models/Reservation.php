<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['employee_name', 'email', 'item_name', 'date', 'time', 'status'];
}
