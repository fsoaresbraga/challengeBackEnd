<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreMovementsRequest;
use App\MovementAccount;
use App\Movement;
use App\Account;
use League\Csv\Writer;
use Carbon\Carbon;

class MovementController extends Controller
{
   
    public function index()
    {   
        $movement = Account::with(['user', 'movementsAccount'])->get();
        if(isset($movement) && $movement->count() > 0)
            return $movement;
        else
            return \Response::json('Não encontramos nenhuma movimentação',404);
    }

   
    public function store(StoreMovementsRequest $request)
    {
       
       $account = Account::find($request->account_id);
       $movement = Movement::find( $request->movement_id);
        if(isset($account) && $account->count() > 0 && isset($movement) && $movement->count() > 0)
        { 
            $movementsAccount = new MovementAccount;
            $movementsAccount->account_id = $request->account_id;
            $movementsAccount->movement_id = $request->movement_id;
            $movementsAccount->value =  $request->value;
            if($movementsAccount->save())
                return Account::with(['user','movementsAccount'])->find($request->account_id); 
        }
        else
        {
            return \Response::json('Erro ao realizar Movimentação.',404);
        }


    }

   
    public function show($id)
    {
        //
    }

   
    public function update(Request $request, $id)
    {
        //
    }

   
    public function destroy($idUser, $idMovement)
    {
        $deleteMovement = MovementAccount::where(['account_id'=> $idUser, 'id'=> $idMovement])->get();
        if(isset($deleteMovement) && $deleteMovement->count() > 0)
        {
            if(MovementAccount::where(['account_id'=> $idUser, 'id'=> $idMovement])->delete())
                return Account::with(['user', 'movementsAccount'])->find($idUser);
        }
        else
        {
            return \Response::json('Não foi possível deletar movimentação. Verfique (Usuário ou Movimentação)',404); 
        }
       
    }


