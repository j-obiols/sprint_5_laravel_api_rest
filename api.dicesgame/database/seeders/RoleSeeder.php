<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
    

        $admin = Role::create(['name' => 'admin']);
        $player = Role::create(['name' => 'player']);
        

        $index_users = Permission::create(['name' => 'users.index']);
      
        $index_players = Permission::create(['name' => 'players.index']);
        $ranking_players = Permission::create(['name' => 'players.ranking']);
        $winner_player = Permission::create(['name' => 'players.winner']);
        $loser_player = Permission::create(['name' => 'players.loser']);

        $create_game = Permission::create(['name' => 'games.store']);
        $index_games = Permission::create(['name' => 'games.index']);
        $delete_list_games = Permission::create(['name' => 'games.delete']);
        
       
        $admin ->syncPermissions([$index_users, $index_players, $delete_list_games, $ranking_players, $winner_player, $loser_player]);
        $player ->syncPermissions([$create_game, $index_games, $ranking_players, $winner_player, $loser_player]);
    }

}
