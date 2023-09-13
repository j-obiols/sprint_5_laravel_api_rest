<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Player;
use App\Models\Game;


class PlayerRankingResource extends JsonResource {


    function __construct(Player $model){
    
        parent::__construct($model);
    }

    
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
          
       return [
            'user' => $this -> user -> name,
            'numberOfGames' => $this -> numberOfGames,
            'won Games' => $this -> wonGames,
            'percentWon'=>$this->percentWon,
        ];
        
    }
}
