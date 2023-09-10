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
            
            $playerGames = Game::where('player_id', $player->id) ->get();
            $numberOfGames = $playerGames->count();
            $player->setNumberOfGames($numberOfGames);

            $wonPlayerGames = Game::where('player_id', $player->id)
                 ->where('gameResult', 'Won')
                 ->get();
            $wonGames = $wonPlayerGames->count();
            $player->setWonGames($wonGames);

            $numberOfGames = $player -> numberOfGames;
            $wonGames = $player -> wonGames;

            $percentWon = round(($wonGames/$numberOfGames*100), 0);

            $player -> setPercentWon($percentWon);
            $player -> save();

        }

    }

}