    public function export(Request $request, $userId){
        if($request->filter == 'thirty-days')
        {
            $users = DB::table('users')
            ->join('accounts', 'users.id', '=', 'accounts.user_id')
            ->where('accounts.user_id', $userId)
            ->select('users.name','users.email','users.birthday', 'accounts.balance')
            ->get();

            if(isset($users) && $users->count() > 0)
            {
               $users->transform(function($y) {
                   return (array) $y; 
                })->toArray();
            }
            else
            {
                return \Response::json('usuário não Encontrado.',404);
            }
          
           $movements = DB::table('movements')
           ->join('movement_accounts', 'movements.id', '=', 'movement_accounts.movement_id')
           ->where(function ($query) use ($userId) {
               $query->where('movement_accounts.account_id', $userId);
               $query->Where('movement_accounts.created_at',  '>', Carbon::now()->subDays(30));
           })
           ->orderBy('movement_accounts.id')
           ->select('movements.name',  'movement_accounts.value', DB::raw("date_format(movement_accounts.created_at,'%d/%m/%Y') as date"))
           ->get(); 
           if(isset($movements) && $movements->count() > 0)
           {
               $movements->transform(function($x) {
                   return (array) $x; 
                })->toArray();
           }
           else
           {
               return \Response::json('Movimentação Não Encontrada.',404);
           }
           
           $movementsBalance =[];
           foreach($users as $user)
           {
               foreach($movements as $movement)
               {
                   array_push($movementsBalance, $movement['value']);
               }
               array_push($movementsBalance, $user['balance']);
           }
        }
        else if($request->filter == 'all' || $request->filter == null)
        {
           
             $users = DB::table('users')
             ->join('accounts', 'users.id', '=', 'accounts.user_id')
             ->where('accounts.user_id', $userId)
             ->select('users.name','users.email','users.birthday', 'accounts.balance')
             ->get();

             if(isset($users) && $users->count() > 0)
             {
                $users->transform(function($y) {
                    return (array) $y; 
                 })->toArray();
             }
             else
             {
                 return \Response::json('usuário não Encontrado.',404);
             }
           
            $movements = DB::table('movements')
            ->join('movement_accounts', 'movements.id', '=', 'movement_accounts.movement_id')
            ->where(function ($query) use ($userId) {
                $query->where('movement_accounts.account_id', $userId);
            })
            ->orderBy('movement_accounts.id')
            ->select('movements.name',  'movement_accounts.value',DB::raw("date_format(movement_accounts.created_at,'%d/%m/%Y') as date"))
            ->get(); 
            if(isset($movements) && $movements->count() > 0)
            {
                $movements->transform(function($x) {
                    return (array) $x; 
                 })->toArray();
            }
            else
            {
                return \Response::json('Movimentação Não Encontrada.',404);
            }
            
            $movementsBalance =[];
            foreach($users as $user)
            {
                foreach($movements as $movement)
                {
                    array_push($movementsBalance, $movement['value']);
                }
                array_push($movementsBalance, $user['balance']);
            }
        }
        else
        {
            $date = $request->filter;
            $dateFilter = Carbon::createFromFormat('m/y',$date);
            if($dateFilter && $dateFilter->format('m/y') == $date){
                $users = DB::table('users')
                ->join('accounts', 'users.id', '=', 'accounts.user_id')
                ->where('accounts.user_id', $userId)
                ->select('users.name','users.email','users.birthday', 'accounts.balance')
                ->get();
    
                if(isset($users) && $users->count() > 0)
                {
                   $users->transform(function($y) {
                       return (array) $y; 
                    })->toArray();
                }
                else
                {
                    return \Response::json('usuário não Encontrado.',404);
                }
              
               $movements = DB::table('movements')
               ->join('movement_accounts', 'movements.id', '=', 'movement_accounts.movement_id')
               ->where(function ($query) use ($userId,$dateFilter) {
                   $query->where('movement_accounts.account_id', $userId);
                   
                   $query->whereMonth('movement_accounts.created_at', $dateFilter->format('m'))->whereYear('movement_accounts.created_at', $dateFilter->format('Y'));
               })
               ->orderBy('movement_accounts.id')
               ->select('movements.name',  'movement_accounts.value', DB::raw("date_format(movement_accounts.created_at,'%d/%m/%Y') as date"))
               ->get(); 

               if(isset($movements) && $movements->count() > 0)
               {
                   $movements->transform(function($x) {
                       return (array) $x; 
                    })->toArray();
               }
               else
               {
                   return \Response::json('Movimentação Não Encontrada.',404);
               }
               
               $movementsBalance =[];
               foreach($users as $user)
               {
                   foreach($movements as $movement)
                   {
                       array_push($movementsBalance, $movement['value']);
                   }
                   array_push($movementsBalance, $user['balance']);
               }
            }else{
                return \Response::json('Data Invalída.',404);
            } 
        }

      
        if(isset($movements) && $movements->count() > 0 && isset($users) && $users->count() > 0)
        {

        
            $csv = Writer::createFromFileObject(new \SplTempFileObject());
            foreach($users as $user)
            {   
                $csv->insertOne(["NOME\r\n", "E-MAIL\r\n", "ANIVERSÁRIO\r\n", "SALDO\r\n"]);
                $csv->insertOne($user);
                $csv->insertOne([""]);
                $csv->insertOne([""]);
                $csv->insertOne(["MOVIMENTAÇÕES\r\n","VALOR\r\n","DATA\r\n"]);
                foreach($movements as $movement)
                { 
                    $csv->insertOne($movement);
                }
            }
            $csv->insertOne([""]);
            $csv->insertOne([""]);
            $csv->insertOne(["SALDO TOTAL\r\n"]);
            $csv->insertOne([array_sum($movementsBalance)]);
        
            $csv->output('Movimentação-'.Carbon::parse(now())->format('d-m-Y h-i-s').'.csv');  
        }
    }
}
