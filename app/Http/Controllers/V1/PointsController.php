<?php

namespace App\Http\Controllers\V1;

use App\Http\Requests\PointsRequest;

use App\Services\V1\Users\PointsItemsService;
use App\Services\V1\Users\PointsStoreService;

final class PointsController extends Controller{

    public function points(PointsItemsService $pointsItemsService):object{

        $points = $pointsItemsService->getUserPoints(request()->user()->id, true);

        return $points;

    }

    public function addPoint(PointsRequest $request, PointsStoreService $pointsStoreService):object{

        return $pointsStoreService->addPoint($request);

    }

    public function updatePoint(PointsRequest $request, PointsStoreService $pointsStoreService):object{

        return $pointsStoreService->updatePoint($request);

    }

    public function deletePoint($point_id, PointsStoreService $pointsStoreService):object{

        return $pointsStoreService->deletePoint($point_id);

    }

}