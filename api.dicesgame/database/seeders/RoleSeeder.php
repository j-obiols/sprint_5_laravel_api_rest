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
        $user = Role::create(['name' => 'user']);

        $show_user = Permission::create(['name' => 'users.show']);
        $edit_user = Permission::create(['name' => 'users.edit']);
        $update_user = Permission::create(['name' => 'users.update']);
        $delete_user = Permission::create(['name' => 'users.delete']);
        $index_users = Permission::create(['name' => 'users.index']);
      
        $create_player = Permission::create(['name' => 'players.store']);
        $index_players = Permission::create(['name' => 'players.index']);
        $ranking_players = Permission::create(['name' => 'players.ranking']);
        $winner_player = Permission::create(['name' => 'players.winner']);
        $loser_player = Permission::create(['name' => 'players.loser']);

        $create_game = Permission::create(['name' => 'games.store']);
        $index_games = Permission::create(['name' => 'games.index']);
        $delete_list_games = Permission::create(['name' => 'games.delete']);
        
       
        
        $admin ->syncPermissions([$index_users, $index_players, $ranking_players, $winner_player, $loser_player]);
        $user ->syncPermissions([$show_user, $edit_user, $update_user, $delete_user, $create_player, $create_game, $index_games, $delete_list_games, $ranking_players, $winner_player, $loser_player]);
        
    }

}
