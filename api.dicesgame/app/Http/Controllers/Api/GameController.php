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

        } 
        
    }


    public function destroy($id) {
   
        /** @var \App\Models\MyUserModel $user **/
        $admin = auth()->user();

        $user = User::findOrFail($id);

        $player = $user->player;
        

        if($player){

            $player_id = $user->player->id;

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

            throw new GeneralJsonException(message: 'This user is still not a <this game> player', code: 404);

        }
        
    }

}
