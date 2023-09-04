<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Player;

class PlayerManagementTest extends TestCase
{
    use RefreshDatabase; 

    /** @test */
    public function a_registered_user_can_become_a_player() {

        $user = User::create([
            'name'=>'Manuel',
            'email'=>'manuel@mail.mail',
            'password'=>bcrypt($password='laravel')
       ]);

       $this->assertCount(1, User::all());

        $response =  $this->post('v1/login', [
          'email' => $user ->email,
          'password' => $password
        ]);

        $this->assertAuthenticatedAs($user);

        $response = $this->actingAs($user, 'api')
        ->post('v1/players', []);
                
        $response->assertOk();
      
        $this->assertCount(1, Player::all());

        $player = Player::all()->first();

        $user = $user -> fresh();

        $this -> assertEquals($user->id, $player->user_id);

    }
}
