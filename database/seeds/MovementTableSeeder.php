<?php

use Illuminate\Database\Seeder;
use App\Movement;
class MovementTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $movements = [
            [
                'name'      => 'Débito',
            ],
            [
                'name'      => 'Crédito',
            ],
            [
                'name'      => 'Estorno',
            ],
        ];

        foreach($movements as $movement)
        {

            Movement::create($movement);
        }
    }
}
