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
            'id'=>$this['id'],
            'nickname'=>$this['nickname'],
            'avatar'=>$this['profile_photo_path'],
            'group'=>[
                'group_id'=>$this['group_id'],
                'name'=>$this['name'],
                'title'=>$this['title'],
            ],
            'model'=> $this['model_name'] ? [
                'model_name' => @$this['model_name'],
                'item_id' => @$this['item_id']
            ] : null,
            'email' => $this['email'],
            'is_admin' => (bool)$this['is_admin'],
            'phone' => $this['phone']
        ];
    }
}