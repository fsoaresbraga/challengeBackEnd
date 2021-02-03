<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovementAccount extends Model
{
    protected $fillable = ['id', 'account_id', 'movement_id', 'value', 'created_at'];
}
