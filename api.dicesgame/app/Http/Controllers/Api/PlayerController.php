<?php

namespace App\Http\Controllers\Api;

use App\Models\Player;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class PlayerController extends Controller
{
    /*public function __construct(){
        $this->middleware('auth:api');
    }*/
    
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * This method is related with the route for a 'New Game' 
     * (or 'Start Playing <nameOfTheGame'>) Button. 
     * It will create a Player only if the User has never played (this  
     * game) before and it`s not found in the Players Table.
     * In any case it will return the Player and his results to the
     * landing view.
    **/
    public function store(){
    
        /** @var \App\Models\MyUserModel $user **/
        $user = auth()->user();

        if(!$user->player){

            $player = Player::create([
               
                'numberOfGames'=>0,
                'wonGames'=>0,
                'percentWon'=>0,
                'user_id'=>$user->id
            ]);
                
            $player->save();
    
            $user->save();

            return response([$player]);
        }

        $player = $user->player;

        return response([$player]);

    }
    

    /**
     * Display the specified resource.
     */
    public function show(Player $player)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Player $player)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Player $player)
    {
        //
    }
}
