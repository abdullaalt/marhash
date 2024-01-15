<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class Point extends Authenticatable
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
        'user_id',
        'address',
        'coords',
        'who',
        'action'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function TeamsPointsBind(){
        return $this->hasOne(TeamsPointsBind::class);
    }

    static function getUserPoints(int $user_id):object{

        return self::where('user_id', $user_id)->get();

    }

    
}

