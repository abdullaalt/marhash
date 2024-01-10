<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\UserResource;

class TeamResource extends JsonResource
{
    
    private array $actions = [
        'CELEBRATE' => 'Поздравить и не заходить'
    ];
    /**
     * Преобразовать ресурс в массив.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
	
    {
        return [
            'id'=>$this->id,
            'description'=>$this->description,
            'user' => new UserResource($this->user)
        ];
    }
}