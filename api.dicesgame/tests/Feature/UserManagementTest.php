<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Http\Controllers\Api\RegisterController;

class UserManagementTest extends TestCase
{
    /** @test */
    public function a_user_can_be_registered()
    {
    
        //$this -> withoutExceptionHandling();

        $response = $this->post('v1/register', [
            'name' => 'Max Gol',
            'email' => 'max@mail.mail',
            'password'=>'12341234',
            'password_confirmation'=>'12341234',
        ]);

        $response->assertOk();

        $this->assertCount(1, User::all());

        $user = User::first();

        $this -> assertEquals($user->name, 'Max Gol');
        $this -> assertEquals($user->email, 'max@mail.mail');
    
    }

}
