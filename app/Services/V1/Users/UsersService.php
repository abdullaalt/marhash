<?php

namespace App\Services\V1\Users;

use App\Models\User;
use App\Models\TeamsUsersBind;
//use App\Models\instCard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Services\V1\Teams\TeamsItemsService;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Http\Resources\V1\UserResource;
use App\Http\Resources\V1\TeamResource;

/*
 * 
 */
class UsersService{

    protected function generatePassword($password){
        return Hash::make($password);
    }

    protected function createUser($user){
        $user = User::create($user);
        return $user->id;
    }

    public function isAdmin($user_id = false){

        $user_id = $user_id ? $user_id : Auth::id();
        //$group = 

    }

    public function getUser($user_id = false, $get_admin_data = true){

        $user_id = $user_id ? $user_id : Auth::id();

        $invs = TeamsUsersBind::where('user_id', $user_id)->where('status', 0)->get();

        $teams = [];
        foreach ($invs as $inv){
            $teams[] = $inv->team;
        }

        $teamsItemsService = new TeamsItemsService();

        return [
            'user' => new UserResource(User::getUser($user_id)),
            'invs' => TeamResource::collection($teams),
            'teams' => $teamsItemsService->getUserTeams($user_id, true)
        ];

    }

}