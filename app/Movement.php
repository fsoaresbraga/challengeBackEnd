<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MovementAccount;
use App\Account;

class Movement extends Model
{   
    protected $fillable = ['id', 'name'];
    public function movimentAccounts()
    {
        //return $this->hasMany(MovementAccount::class, 'moviment_id', 'id');
        return $this->hasManyThrough(Account::class, MovementAccount::class);
    }

    public function accountUser()
    {
        //return $this->hasMany(MovementAccount::class, 'account_id', 'id');
        return $this->hasOne(Account::class, 'user_id', 'id');
    }
}
