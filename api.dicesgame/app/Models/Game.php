<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;


    public static $averagePercentWon;


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
     


    //One to Many Inverse Relationship
    public function player() {

        return $this->belongsTo(Player::class);

    }

   
    public static function averagePercentWon(): int {

        $totalGames = Game::all()->count();
        $totalWon = Game::all()->where('gameResult', 'Won')->count();
        Self::$averagePercentWon = round(($totalWon/$totalGames*100), 0);

        return Self::$averagePercentWon;
    }

    
}
