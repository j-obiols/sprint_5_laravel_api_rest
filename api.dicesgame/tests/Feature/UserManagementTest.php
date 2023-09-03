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
    public function a_user_can_be_registered()
    {
        
        $this -> withoutExceptionHandling();

        $response = $this->post('v1/register', [
            'name' => 'Max Gol',
            'email' => 'max@mail.mail',
            'password'=>'12341234',
            'password_confirmation'=>'12341234',
        ]);

        $response->assertStatus(200);

        $this->assertCount(1, User::all());

        $user = User::first();

        $this -> assertEquals($user->name, 'Max Gol');
        $this -> assertEquals($user->email, 'max@mail.mail');
    
    }


    /** @test */
    public function a_user_can_be_updated(){

        $user = User::create([
            'name'=>'Alex',
            'email'=>'alex@mail.mail',
            'password'=>bcrypt($password='saturday')
        ]);

       $response =  $this->post('v1/login', [
           'email' => 'alex@mail.mail',
           'password' =>$password
       ]);

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
    public function a_user_can_be_registered_if_name_is_null(){

        $this -> withoutExceptionHandling();

        $response = $this->post('v1/register', [
            'name' => '',
            'email' => 'max@mail.mail',
            'password'=>'12341234',
            'password_confirmation'=>'12341234',
        ]);

        $response->assertStatus(200);

        $this->assertCount(1, User::all());

        $user = User::first();

        $this -> assertEquals($user->name, 'Anonymous');
        $this -> assertEquals($user->email, 'max@mail.mail');


    }

    /** @test */
    public function a_user_cannot_be_registered_if_name_is_not_string() {
    
        $response = $this->post('v1/register', [
            'name' => 123,
            'email' => 'manuel@mail.mail',
            'password'=>'12341234',
            'password_confirmation'=>'12341234',
        ]);

        $this->assertCount(0, User::all());

        $response->assertStatus(422);
        $response->assertJson([
            'name' => [
              0 =>  'The name field must be a string.'
            ]
        ]);
    
    }


    /** @test */
    public function a_user_cannot_be_registered_if_name_is_too_long() {
    
        $response = $this->post('v1/register', [
            'name' => 'Manuelabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcde',
            'email' => 'manuel@mail.mail',
            'password'=>'12341234',
            'password_confirmation'=>'12341234',
        ]);

        $this->assertCount(0, User::all());

        $response->assertStatus(422);
        $response->assertJson([
            'name' => [
              0 =>  'The name field must not be greater than 255 characters.'
            ]
        ]);
    
    }


    /** @test */
    public function a_user_cannot_be_registered_if_email_is_null()
    {
        
        $response = $this->post('v1/register', [
            'name' => 'Max Gol',
            'email' => '',
            'password'=>'12341234',
            'password_confirmation'=>'12341234',
        ]);

        $this->assertCount(0, User::all());

        $response->assertStatus(422);
        $response->assertJson([
            'email' => [
              0 =>  'The email field is required.'
            ]
        ]);
    
    }


    /** @test */
    public function a_user_cannot_be_registered_if_email_is_not_string() {
    
        
        $response = $this->post('v1/register', [
            'name' => 'Max Gol',
            'email' => 1234,
            'password'=>'12341234',
            'password_confirmation'=>'12341234',
        ]);

        $this->assertCount(0, User::all());

        $response->assertStatus(422);
        $response->assertJson([
            'email' => [
              0 =>  'The email field must be a string.'
            ]
        ]);
    
    }


    /** @test */
    public function a_user_cannot_be_registered_if_email_is_not_email() {
    
        
        $response = $this->post('v1/register', [
            'name' => 'Max Gol',
            'email' => 'maxmailmail',
            'password'=>'12341234',
            'password_confirmation'=>'12341234',
        ]);

        $this->assertCount(0, User::all());

        $response->assertStatus(422);
        $response->assertJson([
            'email' => [
              0 =>  'The email field must be a valid email address.'
            ]
        ]);
    
    } 
    

    /** @test */
    public function a_user_cannot_be_registered_if_email_is_too_long(){

        $response = $this->post('v1/register', [
            'name' => 'Max Gol',
            'email' => 'abcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcde@mail.mail',
            'password'=>'12341234',
            'password_confirmation'=>'12341234',
        ]);

        $this->assertCount(0, User::all());

        $response->assertStatus(422);
        $response->assertJson([
            'email' => [
              0 =>  'The email field must not be greater than 255 characters.'
            ]
        ]);

    } 


    /** @test */
    public function a_user_cannot_be_registered_if_email_is_not_unique(){

        $user = User::create([
            'name'=>'Max',
            'email'=>'max@mail.mail',
            'password'=>bcrypt($password='saturday')
        ]);

        $response = $this->post('v1/register', [
            'name' => 'Max Gol',
            'email' => 'max@mail.mail',
            'password'=>$password,
            'password_confirmation'=>$password
        ]);

        $this->assertCount(1, User::all());

        $response->assertStatus(422);
        $response->assertJson([
            'email' => [
              0 =>  'The email has already been taken.'
            ]
        ]);
    }

    /** @test */
    public function a_user_cannot_be_registered_if_password_is_null() {
    
        $response = $this->post('v1/register', [
            'name' => 'Max Gol',
            'email' => 'maxmailmail',
            'password'=>'',
            'password_confirmation'=>'12341234',
        ]);

        $this->assertCount(0, User::all());

        $response->assertStatus(422);
        $response->assertJson([
            'password' => [
              0 =>  'The password field is required.'
            ]
        ]);
    
    } 


    /** @test */
    public function a_user_cannot_be_registered_if_password_is_not_string() {
    
        $response = $this->post('v1/register', [
            'name' => 'Max Gol',
            'email' => 'maxmailmail',
            'password'=> 12345,
            'password_confirmation'=>'12341234',
        ]);

        $this->assertCount(0, User::all());

        $response->assertStatus(422);
        $response->assertJson([
            'password' => [
              0 =>  'The password field must be a string.'
            ]
        ]);
    
    } 


    /** @test */
    public function a_user_cannot_be_registered_if_password_is_too_short() {
    
        $response = $this->post('v1/register', [
            'name' => 'Max Gol',
            'email' => 'maxmailmail',
            'password'=> '1234',
            'password_confirmation'=>'1234',
        ]);

        $this->assertCount(0, User::all());

        $response->assertStatus(422);
        $response->assertJson([
            'password' => [
              0 =>  'The password field must be at least 8 characters.'
            ]
        ]);
    
    } 


    /** @test */
    public function a_user_cannot_be_registered_if_password_is_not_confirmed() {
    
        $response = $this->post('v1/register', [
            'name' => 'Max Gol',
            'email' => 'maxmailmail',
            'password'=> '12341234',
            'password_confirmation'=>'45454545',
        ]);

        $this->assertCount(0, User::all());

        $response->assertStatus(422);
        $response->assertJson([
            'password' => [
              0 =>  'The password field confirmation does not match.'
            ]
        ]);
    
    } 


} 

    