<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Player;
use App\Models\User;
use App\Models\Game;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(RoleSeeder::class);

        $this-> call(UserSeeder::class);

        $this-> call(PlayerSeeder::class);

        $this-> call(GameSeeder::class);

        $players=Player::all();
        
        foreach($players as $player) {
            
            $numberOfGames = Game::where('player_id', $player->id) -> count();
            $player->setNumberOfGames($numberOfGames);

            $wonGames = Game::where('player_id', $player->id) -> where('gameResult', 'Won') -> count();
            $player->setWonGames($wonGames);

            $numberOfGames = $player -> numberOfGames;
            $wonGames = $player -> wonGames;

            if ($numberOfGames != 0) {

                $percentWon = round(($wonGames/$numberOfGames*100), 0);
            
            } else {

                $percentWon = 0;
            }

            $player -> setPercentWon($percentWon);

            $player -> save();

        }

    }

}
