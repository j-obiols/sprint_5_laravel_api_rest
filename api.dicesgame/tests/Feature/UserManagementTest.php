<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Factories\UserFactory;


use App\Models\User;
use App\Http\Controllers\Api\RegisterController;

class UserManagementTest extends TestCase{


    use RefreshDatabase; 


    /** @test */
    public function a_user_can_retrieve_his_data(){

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

        $response =  $this->get('v1/users/' .$user->id);

        $response->assertStatus(200);

        $this->assertCount(1, User::all());

    }


    /** @test */
    public function a_user_can_edit_his_data(){

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

        $response =  $this->get('v1/users/' .$user->id, [
            'name'=>'Alex',
            'email' => 'alex@mail.mail', 
        ]);

        $response->assertOk();

        $this->assertCount(1, User::all());

    }


   /** @test */
   public function a_user_can_update_his_name(){

        $user = User::create([
            'name'=>'Alex',
            'email'=>'alex@mail.mail',
            'password'=>bcrypt($password='saturday')
        ]);

        $response =  $this->post('v1/users/login', [
        'email' => 'alex@mail.mail',
        'password' =>$password
        ]);

        $this->assertAuthenticatedAs($user);

        $this->actingAs($user, 'api');

        $response = $this -> put('v1/users/' .$user->id, [
            'name' => 'Joan Manuel'
        ]);

        $response->assertOk();

        $this->assertCount(1, User::all());

        $user = $user -> fresh();

        $this -> assertEquals($user->name,'Joan Manuel');

    }

    /** @test */
   public function a_user_can_update_his_name_if_name_is_null(){

        $user = User::create([
            'name'=>'Alex',
            'email'=>'alex@mail.mail',
            'password'=>bcrypt($password='saturday')
        ]);

        $response =  $this->post('v1/users/login', [
        'email' => 'alex@mail.mail',
        'password' =>$password
        ]);

        $this->assertAuthenticatedAs($user);

        $this->actingAs($user, 'api');

        $response = $this -> put('v1/users/' .$user->id, [
            'name' => ''
        ]);

        $response->assertOk();

        $this->assertCount(1, User::all());

        $user = $user -> fresh();

        $this -> assertEquals($user->name,'Anonymous');

    }


    /** @test */
   public function a_user_cannot_be_updated_if_name_is_not_string(){

        $user = User::create([
            'name'=>'Alex',
            'email'=>'alex@mail.mail',
            'password'=>bcrypt($password='saturday')
        ]);

        $response =  $this->post('v1/users/login', [
        'email' => 'alex@mail.mail',
        'password' =>$password
        ]);

        $this->assertAuthenticatedAs($user);

        $this->actingAs($user, 'api');

        $response = $this -> put('v1/users/' .$user->id, [
            'name' => 12345
        ]);

        $response->assertStatus(422);

        $response->assertJson([
            'name' => [
            0 =>  'The name field must be a string.'
            ]
        ]);

        $this->assertCount(1, User::all());

        $user = $user -> fresh();

        $this -> assertEquals($user->name,'Alex');

    }

    
    /** @test */
    public function a_user_can_unsubscribe(){

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

        $response =  $this->delete('v1/users/' .$user->id, [
            
        ]);

        $response->assertOk();

        $this->assertCount(0, User::all());

    }


    /** @test */
    public function a_user_cannot_retrieve_users_list(){

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

  
        $response = $this->withHeaders(['Accept'=> 'application/json'])->get('v1/users');
        
        
        $response->assertJson([
            'message' => 'This action is unauthorized.'
        ]);
        
        $response->assertStatus(403);
        
        $this->assertCount(1, User::all());

    }
    

} 

    