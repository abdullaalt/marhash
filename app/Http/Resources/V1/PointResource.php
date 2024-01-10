<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\UserResource;

class PointResource extends JsonResource
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
            'address'=>$this->address,
            'coords'=>$this->coords,
            'who' => $this->who,
            'action' => $this->actions[$this->action],
            'user' => new UserResource($this->user)
        ];
    }
}