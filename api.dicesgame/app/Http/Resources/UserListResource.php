<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\User;

class UserListResource extends JsonResource {

    function __construct(User $model){
    
        parent::__construct($model);

    }
    
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {
    
        return [
            $this  -> name,
            $this -> email
        ];

    }
}
