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
            //Asign role Admin
        ]);

        User::create([
            'name'=>'Max 20% and 20 games',
            'email'=>'max@mail.mail',
            'password'=>bcrypt('password')
        ]);

        User::create([
            'name'=>'Pere 20% and 10 games',
            'email'=>'pere@mail.mail',
            'password'=>bcrypt('password')
        ]);

        User::create([
            'name'=>'Víctor 20% and 100 games',
            'email'=>'victor@mail.mail',
            'password'=>bcrypt('password')
        ]);


       User::factory(7)->create();
    }
}
