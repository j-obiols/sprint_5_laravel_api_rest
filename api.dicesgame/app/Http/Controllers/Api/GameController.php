<?php

namespace App\Http\Controllers\Api;

use App\Models\Game;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\User;
use App\Http\Resources\GameResource;


class GameController extends Controller {

    
    public function index() {
    
        /** @var \App\Models\MyUserModel $user **/
        $user = auth()->user();
        $player = $user->player;

        $playerGames = Game::all()->where('player_id', $player->id);

        return GameResource::collection($playerGames);

    }

    
    public function store() {
    
        /** @var \App\Models\MyUserModel $user **/
        $user = auth()->user();
        $player = $user->player;

        if($player) {
 
            $game = Game::create([
                'dice1'=>random_int(1,6),
                'dice2'=>random_int(1,6),
                'gameResult'=>'',
                'player_id'=>$user->player->id
            ]);
            
            $game->save();

            $player->checkAndStore($game);
        
            return GameResource::make($game);

        } else {

            return response()->json(['message' => "You are not yet in player's list. Please logout, then login again and follow the appropiate links."],  401);
              
        }
        
    }


    public function destroy(Game $game) {
   
        /** @var \App\Models\MyUserModel $user **/
        $user = auth()->user();
        $player = $user->player;

        $playerGames = Game::all()->where('player_id', $player->id);
        
        foreach($playerGames as $playerGame){
            $playerGame -> delete();
        }
        
        $player -> reset();
        
        $playerGames = Game::all()->where('player_id', $player->id);

        return GameResource::collection($playerGames);
    }

}
