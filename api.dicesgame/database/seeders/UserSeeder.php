<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void {
    
        User::create([
            'name'=>'Admin',
            'email'=>'admin@mail.mail',
            'password'=>bcrypt('password')
        ])-> assignRole(['admin']);


        User::create([
            'name'=>'User that is not still a player',
            'email'=>'userNotPlayer@mail.mail',
            'password'=>bcrypt('password')
        ]); 


        User::create([
            'name'=>'Max 50% and 2 games',
            'email'=>'max@mail.mail',
            'password'=>bcrypt('password')
        ]) -> assignRole('player');


        User::create([
            'name'=>'Pere 50% and 4 games',
            'email'=>'pere@mail.mail',
            'password'=>bcrypt('password')
        ]) -> assignRole('player');


        User::create([
            'name'=>'Víctor 50% and 6 games',
            'email'=>'victor@mail.mail',
            'password'=>bcrypt('password')
        ]) -> assignRole('player');


        User::factory(7)->create()-> each(function($user) {

            $user -> assignRole('player');

        });
    }
}
