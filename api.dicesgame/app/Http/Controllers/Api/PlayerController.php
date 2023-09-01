<?php

namespace App\Http\Controllers\Api;

use App\Models\Player;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {

        //$user = Auth::user();

        /*if($user->player()){

            return $user->player();

        }else{

            $player=Player::create([
                'numberOfGames'=>0,
                'wonGames'=>0,
                'percentWon'=>0,
                'user_id'=>$user->id
            ]);


            return $player;
        }*/
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
