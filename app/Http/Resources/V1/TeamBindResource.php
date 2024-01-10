<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\UserResource;

class TeamBindResource extends JsonResource
{
    
    private array $statuses = [
        0 => 'Не принял приглашение',
        1 => 'Принял приглашение'
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
            'user' => new UserResource($this->user),
            'status' => $this->status,
            'status_text' => $this->statuses[$this->status]
        ];
    }
}