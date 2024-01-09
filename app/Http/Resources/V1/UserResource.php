<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;
//use App\Http\Resources\SourceResource;

class UserResource extends JsonResource
{
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
            'username'=>$this->nickname,
            'avatar'=>$this->avatar,
            'email' => $this['email']
        ];
    }
}