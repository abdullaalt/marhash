<?php

namespace App\Services\V1\Content;

use App\Models\modelsField;
use App\Models\Models;
//use App\Models\instCard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/*
 * 
 */
class ContentService {
	
	public function getData($model){

		$fields = modelsField::where('model', $request->model)->get();
        $model = Models::where('model', $model)->first();

        $items = DB::table($model)->get();
		
		return $items;
	}
	
}