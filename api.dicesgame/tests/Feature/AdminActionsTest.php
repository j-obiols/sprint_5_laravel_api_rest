<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Player;
use App\Models\Game;

use Database\Seeders\RoleSeeder;

class AdminActionsTest extends TestCase {


    use RefreshDatabase; 


    /** @test */
    public function admin_can_retrieve_users_list(){

        $this -> seed(RoleSeeder::class);

        $user = User::create([
            'name'=>'admin',
            'email'=>'admin@mail.mail',
            'password'=>bcrypt($password='password')
        ]);

        $user->assignRole('admin');

        $response =  $this->post('v1/users/login', [
            'email' => 'admin@mail.mail',
            'password' =>$password
        ]);

        $this->actingAs($user, 'api');

        $response = $this->withHeaders(['Accept'=> 'application/json'])->get('v1/users');
        
        $response->assertStatus(200);
        
        $this->assertCount(1, User::all());

    }


    /** @test */
    public function admin_can_retrieve_players_list() {

        $this -> seed(RoleSeeder::class);
        
        $user = User::create([
            'name'=>'admin',
            'email'=>'admin@mail.mail',
            'password'=>bcrypt($password='password')
        ]);

        $user1 = User::create([
            'name'=>'Alex',
            'email'=>'alex@mail.mail',
            'password'=>bcrypt($password='password')
        ]);

        $user->assignRole('admin');

        $response =  $this->post('v1/users/login', [
            'email' => 'admin@mail.mail',
            'password' =>$password
        ]);

        $this->assertAuthenticatedAs($user);

        $this->actingAs($user, 'api');

        $response = $this->withHeaders(['Accept'=> 'application/json'])->get('v1/players');

        $response->status(200);
        $this->assertCount(2, User::all());

    }


    /** @test */
    public function admin_can_delete_a_player_game_list() {

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

        $game1 = Game::create([
            'dice1' => 6,
            'dice2' => 1,
            'gameResult' => 'Won',
            'player_id' => $player1 ->id
        ]);

        $this->assertCount(1, Game::all());


        $response =  $this->post('v1/users/login', [
            'email' => 'admin@mail.mail',
            'password' =>$password
        ]);

        $this->assertAuthenticatedAs($user1);

        $this->actingAs($user1, 'api');

        $response = $this->withHeaders(['Accept'=> 'application/json'])->delete('v1/players/1/games');

        $response->status(200);

        $this->assertCount(2, User::all());

        $this->assertCount(1, Player::all());

        $this->assertCount(0, Game::all());

    }


    /** @test */
    public function admin_can_retrieve_the_ranking() {

        $this -> seed(RoleSeeder::class);
        
        $user = User::create([
            'name'=>'Admin',
            'email'=>'admin@mail.mail',
            'password'=>bcrypt($password='password')
        ]);
        
        $user->assignRole('admin');

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
            'numberOfGames' => 100,
            'wonGames' => 20,
            'percentWon'=> 20,
            'user_id'=>$user2->id
        ]);

        $player2->user->assignRole('player');

        $response =  $this->post('v1/users/login', [
            'email' => 'admin@mail.mail',
            'password' =>$password
        ]);

        $this->assertAuthenticatedAs($user);

        $this->actingAs($user, 'api');

        $response = $this->withHeaders(['Accept'=> 'application/json'])->get('v1/players/ranking');

        $response->assertStatus(200);
        
        $this->assertCount(3, User::all());
        $this->assertCount(2, Player::all());

    }


    /** @test */
    public function admin_can_retrieve_the_winner() {

        $this -> seed(RoleSeeder::class);

        $user = User::create([
            'name'=>'Admin',
            'email'=>'admin@mail.mail',
            'password'=>bcrypt($password='password')
        ]);
        
        $user->assignRole('admin');
        
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
            'email' => 'admin@mail.mail',
            'password' =>$password
        ]);

        $this->assertAuthenticatedAs($user);

        $this->actingAs($user, 'api');

        $response = $this->withHeaders(['Accept'=> 'application/json'])->get('v1/players/winner');

        $response->assertStatus(200);

        $response->assertJson([
            'data' => ['name' => 'Maria',
            'numberOfGames' => 4,
            'wonGames' => 2,
            'percentWon'=> 50,
            'averagePercentWon'=> 50]
        ]);
    
        $this->assertCount(3, User::all());
        $this->assertCount(2, Player::all());
        $this->assertCount(6, Game::all());
    }


    /** @test */
    public function admin_can_retrieve_the_loser() {

        $this -> seed(RoleSeeder::class);

        $user = User::create([
            'name'=>'Admin',
            'email'=>'admin@mail.mail',
            'password'=>bcrypt($password='password')
        ]);
        
        $user->assignRole('admin');
        
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
            'email' => 'admin@mail.mail',
            'password' =>$password
        ]);

        $this->assertAuthenticatedAs($user);

        $this->actingAs($user, 'api');

        $response = $this->withHeaders(['Accept'=> 'application/json'])->get('v1/players/loser');

        $response->assertStatus(200);

        $response->assertJson([
            'data' => ['name' => 'Alex',
            'numberOfGames' => 2,
            'wonGames' => 1,
            'percentWon'=> 50,
            'averagePercentWon'=> 50]
        ]);
       

        $this->assertCount(3, User::all());
        $this->assertCount(2, Player::all());
        $this->assertCount(6, Game::all());
    }


    /** @test */
    public function admin_cannot_change_a_user_name(){

        $this -> seed(RoleSeeder::class);

        $admin = User::create([
            'name'=>'Admin',
            'email'=>'admin@mail.mail',
            'password'=>bcrypt($password1='saturday')
        ]);

        $admin->assignRole('admin');

        $user = User::create([
            'name'=>'Alex',
            'email'=>'alex@mail.mail',
            'password'=>bcrypt($password2='password')
        ]);

        $response =  $this->post('v1/users/login', [
            'email' => 'admin@mail.mail',
            'password' =>$password1
        ]);

        $this->assertAuthenticatedAs($admin);

        $this->actingAs($admin, 'api');

        $response = $this -> put('v1/users/' .$user->id, [
            'name' => 'Joan Manuel'
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'errors' => [
                'message' =>  'Unauthorized.'
            ]
        ]);

        $this->assertCount(2, User::all());

        $user = $user -> fresh();

        $this -> assertEquals($user->name,'Alex');

    }

}