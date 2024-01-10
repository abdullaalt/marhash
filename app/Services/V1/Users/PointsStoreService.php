<?php

namespace App\Services\V1\Users;

use App\Models\Point;
use App\Models\TeamsPointsBind;

use App\Http\Resources\V1\PointResource;

final class PointsStoreService extends PointsService{

    public function addPoint($request):object{

        $data = $request->all();
        $data['coords'] = json_encode($data['coords']);

        $data['user_id'] = request()->user()->id;
        
        $point = $this->store($data);

        return new PointResource($point);

    }

    public function updatePoint($request):object{

        if (!$this->isAccessToPoint($request->point_id)){
            return response()->json(['error' => 'Нет доступа'], 403);
        }

        $data = $request->all();
        $data->coords = json_encode($data->coords);

        $point = $this->store($data);

        return new PointResource($point);

    }

    public function deletePoint($point_id){
        if (!$this->isAccessToPoint($point_id)){
            return response()->json(['error' => 'Нет доступа'], 403);
        }

        TeamsPointsBind::where('point_id', $point_id)->delete();
        Point::find($point_id)->delete();
    }

}