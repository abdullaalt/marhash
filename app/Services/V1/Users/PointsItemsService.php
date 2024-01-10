<?php

namespace App\Services\V1\Users;

use App\Models\Point;

use App\Http\Resources\V1\PointResource;

final class PointsItemsService extends PointsService{

    public function getUserPoints(int $user_id, bool|null $as_resource = false):object{

        $points = Point::getUserPoints($user_id);

        return !$as_resource ? $points : PointResource::collection($points);

    }

}