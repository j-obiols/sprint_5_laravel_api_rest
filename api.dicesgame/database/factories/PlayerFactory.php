<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        return [
            'numberOfGames' => fake() -> numberBetween(30,50), 
            'wonGames'=>fake() -> numberBetween(1,30),
            'percentWon'=>0,
            'user_id'=>fake() -> unique() -> numberBetween(5, 10),
            //'user_id'=>fake() -> unique() -> numberBetween(1, User::count())
        ];
    }
}
