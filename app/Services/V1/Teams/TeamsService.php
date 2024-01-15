<?php

namespace App\Services\V1\Teams;

use App\Models\Team;
use App\Models\Point;
use App\Models\TeamsUsersBind;
use App\Models\TeamsPointsBind;

abstract class TeamsService{

    protected function store(object|array $data){

        if (isset($data['team_id'])){
            $team = Team::find($data['team_id']);
            $team->fill($data);
        }else{
            $team = new Team($data);
        }
        

        $team->save();

        return $team;

    }

    protected function getTeamPersons($team_id){
        return TeamsUsersBind::where('team_id', $team_id)->where('status', 1)->get();
    }

    public function addTeamPoint(int $team_id, int $point_id){
        if (TeamsPointsBind::where('point_id', $point_id)->exists()){
            return true;
        }

        $point = Point::find($point_id);

        if ($point->user_id != request()->user()->id){
            return false;
        }

        TeamsPointsBind::create([
            'point_id' => $point_id,
            'user_id' => $point->user_id,
            'team_id' => $team_id
        ]);
    }

    public function deleteTeamPoint(int $team_id, int $point_id){

        $point = Point::find($point_id);

        if (!$point) return true;

        if ($point->user_id != request()->user()->id){
            return false;
        }

        TeamsPointsBind::where('point_id', $point_id)->where('team_id', $team_id)->delete();
    }

    protected function getTeamInvitations($team_id){
        return TeamsUsersBind::where('team_id', $team_id)->where('status', 0)->get();
    }

    protected function addPersonToTeam(int $user_id, int $team_id, int $status = 0){

        if (TeamsUsersBind::where('user_id', $user_id)->where('team_id', $team_id)->exists()){
            return true;
        }

        TeamsUsersBind::create([
            'user_id' => $user_id,
            'team_id' => $team_id,
            'status' => $status
        ]);
    }

    protected function acceptInvitationToTeam(int $user_id, int $team_id){

        if ($user_id != request()->user()->id){
            return response()->json(['error' => 'Нет доступа'], 403);
        }

        if (!TeamsUsersBind::where('user_id', $user_id)->where('team_id', $team_id)->exists()){
            return response()->json(['error' => 'Нет доступа'], 403);
        }

        TeamsUsersBind::where('user_id', $user_id)->where('team_id', $team_id)->update(['status' => 1]);

        return response()->json([], 200);

    }

    protected function getTeam(int $team_id):object{

        return Team::find($team_id);

    }

    protected function removePersonFromTeam(int $team_id, int $user_id):bool{

        TeamsUsersBind::where('user_id', $user_id)->where('team_id', $team_id)->delete();
        TeamsPointsBind::where('user_id', $user_id)->where('team_id', $team_id)->delete();

        return true;

    }

    protected function isAccessToTeam(int $team_id):bool{
        $team = $this->getTeam($team_id);

        return $team->user_id == request()->user()->id;
    }

    protected function isAccessToTeamForPeronsList(int $team_id):bool{

        $team = $this->getTeam($team_id);

        if ($team->user_id == request()->user()->id) return true;

        $binds = $this->getTeamPersons($team_id);

        foreach ($binds as $key => $bind) {
            if ($bind->user_id == request()->user()->id){
                return true;
            }
        }

        return false;
    }

    protected function getTeamPoints(int $team_id):object{

        $binds = TeamsPointsBind::where('team_id', $team_id)->get();

        $ids = [];

        foreach ($binds as $key => $bind) {
            $ids[] = $bind->point_id;
        }

        return Point::whereIn('id', $ids)->get();

    }

}