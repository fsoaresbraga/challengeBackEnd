<?php

use Illuminate\Database\Seeder;
use App\Account;
class AccountTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Accounts = [
            [
                'user_id'      => 1,
                'balance'     => 200,
            ],
            [
                'user_id'      => 2,
                'balance'     => 10.99,
            ],
            [
                'user_id'      => 3,
                'balance'     => 0.00,
            ],
            [
                'user_id'      => 4,
                'balance'     => 1.000,
            ],
            [
                'user_id'      => 5,
                'balance'     =>10.00,
            ],
        ];

        foreach($Accounts as $Account)
        {

            Account::create($Account);
        }
    }
}
