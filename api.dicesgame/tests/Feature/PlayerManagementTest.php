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
use App\Models\Game;

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
    public function an_existing_player_in_database_can_be_retrieved() {

        $this -> seed(RoleSeeder::class);
        
        $user = User::create([
            'name'=>'Alex',
            'email'=>'alex@mail.mail',
            'password'=>bcrypt($password='password')
        ]);

        $player = Player::create([
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


    /** @test */
    public function a_player_cannot_retrieve_a_list_of_players() {

        $this -> seed(RoleSeeder::class);
        
        $user = User::create([
            'name'=>'Alex',
            'email'=>'alex@mail.mail',
            'password'=>bcrypt($password='password')
        ]);

        $player = Player::create([
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

        $response = $this->withHeaders(['Accept'=> 'application/json'])->get('v1/players');

        $response->assertJson([
            'message' => 'This action is unauthorized.'
        ]);
        
        $response->assertStatus(403);
        
        
        $this->assertCount(1, User::all());
        $this->assertCount(1, Player::all());

    }


    /** @test */
    public function a_player_cannot_retrieve_a_list_of_users() {

        $this -> seed(RoleSeeder::class);

        $user = User::create([
            'name'=>'Alex',
            'email'=>'alex@mail.mail',
            'password'=>bcrypt($password='password')
        ]);


        $player = Player::create([
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

        $response = $this->withHeaders(['Accept'=> 'application/json'])->get('v1/users');
        
        $response->assertJson([
            'message' => 'This action is unauthorized.'
        ]);
        
        $response->assertStatus(403);
        
        $this->assertCount(1, User::all());

    }


    /** @test */
    public function a_player_can_retrieve_the_ranking() {

        $this -> seed(RoleSeeder::class);
        
        $user1 = User::create([
            'name'=>'Alex',
            'email'=>'alex@mail.mail',
            'password'=>bcrypt($password='password')
        ]);

        $player1 = Player::create([
            'numberOfGames' => 5,
            'wonGames' => 1,
            'percentWon'=> 20,
            'user_id'=>$user1->id
        ]);

        $player1->user->assignRole('player');

        $user2 = User::create([
            'name'=>'Maria',
            'email'=>'maria@mail.mail',
            'password'=>bcrypt($password='password')
        ]);

        $player2 = Player::create([
            'name'=>'Maria',
            'numberOfGames' => 100,
            'wonGames' => 20,
            'percentWon'=> 20,
            'user_id'=>$user2->id
        ]);

        $player2->user->assignRole('player');

        $response =  $this->post('v1/users/login', [
            'email' => 'alex@mail.mail',
            'password' =>$password
        ]);

        $this->assertAuthenticatedAs($user1);

        $this->actingAs($user1, 'api');

        $response = $this->withHeaders(['Accept'=> 'application/json'])->get('v1/players/ranking');

        $response->assertStatus(200);
        
        $this->assertCount(2, User::all());
        $this->assertCount(2, Player::all());

    }


    /** @test */
    public function a_player_can_retrieve_the_winner() {

        $this -> seed(RoleSeeder::class);
        
        $user1 = User::create([
            'name'=>'Alex',
            'email'=>'alex@mail.mail',
            'password'=>bcrypt($password='password')
        ]);

        $player1 = Player::create([
            'numberOfGames' => 2,
            'wonGames' => 1,
            'percentWon'=> 50,
            'user_id'=>$user1->id
        ]);

        $player1->user->assignRole('player');

        $user2 = User::create([
            'name'=>'Maria',
            'email'=>'maria@mail.mail',
            'password'=>bcrypt($password='password')
        ]);

        $player2 = Player::create([
            'numberOfGames' => 4,
            'wonGames' => 2,
            'percentWon'=> 50,
            'user_id'=>$user2->id
        ]);

        $player2->user->assignRole('player');

        Game::create([
            'dice1' =>  1,
            'dice2' =>  3,
            'gameResult' => 'Lost',
            'player_id' => $player1->id
        ]);

        Game::create([
            'dice1' =>  1,
            'dice2' =>  6,
            'gameResult' => 'Won',
            'player_id' => $player1->id
        ]);

        Game::create([
            'dice1' =>  2,
            'dice2' =>  3,
            'gameResult' => 'Lost',
            'player_id' => $player2->id
        ]);

        Game::create([
            'dice1' =>  6,
            'dice2' =>  3,
            'gameResult' => 'Lost',
            'player_id' => $player2->id
        ]);

        Game::create([
            'dice1' =>  2,
            'dice2' =>  5,
            'gameResult' => 'Won',
            'player_id' => $player2->id
        ]);

        Game::create([
            'dice1' =>  4,
            'dice2' =>  3,
            'gameResult' => 'Won',
            'player_id' => $player2->id
        ]);

        $response =  $this->post('v1/users/login', [
            'email' => 'alex@mail.mail',
            'password' =>$password
        ]);

        $this->assertAuthenticatedAs($user1);

        $this->actingAs($user1, 'api');

        $response = $this->withHeaders(['Accept'=> 'application/json'])->get('v1/players/winner');

        $response->assertStatus(200);

        $response->assertJson([
            'data' => ['name' => 'Maria',
            'numberOfGames' => 4,
            'wonGames' => 2,
            'percentWon'=> 50,
            'averagePercentWon'=> 50]
        ]);
       

        $this->assertCount(2, User::all());
        $this->assertCount(2, Player::all());
        $this->assertCount(6, Game::all());
    }


    /** @test */
    public function a_player_can_retrieve_the_loser() {

        $this -> seed(RoleSeeder::class);
        
        $user1 = User::create([
            'name'=>'Alex',
            'email'=>'alex@mail.mail',
            'password'=>bcrypt($password='password')
        ]);

        $player1 = Player::create([
            'numberOfGames' => 2,
            'wonGames' => 1,
            'percentWon'=> 50,
            'user_id'=>$user1->id
        ]);

        $player1->user->assignRole('player');

        $user2 = User::create([
            'name'=>'Maria',
            'email'=>'maria@mail.mail',
            'password'=>bcrypt($password='password')
        ]);

        $player2 = Player::create([
            'numberOfGames' => 4,
            'wonGames' => 2,
            'percentWon'=> 50,
            'user_id'=>$user2->id
        ]);

        $player2->user->assignRole('player');

        Game::create([
            'dice1' =>  1,
            'dice2' =>  3,
            'gameResult' => 'Lost',
            'player_id' => $player1->id
        ]);

        Game::create([
            'dice1' =>  1,
            'dice2' =>  6,
            'gameResult' => 'Won',
            'player_id' => $player1->id
        ]);

        Game::create([
            'dice1' =>  2,
            'dice2' =>  3,
            'gameResult' => 'Lost',
            'player_id' => $player2->id
        ]);

        Game::create([
            'dice1' =>  6,
            'dice2' =>  3,
            'gameResult' => 'Lost',
            'player_id' => $player2->id
        ]);

        Game::create([
            'dice1' =>  2,
            'dice2' =>  5,
            'gameResult' => 'Won',
            'player_id' => $player2->id
        ]);

        Game::create([
            'dice1' =>  4,
            'dice2' =>  3,
            'gameResult' => 'Won',
            'player_id' => $player2->id
        ]);

        $response =  $this->post('v1/users/login', [
            'email' => 'alex@mail.mail',
            'password' =>$password
        ]);

        $this->assertAuthenticatedAs($user1);

        $this->actingAs($user1, 'api');

        $response = $this->withHeaders(['Accept'=> 'application/json'])->get('v1/players/loser');

        $response->assertStatus(200);

        $response->assertJson([
            'data' => ['name' => 'Alex',
            'numberOfGames' => 2,
            'wonGames' => 1,
            'percentWon'=> 50,
            'averagePercentWon'=> 50]
        ]);
       

        $this->assertCount(2, User::all());
        $this->assertCount(2, Player::all());
        $this->assertCount(6, Game::all());
    }


}
