<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\UserResource;

class PointResource extends JsonResource
{
    
    private array $actions = [
        'CELEBRATE' => 'Поздравить и не заходить',
        'GIVEMEMINUTE' => 'Зайду и быстро выйду',
        'TEA' => 'Попьем чай',
        'EAT' => 'Поедим',
        'FULL' => 'И чай и еда',
        'IDONTKNOW' => 'По ситуации'
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
            'user' => new UserResource($this->user),
            'bind' => @$this->TeamsPointsBind->team
        ];
    }
}