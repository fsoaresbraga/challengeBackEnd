<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Account;
use App\MovementAccount;
use App\User;
use App\Http\Requests\StoreUserRequest;
use Carbon\Carbon;
class UserController extends Controller
{   

   
    
    public function index()
    {   
        $users = User::with('account')->get();
        if(isset($users) && $users->count() > 0)
            return $users;
        else
            return \Response::json('Não encontramos nenhum Usúario',404);
        
    }

    
    public function store(StoreUserRequest $request)
    {  
       

        $dateBirthday = Carbon::parse($request->birthday);
        $dateCurrent = Carbon::now();
        $resultDate = $dateBirthday->diffInYears($dateCurrent); 
        if($resultDate >= 18)
        {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->birthday = $dateBirthday;
            
            if($user->save())
            {
                $account = new Account;
                $account->user_id = $user->id;
                $account->balance = 0.00;
                $account->save();
                
                return User::with('account')->get();
            }

        }
        else
        {
            return \Response::json('Apenas maiores de 18 Anos',404);
        }

    }

    
    public function show($id)
    {   
        $user = User::with('account')->find($id);
        if(isset($user) && $user->count() > 0)
            return $user;
        else
            return \Response::json('Não encontramos nenhum Usúario',404);
    }

   
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {   
        $user = User::with('account')->find($id);
        $movement = MovementAccount::where(['account_id'=> $id])->get();

         if(isset($user) && $user->count() > 0)
        {
            if($user->account->balance <= 0 && $movement->count() <= 0)
            {   
                if(User::find($id)->delete())
                    return User::with('account')->get();
                    
            }
            else
            {

                return \Response::json('Erro ao excluir! Este usuário possui Saldo ou Movimentações',404);            
            }
        
        }
        else
        {
            return \Response::json('Não foi possível excluir o usuário',404);
        } 

    }

    public function newBalance(Request $request, $id)
    {   
        
        $newBalance = Account::where('user_id', $id)->get();
        if(isset($newBalance) && $newBalance->count() > 0)
        {
            if(Account::where('user_id', $id)->update(['balance' => $request->balance]))
                return User::with('account')->find($id);
            else
                return \Response::json('Erro ao atualizar Saldo.',404);
        }
        else
        {
            return \Response::json('Não encontramos nenhum Usúario.',404);
        }

    }

    public function balanceWithMovements($id)
    {   
        $users = Account::with(['user', 'movementsAccount'])->find($id);
        if(isset($users) && $users->count() > 0)
        {
            if($users->movementsAccount->count() > 0)
            {
                $balanceMovements ='';
                $balanceCredit =[];
                $balanceDebt =[];
                $balanceChargeback =[];
                foreach($users->movementsAccount as $movement)
                {   
                  //print_r($movement->pivot->value);
                     if($movement->name == 'Crédito')
                        array_push($balanceCredit, $movement->pivot->value);
                    
                    else if($movement->name == 'Estorno')
                        array_push($balanceChargeback, $movement->pivot->value);
                    else
                        array_push($balanceDebt, $movement->pivot->value);
                    
                   $balanceMovements = $users->balance;
                }
                $newBalance = ($balanceMovements + array_sum($balanceCredit) + array_sum($balanceChargeback)) -  array_sum($balanceDebt);

                if(Account::where('user_id', $id)->update(['balance' => $newBalance]))
                    return User::with('account')->find($id);
                else
                    return \Response::json('Erro ao atualizar Saldo.',404);
            }   
            else
            {
                return \Response::json('Não encontramos nenhuma Movimentação.',404);
            }
        }
        else
        {
            return \Response::json('Não encontramos nenhum Usúario.',404);
        }


    }


   
}
