<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Game;

class GameSeeder extends Seeder
{

    public function run(): void
    {
        
        Game::create([
            'dice1' =>  1,
            'dice2' =>  3,
            'gameResult' => 'Lost',
            'player_id' => 1
        ]);

        Game::create([
            'dice1' =>  1,
            'dice2' =>  6,
            'gameResult' => 'Won',
            'player_id' => 1
        ]);

        Game::create([
            'dice1' =>  2,
            'dice2' =>  3,
            'gameResult' => 'Lost',
            'player_id' => 2
        ]);

        Game::create([
            'dice1' =>  6,
            'dice2' =>  3,
            'gameResult' => 'Lost',
            'player_id' => 2
        ]);

        Game::create([
            'dice1' =>  2,
            'dice2' =>  5,
            'gameResult' => 'Won',
            'player_id' => 2
        ]);

        Game::create([
            'dice1' =>  4,
            'dice2' =>  3,
            'gameResult' => 'Won',
            'player_id' => 2
        ]);

        Game::create([
            'dice1' =>  2,
            'dice2' =>  3,
            'gameResult' => 'Lost',
            'player_id' => 3
        ]);

        Game::create([
            'dice1' =>  2,
            'dice2' =>  3,
            'gameResult' => 'Lost',
            'player_id' => 3
        ]);

        Game::create([
            'dice1' =>  2,
            'dice2' =>  3,
            'gameResult' => 'Lost',
            'player_id' => 3
        ]);

        Game::create([
            'dice1' =>  2,
            'dice2' =>  5,
            'gameResult' => 'Won',
            'player_id' => 3
        ]);

        Game::create([
            'dice1' =>  3,
            'dice2' =>  4,
            'gameResult' => 'Won',
            'player_id' => 3
        ]);

        Game::create([
            'dice1' =>  1,
            'dice2' =>  6,
            'gameResult' => 'Won',
            'player_id' => 3
        ]);


        Game::factory(50)->create();
    }
}
