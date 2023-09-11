<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;


class LoginTest extends TestCase
{

    use RefreshDatabase;

    //ok
    /** @test */
    public function user_can_login_with_correct_credentials() {

    
        $user = User::create([
            'name'=>'Authenticated',
            'email'=>'auth@mail.mail',
            'password'=>bcrypt($password='password')
        ]);

        $response =  $this->post('v1/users/login', [
           'email' => 'auth@mail.mail',
           'password' => $password
        ]);

       $this->assertAuthenticatedAs($user);

    }

    //ok
    /** @test */
    public function user_cannot_login_with_invalid_mail() {
        
        $user = User::create([
            'name'=>'Alex',
            'email'=>'alex@mail.mail',
            'password'=>bcrypt($password='password')
        ]);

       $response =  $this->post('v1/users/login', [
           'email' => 'maria@mail.mail',
           'password' => $password
       ]);

       $response->assertStatus(401);

       $response->assertJson([
        'message' => 'Invalid login credentials.',
       ]);

       $this->assertGuest();
    
    }

    //ok
    /** @test */
    public function user_cannot_login_with_invalid_password() {
        
        $user = User::create([
            'name'=>'Alex',
            'email'=>'alex@mail.mail',
            'password'=>bcrypt($password='password')
        ]);

        $response =  $this->post('v1/users/login', [
           'email' => 'alex@mail.mail',
           'password' =>'invalid-password'
        ]);

        $response->assertStatus(401);

        $response->assertJson([
         'message' => 'Invalid login credentials.',
        ]);
 
        $this->assertGuest();

    }

    //ok
    /** @test */
    public function user_cannot_login_if_email_is_null() {
        
        $user = User::create([
            'name'=>'Alex',
            'email'=>'alex@mail.mail',
            'password'=>bcrypt($password='password')
        ]);

       $response =  $this->post('v1/users/login', [
           'email' => '',
           'password' =>$password
       ]);
       

        $response->assertStatus(422);

        $response->assertJson([
           'email' => [
             0 =>  'The email field is required.'
           ]
        ]);

        $this->assertGuest();
    }

    //ok
    /** @test */
    public function user_cannot_login_if_email_is_not_an_email() {
        
        $user = User::create([
            'name'=>'Alex',
            'email'=>'alex@mail.mail',
            'password'=>bcrypt($password='password')
        ]);

       $response = $this->withHeaders(['Accept'=> 'application/json'])->post('v1/users/login', [
           'email' => 'cities',
           'password' =>$password
       ]);
       
       $response->assertStatus(422);

        $response->assertJson([
          'email' => [
            0 =>  'The email field must be a valid email address.'
          ]
        ]);
      
       $this->assertGuest();
    }

    //ok
    /** @test */
    public function user_cannot_login_if_email_is_not_string() {
        
        $user = User::create([
            'name'=>'Alex',
            'email'=>'alex@mail.mail',
            'password'=>bcrypt($password='password')
        ]);

       $response =  $this->post('v1/users/login', [
           'email' => 12345,
           'password' =>$password
       ]);
       
       $response->assertStatus(422);

       $response->assertJson([
         'email' => [
           0 => 'The email field must be a string.',
           1 =>  'The email field must be a valid email address.'
         ]
       ]);
     
      $this->assertGuest();
    
    }

    //ok
    /** @test */
    public function user_cannot_login_if_password_field_is_empty() {
        
        $user = User::create([
            'name'=>'Alex',
            'email'=>'alex@mail.mail',
            'password'=>bcrypt($password='saturday')
        ]);

       $response =  $this->post('v1/users/login', [
           'email' => 'alex@mail.mail',
           'password' =>''
       ]);


        $response->assertStatus(422);

        $response->assertJson([
            'password' => [
              0 =>  'The password field is required.'
            ]
        ]);
    
        $this->assertGuest();
    }

    //ok
    /** @test */
    public function user_cannot_login_if_password_is_not_string() {
        
        $user = User::create([
            'name'=>'Alex',
            'email'=>'alex@mail.mail',
            'password'=>bcrypt($password='saturday')
        ]);

       $response =  $this->post('v1/users/login', [
           'email' => 'alex@mail.mail',
           'password' =>12345
       ]);

       $response->assertStatus(422);

        $response->assertJson([
            'password' => [
              0 =>  'The password field must be a string.'
            ]
        ]);
    
        $this->assertGuest();
    
    }

}
