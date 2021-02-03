<?php

use Illuminate\Database\Seeder;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name'      => 'José Ferreira',
                'email'     => 'jose@jose.com.br',
                'birthday'  => '1954-12-24',
            ],
            [
                'name'      => 'Luis Alberto',
                'email'     => 'luis@luis.com.br',
                'birthday'  => '1999-07-02',
            ],
            [
                'name'      => 'Rodrigo Faria',
                'email'     => 'rodrigo@rodrigo.com.br',
                'birthday'  => '1978-10-23',
            ],
            [
                'name'      => 'Otávio Silva',
                'email'     => 'otavio@otavio.com.br',
                'birthday'  => '2008-06-10',
            ],
            [
                'name'      => 'Guilherme Rodrigues',
                'email'     => 'guilherme@guilherme.com.br',
                'birthday'  => '2010-06-18',
            ],
        ];

        foreach($users as $user)
        {

            User::create($user);
        }
    }
}
