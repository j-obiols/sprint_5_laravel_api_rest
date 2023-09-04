<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Player;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
    
        $dice1 = random_int(1,6);
        $dice2 = random_int(1,6);
        
        if($dice1 + $dice2 == 7) {

            $gameResult= 'Won';

        } else {

            $gameResult = 'Lose';
        }

        return [
            'dice1' =>  $dice1,
            'dice2' =>  $dice2,
            'gameResult' => $gameResult,
            'player_id' =>Player::all()->random()->id
        ];
    }
    
}
