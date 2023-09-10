<?php

namespace Database\Seeders;

use App\Models\Player;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlayerSeeder extends Seeder
{
    public function run(): void
    {
        Player::create([
            'numberOfGames'=>2,
            'wonGames'=>1,
            'percentWon'=>50,
            'user_id'=>3
        ]);

        Player::create([
            'numberOfGames'=>4,
            'wonGames'=>2,
            'percentWon'=>50,
            'user_id'=>4
        ]);

        Player::create([
            'numberOfGames'=>6,
            'wonGames'=>3,
            'percentWon'=>50,
            'user_id'=>5
        ]);
       
        Player::factory(7)->create();
        
    }
}
