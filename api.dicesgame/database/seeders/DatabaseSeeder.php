<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Player;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this-> call(UserSeeder::class);

        $this-> call(PlayerSeeder::class);

        $players=Player::all();

        foreach($players as $player) {
           
            $wonGames = $player -> wonGames;
            $numberOfGames = $player -> numberOfGames;
            $player -> setPercentWon((int)($wonGames/$numberOfGames *100));
            $player -> save();

        }

        $this-> call(GameSeeder::class);
      
    }
}
