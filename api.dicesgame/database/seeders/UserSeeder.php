<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       User::create([
            'name'=>'Max Gol',
            'email'=>'max@mail.mail',
            'password'=>bcrypt('45454545')
            //Asign role Admin
       ]);

       User::factory(10)->create();
    }
}