<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'dice1',
        'dice2',
        'gameResult',
        'player_id'
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    /*protected $hidden = [
    ];*/


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    /*protected $casts = [
        'percentWonGames' => 'integer',
    ];*/
     

    /*public function checkGameResult(Player $player) {
      
        if($this -> dice1 + $this  -> dice2 == 7) {
            $this -> gameResult = 'Won';
            $player -> addWonGame();
        } else {
            $this -> gameResult = 'Lost';
        }

    }*/


    //One to Many Inverse Relationship
    public function player(){

        return $this->belongsTo(Player::class);

    }

    
}
