<?php

namespace App\Models\Auth;

use App\Models\Attendance;
use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Auth\Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject as AuthenticatableUserContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Laravel\Passport\HasApiTokens;

class User extends EloquentUser implements AuthenticatableUserContract, AuthenticatableContract // implements JWTSubject // Authenticatable implements JWTSubject
{
    use Authenticatable, HasApiTokens;
    const last_login = null;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'id_users', 'id');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    public function getTokenAttribute($value)
    {
        if ($value == null) {
            return '';
        } else {
            return $value;
        }
    }
}
