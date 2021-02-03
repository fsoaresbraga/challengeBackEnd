<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Account;
use App\MovementAccount;
use App\Movement;
class User extends Model
{   
    protected $fillable = array('nome', 'email', 'birthday');
    public function account(){
        return $this->hasOne(Account::class, 'user_id', 'id');
    }

   
    
}
