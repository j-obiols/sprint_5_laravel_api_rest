<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Player extends Model
{
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
    //Temporarily not hidden for testing purpose
    /*protected $hidden = [
        'user_id',
    ];*/


    public function setNumberOfGames($value) {
        $this -> numberOfGAmes = $value;
    }


    public function setWonGames($value) {
        $this -> wonGames = $value;
    }


    public function setPercentWon($value) {
        $this -> percentWon = $value;
    }


    //One to One Inverse Relationship
    public function user(){

        return $this->belongsTo(User::class);

    }

}
