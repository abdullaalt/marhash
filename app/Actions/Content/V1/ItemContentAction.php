<?php

namespace App\Actions\Content\V1;

use App\Contracts\V1\Content\ItemContentActionContract;
use App\Services\V1\Content\ContentService;
use App\Services\V1\Fields\FieldsService;
use App\Http\Resources\V1\TaskManager\BoardsListResource;

use App\Models\Models;
use Illuminate\Support\Facades\DB;

class ItemContentAction implements ItemContentActionContract{

    public function __invoke($model, $item_id) {

        $cs = new ContentService();

        $model = Models::where('name', $model)->first();

		$fs = new FieldsService();
		$fields = $fs->getModelFields($model->name);

		if (count($fields) < 1){
			return response()->json(['errors'=>['Ошибка доступа']], 403);
		}

		$item = DB::table($model->name)->where('id', $item_id)->first();

        if (!$item){
            return response()->json(['errors'=>['Запись не найдена']], 410);
        }

        return $cs->renderItem($item, $fields, $model);

    }

}