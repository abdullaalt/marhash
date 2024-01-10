<?php

namespace App\Services\V1\Users;

use App\Models\Point;

abstract class PointsService{

    protected function store(object|array $data){

        if (isset($data['point_id'])){
            $point = Point::find($data['point_id']);
            $point->fill($data);
        }else{
            $point = new Point($data);
        }
        

        $point->save();

        return $point;

    }

    protected function getPoint(int $point_id):object{

        return Point::find($point_id);

    }

    protected function isAccessToPoint(int $point_id):bool{
        $point = $this->getPoint($point_id);

        return $point->user_id == request()->user()->id;
    }

}