<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;


class LoginTest extends TestCase
{

    use RefreshDatabase;


    /** @test */
    public function user_can_login_with_correct_credentials() {

    
        $user = User::create([
            'name'=>'Authenticated',
            'email'=>'auth@mail.mail',
            'password'=>bcrypt($password='laravel')
       ]);

       $response =  $this->post('v1/login', [
           'email' => $user ->email,
           'password' => $password
       ]);

       $this->assertAuthenticatedAs($user);

    }


    /** @test */
    public function user_cannot_login_with_invalid_mail() {
        
        $user = User::create([
            'name'=>'Alex',
            'email'=>'alex@mail.mail',
            'password'=>bcrypt($password='saturday')
        ]);

       $response =  $this->post('v1/login', [
           'email' => 'maria@mail.mail',
           'password' => $password
       ]);


       $this->assertGuest();
    
    }


    /** @test */
    public function user_cannot_login_with_invalid_password() {
        
        $user = User::create([
            'name'=>'Alex',
            'email'=>'alex@mail.mail',
            'password'=>bcrypt($password='saturday')
        ]);

        $response =  $this->post('v1/login', [
           'email' => $user ->email,
           'password' =>'invalid-password'
        ]);

       $this->assertGuest();

    }


    /** @test */
    public function user_cannot_login_if_email_is_null() {
        
        $user = User::create([
            'name'=>'Alex',
            'email'=>'alex@mail.mail',
            'password'=>bcrypt($password='saturday')
        ]);

       $response =  $this->post('v1/login', [
           'email' => '',
           'password' =>$password
       ]);
       

        $response->assertSessionHasErrors([
          'email'=>'The email field is required.'
        ]);
    
    }


    /** @test */
    public function user_cannot_login_if_email_is_not_an_email() {
        
        $user = User::create([
            'name'=>'Alex',
            'email'=>'alex@mail.mail',
            'password'=>bcrypt($password='saturday')
        ]);

       $response =  $this->post('v1/login', [
           'email' => 'cities',
           'password' =>$password
       ]);
       
        $response->assertSessionHasErrors([
          'email'=>'The email field must be a valid email address.'
       ]);
    
    }


    /** @test */
    public function user_cannot_login_if_email_is_not_string() {
        
        $user = User::create([
            'name'=>'Alex',
            'email'=>'alex@mail.mail',
            'password'=>bcrypt($password='saturday')
        ]);

       $response =  $this->post('v1/login', [
           'email' => 12345,
           'password' =>$password
       ]);
       
        $response->assertSessionHasErrors([
          'email'=>'The email field must be a string.'
        ]);
    
    }


    /** @test */
    public function user_cannot_login_if_password_is_empty() {
        
        $user = User::create([
            'name'=>'Alex',
            'email'=>'alex@mail.mail',
            'password'=>bcrypt($password='saturday')
        ]);

       $response =  $this->post('v1/login', [
           'email' => $user ->email,
           'password' =>''
       ]);


       $response->assertSessionHasErrors([
         'password'=>'The password field is required.'
       ]);
    
    }


    /** @test */
    public function user_cannot_login_if_password_is_not_string() {
        
        $user = User::create([
            'name'=>'Alex',
            'email'=>'alex@mail.mail',
            'password'=>bcrypt($password='saturday')
        ]);

       $response =  $this->post('v1/login', [
           'email' => $user ->email,
           'password' =>12345
       ]);


       $response->assertSessionHasErrors([
         'password'=>'The password field must be a string.'
       ]);
    
    }

}
