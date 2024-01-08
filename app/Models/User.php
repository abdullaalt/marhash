<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'phone',
        'uuid',
        'password',
        'is_admin',
        'nickname',
        'is_admin',
        'group_id',
        'email'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    static function getUser($user_id){

        $user = self::where('users.id', $user_id)->leftJoin('users_groups', 'users.group_id', '=', 'users_groups.id')->
            leftJoin('users_models_binds', 'users.id', '=', 'users_models_binds.user_id')->
            select('users.*', 'users_models_binds.model_name', 'users_models_binds.item_id', 'users_groups.name', 'users_groups.title')->first()->toArray();
//dd($user);
        unset($user['password']);
        unset($user['remember_token']);

        return $user;

    }
}
