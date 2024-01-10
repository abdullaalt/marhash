<?php

namespace App\Services\V1\Teams;

use App\Http\Resources\V1\PointResource;
use App\Models\Team;

use App\Http\Resources\V1\TeamResource;
use App\Http\Resources\V1\TeamBindResource;

final class TeamsItemsService extends TeamsService{

    public function getUserTeams(int $user_id, bool|null $as_resource = false):object{

        $teams = Team::getUserTeams($user_id);

        return !$as_resource ? $teams : TeamResource::collection($teams);

    }

    public function teamsPersons($team_id){

        if (!$this->isAccessToTeamForPeronsList($team_id)){
            return response()->json(['error' => 'Нет доступа'], 403);
        }

        $binds = $this->getTeamPersons($team_id);

        return TeamBindResource::collection($binds);

    }

    public function teamPoints($team_id){

        if (!$this->isAccessToTeamForPeronsList($team_id)){
            return response()->json(['error' => 'Нет доступа'], 403);
        }

        $binds = $this->getTeamPoints($team_id);

        return PointResource::collection($binds);

    }

    public function teamInvitations($team_id){

        if (!$this->isAccessToTeamForPeronsList($team_id)){
            return response()->json(['error' => 'Нет доступа'], 403);
        }

        $binds = $this->getTeamInvitations($team_id);

        return TeamBindResource::collection($binds);

    }

}