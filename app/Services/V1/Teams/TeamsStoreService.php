<?php

namespace App\Services\V1\Teams;

use App\Models\Team;
use App\Models\TeamsUsersBind;

use App\Http\Resources\V1\TeamResource;
use App\Http\Resources\V1\PointResource;

final class TeamsStoreService extends TeamsService{

    public function addTeam($request):object{

        $data = $request->all();

        $data['user_id'] = request()->user()->id;
        
        $team = $this->store($data);
        
        $this->addPersonToTeam(request()->user()->id, $team->id, 1);

        return new TeamResource($team);

    }

    public function updateTeam($request):object{

        if (!$this->isAccessToTeam($request->team_id)){
            return response()->json(['error' => 'Нет доступа'], 403);
        }

        $data = $request->all();
        $data->coords = json_encode($data->coords);

        $team = $this->store($data);

        return new TeamResource($team);

    }

    public function deleteTeam($team_id){
        if (!$this->isAccessToTeam($team_id)){
            return response()->json(['error' => 'Нет доступа'], 403);
        }

        Team::find($team_id)->delete();
    }

    public function addInvitation(int $team_id, object $request){
        if (!$this->isAccessToTeam($team_id)){
            return response()->json(['error' => 'Нет доступа'], 403);
        }

        $this->addPersonToTeam($request->user_id, $team_id);

        return $this->getTeamInvitations($team_id);
    }

    public function acceptInvitation(int $team_id, object $request){

        return $this->acceptInvitationToTeam($request->user_id, $team_id);

    }

    public function addPoints(int $team_id, $request){

        if (!$this->isAccessToTeamForPeronsList($team_id)){
            return response()->json(['error' => 'Нет доступа'], 403);
        }

        $points = $request->points;

        foreach($points as $point){
            $this->addTeamPoint($team_id, $point);
        }

        return PointResource::collection($this->getTeamPoints($team_id));

    }

    public function deletePoints(int $team_id, $request){

        if (!$this->isAccessToTeamForPeronsList($team_id)){
            return response()->json(['error' => 'Нет доступа'], 403);
        }

        $points = $request->points;

        foreach($points as $point){
            $this->deleteTeamPoint($team_id, $point);
        }

        return PointResource::collection($this->getTeamPoints($team_id));

    }

}