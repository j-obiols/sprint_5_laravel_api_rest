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
            'numberOfGames'=>20,
            'wonGames'=>4,
            'percentWon'=>20,
            'user_id'=>3
        ]);

        Player::create([
            'numberOfGames'=>10,
            'wonGames'=>2,
            'percentWon'=>20,
            'user_id'=>4
        ]);

        Player::create([
            'numberOfGames'=>100,
            'wonGames'=>20,
            'percentWon'=>20,
            'user_id'=>5
        ]);
       
        Player::factory(7)->create();
        
    }
}
