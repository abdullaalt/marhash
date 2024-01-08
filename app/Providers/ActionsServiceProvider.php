<?php

namespace App\Providers;

use App\Contracts\V1\TaskManager\Boards\BoardsListActionContract;
use App\Actions\TaskManager\Boards\V1\BoardsListAction;
use App\Actions\Content\V1\ItemContentAction;
use App\Contracts\V1\Content\ItemContentActionContract;

use Illuminate\Contracts\Support\TaskManagerContract;

use Illuminate\TaskManager\TaskManager;

use Illuminate\Support\ServiceProvider;

class ActionsServiceProvider extends ServiceProvider{

    public array $bindings = [

        BoardsListActionContract::class => BoardsListAction::class,
        TaskManagerContract::class => TaskManager::class,
        ItemContentActionContract::class => ItemContentAction::class

    ];


}