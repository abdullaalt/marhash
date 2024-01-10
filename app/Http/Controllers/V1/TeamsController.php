<?php

namespace App\Http\Controllers\V1;

use App\Http\Requests\TeamsRequest;
use Illuminate\Http\Request;

use App\Services\V1\Teams\TeamsItemsService;
use App\Services\V1\Teams\TeamsStoreService;

final class TeamsController extends Controller{

    public function teams(TeamsItemsService $teamsItemsService):object{

        $teams = $teamsItemsService->getUserTeams(request()->user()->id);

        return $teams;

    }

    public function addTeam(TeamsRequest $request, TeamsStoreService $teamsStoreService):object{

        return $teamsStoreService->addTeam($request);

    }

    public function updateTeam(TeamsRequest $request, TeamsStoreService $teamsStoreService):object{

        return $teamsStoreService->updateTeam($request);

    }

    public function deleteTeam($point_id, teamsStoreService $teamsStoreService):object{

        return $teamsStoreService->deleteTeam($point_id);

    }

    public function teamPersons(int $team_id, TeamsItemsService $teamsItemsService):object{
        return $teamsItemsService->teamsPersons($team_id);
    }

    public function teamPoints(int $team_id, TeamsItemsService $teamsItemsService):object{
        return $teamsItemsService->teamPoints($team_id);
    }

    public function addPoints(int $team_id, Request $request, TeamsStoreService $teamsStoreService):object{
        return $teamsStoreService->addPoints($team_id, $request);
    }

    public function deletePoints(int $team_id, Request $request, TeamsStoreService $teamsStoreService):object{
        return $teamsStoreService->deletePoints($team_id, $request);
    }

    public function teamInvitations(int $team_id, TeamsItemsService $teamsItemsService):object{
        return $teamsItemsService->teamInvitations($team_id);
    }

    public function addInvitation(int $team_id, Request $request, TeamsStoreService $teamsStoreService):object{
        return $teamsStoreService->addInvitation($team_id, $request);
    }

    public function acceptInvitation(int $team_id, Request $request, TeamsStoreService $teamsStoreService):object{
        return $teamsStoreService->acceptInvitation($team_id, $request);
    }

}