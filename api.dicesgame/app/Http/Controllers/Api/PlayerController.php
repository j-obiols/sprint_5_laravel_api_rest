<?php

namespace App\Http\Controllers\Api;

use App\Models\Player;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PlayerResource;
use App\Http\Resources\PlayerListResource;
use App\Http\Resources\PlayerRankingResource;
use App\Http\Resources\PlayerWinLosResource;

use App\Models\Game;
use App\Models\User;

class PlayerController extends Controller {

    
    public function index() {
    
       /** @var \App\Models\MyUserModel $user **/
       $user = auth()->user();

       $players = Player::with('user')->get();

       return PlayerListResource::collection($players);

    }
    

    public function store() {
    
        /** @var \App\Models\MyUserModel $user **/
        $user = auth()->user();

        if(!$user->player){

            $player = Player::create([
                'numberOfGames'=>0,
                'wonGames'=>0,
                'percentWon'=>0,
                'user_id'=>$user->id
            ]);

            $player->user->assignRole('player');
                
            $player->save();
    
            $user->save();

            return PlayerResource::make($player);
        }

        $player = $user->player;

        return PlayerResource::make($player);

    }


    public function ranking() {
    
        /** @var \App\Models\MyUserModel $user **/
        $user = auth()->user();
 
        $players = Player::all()->sortBy('percentWon')->reverse();

        $players = Player::checkRanking($players);

        return PlayerRankingResource::collection($players);
 
    }


    public function winner() {
    
        /** @var \App\Models\MyUserModel $user **/
        $user = auth()->user();
 
        $players = Player::all()->sortBy('percentWon')->reverse();

        $winner = Player::checkRanking($players)->first();

        Game::$averagePercentWon = Game::averagePercentWon();

        return PlayerWinLosResource::make($winner);
 
    }


    public function loser() {
    
        /** @var \App\Models\MyUserModel $user **/
        $user = auth()->user();
 
        $players = Player::all()->sortBy('percentWon')->reverse();

        $loser = Player::checkRanking($players)->last();
        
        Game::$averagePercentWon = Game::averagePercentWon();

        return PlayerWinLosResource::make($loser);

    }
 
    
}
