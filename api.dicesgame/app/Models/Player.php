<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Player extends Model{

    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'numberOfGames',
        'wonGames',
        'percentWon',
        'user_id'
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'user_id',
    ];


    public function addWonGame(){
        $this -> wonGames +=1;
    }


    public function setNumberOfGames($value) {

        $this -> numberOfGames = $value;
      
    }


    public function setWonGames($value) {

        $this -> wonGames = $value;
      
    }


    public function setPercentWon($value) {

        $this -> percentWon= $value;
      
    }


    public function calculatePercentWon() {

        $wonGames = $this -> wonGames;
        $numberOfGames = $this -> numberOfGames;
        $this -> setPercentWon(round($wonGames/$numberOfGames *100));
        $this -> save();

    }


    public function checkAndStore(Game $game) {
      
        if($game -> dice1 + $game  -> dice2 == 7) {
            $game -> gameResult = 'Won';
            $this -> addWonGame();
        } else {
            $game -> gameResult = 'Lost';
        }
        $game -> save();

        $this -> numberOfGames +=1;
        $this-> save();
        $this -> calculatePercentWon();
        $this-> save();

    }


    public function reset() {
      
        $this -> setNumberOfGames(0);
        $this -> setWonGames(0);
        $this -> setPercentWon(0);
        $this-> save();
    
    }



    //One to One Inverse Relationship
    public function user(){

        return $this->belongsTo(User::class);

    }


    //One to Many Relationship
    public function games(){

        return $this->hasMany(Game::class);

    }

}
