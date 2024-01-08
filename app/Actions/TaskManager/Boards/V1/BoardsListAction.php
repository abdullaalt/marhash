<?php

namespace App\Actions\TaskManager\Boards\V1;

use App\Contracts\V1\TaskManager\Boards\BoardsListActionContract;
use App\Models\Board;
use App\Http\Resources\V1\TaskManager\BoardsListResource;
use App\Services\V1\TaskManager\Boards\BoardsService;

class BoardsListAction implements BoardsListActionContract{

    public function __invoke() {

        $bs = new BoardsService();

        return BoardsListResource::collection($bs->getUserBoardsList());

    }

}