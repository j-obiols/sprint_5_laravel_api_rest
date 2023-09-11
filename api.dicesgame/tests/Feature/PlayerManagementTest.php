<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Factories\UserFactory;
use App\Http\Controllers\Api\RegisterController;
use Database\Seeders\RoleSeeder;

use App\Models\User;
use App\Models\Player;

class PlayerManagementTest extends TestCase
{

    use RefreshDatabase; 

    //ok
    /** @test */
    public function a_registered_user_can_become_a_player() {

        $this -> seed(RoleSeeder::class);
        
        $user = User::create([
            'name'=>'Alex',
            'email'=>'alex@mail.mail',
            'password'=>bcrypt($password='password')
        ]);

        $response =  $this->post('v1/users/login', [
            'email' => 'alex@mail.mail',
            'password' =>$password
        ]);
 
        $this->assertAuthenticatedAs($user);

        $this->actingAs($user, 'api');

        $response = $this->withHeaders(['Accept'=> 'application/json'])->post('v1/players');

        $response->assertJson([
            'data' => ['name' => 'Alex',
            'numberOfGames' => 0,
            'wonGames' => 0,
            'percentWon'=> 0,]
        ]);

        $this->assertCount(1, Player::all());
    }

    

    /** @test */
    public function existing_player_in_database_is_retrieved() {

        $this -> seed(RoleSeeder::class);
        
        $user = User::create([
            'name'=>'Alex',
            'email'=>'alex@mail.mail',
            'password'=>bcrypt($password='password')
        ]);

        $player = Player::create([
            'name'=>'Alex',
            'numberOfGames' => 5,
            'wonGames' => 1,
            'percentWon'=> 20,
            'user_id'=>$user->id
        ]);

        $player->user->assignRole('player');

        $response =  $this->post('v1/users/login', [
            'email' => 'alex@mail.mail',
            'password' =>$password
        ]);
 
        $this->assertAuthenticatedAs($user);

        $this->actingAs($user, 'api');

        $response = $this->withHeaders(['Accept'=> 'application/json'])->post('v1/players');

        $response->assertJson([
            'data' => ['name' => 'Alex',
            'numberOfGames' => 5,
            'wonGames' => 1,
            'percentWon'=> 20,]
        ]);

        $this->assertCount(1, Player::all());
    }
}
