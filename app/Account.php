<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{   
    protected $fillable = array('id', 'user_id', 'balance');
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function movementsAccount(){
        return $this->belongsToMany(Movement::class, 'movement_accounts')->withPivot('value');
    }
}
