<?php

namespace App\Http\Controllers\Api;

use App\Models\Game;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\User;
use App\Http\Resources\GameResource;
USE App\Exceptions\GeneralJsonException;

class GameController extends Controller {

    
    public function index() {
    
        /** @var \App\Models\MyUserModel $user **/
        $user = auth()->user();
        
        $player = $user->player;

        $playerGames = Game::all()->where('player_id', $player->id);

        return GameResource::collection($playerGames);

    }
    
    
    public function store($id) {
    
        /** @var \App\Models\MyUserModel $user **/
        $user = auth()->user();

        $player = $user->player;

        if ($id != $player->id) {
            throw new GeneralJsonException(message: 'Unauthorized.', code: 401);
        }

        if(!$player){
            throw new GeneralJsonException(message: 'Something went wrong. Please try again', code: 404);
        }

        $game = Game::create([
            'dice1'=>random_int(1,6),
            'dice2'=>random_int(1,6),
            'gameResult'=>'',
            'player_id'=>$player->id
        ]);
            
        $game->save();

        $player->checkAndStore($game);
        
        return GameResource::make($game);

    }


    public function destroy($id) {
   
        /** @var \App\Models\MyUserModel $user **/
        $admin = auth()->user();

        $player = Player::find($id);

        if($player){

            $player_id = $player->id;

            $playerGames = Game::where('player_id', $player_id)->get();

            if($playerGames->count() == 0) {
                throw new GeneralJsonException(message: 'This player has no games to delete', code: 404);
            }

            foreach($playerGames as $playerGame){

                $playerGame -> delete();

            }
            
            $player -> reset();
                
            $playerGames = Game::where('player_id', $player_id)->get();

            return GameResource::collection($playerGames);
            

        } else {

            throw new GeneralJsonException(message: 'Player not found', code: 404);

        }
        
    }

}
