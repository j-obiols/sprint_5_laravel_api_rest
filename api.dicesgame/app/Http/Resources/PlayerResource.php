<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class PlayerResource extends JsonResource{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        
        return [
            'name' => $this -> user -> name,
            'numberOfGames' => $this -> numberOfGames,
            'wonGames' => $this -> wonGames,
            'percentWon'=>$this->percentWon,
        ];
    }

}
