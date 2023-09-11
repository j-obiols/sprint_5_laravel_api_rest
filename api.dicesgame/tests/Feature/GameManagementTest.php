<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Player;
use App\Models\Game;

use Database\Seeders\RoleSeeder;


class GameManagementTest extends TestCase {


    use RefreshDatabase; 


    /** @test */
    public function a_player_can_store_a_game() {

        $this -> seed(RoleSeeder::class);
        
        $user1 = User::create([
            'name'=>'Alex',
            'email'=>'alex@mail.mail',
            'password'=>bcrypt($password='password')
        ]);
        
        $user2 = User::create([
            'name'=>'Víctor',
            'email'=>'victor@mail.mail',
            'password'=>bcrypt($password='password')
        ]);

        $player1 = Player::create([
            'name'=>'Víctor',
            'numberOfGames' => 0,
            'wonGames' => 0,
            'percentWon'=> 0,
            'user_id'=>$user2->id
        ]);

        $player1->user->assignRole('player');

        $response =  $this->post('v1/users/login', [
            'email' => 'victor@mail.mail',
            'password' =>$password
        ]);

        $this->assertAuthenticatedAs($user2);

        $this->actingAs($user2, 'api');

        $response = $this->withHeaders(['Accept'=> 'application/json'])->post('v1/players/1/games');

        $response->status(200);

        $this->assertCount(2, User::all());

        $this->assertCount(1, Player::all());

        $this->assertCount(1, Game::all());


    }


    public function a_player_can_retrieve_his_games_list() {

        $this -> seed(RoleSeeder::class);
        
        $user1 = User::create([
            'name'=>'Alex',
            'email'=>'alex@mail.mail',
            'password'=>bcrypt($password='password')
        ]);
        
        $user2 = User::create([
            'name'=>'Víctor',
            'email'=>'victor@mail.mail',
            'password'=>bcrypt($password='password')
        ]);

        $player1 = Player::create([
            'name'=>'Víctor',
            'numberOfGames' => 0,
            'wonGames' => 0,
            'percentWon'=> 0,
            'user_id'=>$user2->id
        ]);

        $player1->user->assignRole('player');

        $response =  $this->post('v1/users/login', [
            'email' => 'victor@mail.mail',
            'password' =>$password
        ]);

        $this->assertAuthenticatedAs($user2);

        $this->actingAs($user2, 'api');

        $response = $this->withHeaders(['Accept'=> 'application/json'])->get('v1/players/1/games');

        $response->status(200);

        $this->assertCount(2, User::all());

        $this->assertCount(1, Player::all());

    }

    /** @test */
    public function a_player_cannot_delete_his_games_list() {

        $this -> seed(RoleSeeder::class);
        
        $user1 = User::create([
            'name'=>'admin',
            'email'=>'admin@mail.mail',
            'password'=>bcrypt($password='password')
        ]);

        $user1->assignRole('admin');
        
        $user2 = User::create([
            'name'=>'Víctor',
            'email'=>'victor@mail.mail',
            'password'=>bcrypt($password='password')
        ]);

        $player1 = Player::create([
            'name'=>'Víctor',
            'numberOfGames' => 0,
            'wonGames' => 0,
            'percentWon'=> 0,
            'user_id'=>$user2->id
        ]);

        $player1->user->assignRole('player');

        $game1 = Game::create([
            'dice1' => 6,
            'dice2' => 1,
            'gameResult' => 'Won',
            'player_id' => $player1->id
        ]);

        $this->assertCount(1, Game::all());


        $response =  $this->post('v1/users/login', [
            'email' => 'victor@mail.mail',
            'password' =>$password
        ]);

        $this->assertAuthenticatedAs($user2);

        $this->actingAs($user2, 'api');

        $response = $this->withHeaders(['Accept'=> 'application/json'])->delete('v1/players/1/games');

        $response->assertJson([
            'message' => 'This action is unauthorized.'
        ]);
        
        $response->assertStatus(403);

        $this->assertCount(2, User::all());

        $this->assertCount(1, Player::all());

        $this->assertCount(1, Game::all());

    }


}
