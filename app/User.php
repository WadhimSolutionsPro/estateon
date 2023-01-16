<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Hash;

/**
 * Class User
 *
 * @package App
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use HasRolesAndAbilities;

    protected $fillable = ['name', 'email', 'password', 'remember_token', 'phone', 'provider_name', 'provider_id', 'avatar', 'detail', 'login_by','slug', 'device_token', 'user_level'];

    protected $hidden = [
        'password', 'remember_token', 'device_token'
    ];

    /**
     * Hash password
     * @param $input
     */
    public function setPasswordAttribute($input)
    {
        if ($input)
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
    }
    public function routeNotificationForFcm()
    {
        return $this->device_token;
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new Notifications\MailResetPasswordNotification($token));
    }

    public function role()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function properties(){
        return $this->hasMany('App\Property', 'user_id');
    }
}
