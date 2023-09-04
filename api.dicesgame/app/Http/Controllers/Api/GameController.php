<?php

namespace App\Http\Controllers\Api;

use App\Models\Game;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\User;

class GameController extends Controller
{
    
    public function index()
    {
        //
    }

    
    public function store()
    {
        /** @var \App\Models\MyUserModel $user **/
        $user = auth()->user();
        $player = $user->player;

        if($player) {
 
            $game = Game::create([
                'dice1'=>random_int(1,6),
                'dice2'=>random_int(1,6),
                'gameResult'=>'Win',
                'player_id'=>$user->player->id
            ]);

            $game->save();

            $player->numberOfGames +=1;
            $game->gameResult = $game->gameResult();

            $game->save();

            $wonGames = $player->wonGames;
           
            if($game -> gameResult == 'Won') {
                $wonGames += 1;
            }

            $numberOfGames = $player->numberOfGames;
            $player->percentWon = (int)($wonGames/$numberOfGames *100);
           
            $player->save();
        
            return response([$game]);

        } else {
            return "You are not in player's list.
            Please logout, then login again and follow the appropiate links.";
        }
        

        
 
        //return response([$game]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        //
    }
}
