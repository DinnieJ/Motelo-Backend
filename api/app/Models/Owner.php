<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Owner extends Authenticatable implements JWTSubject
{
    use Notifiable;
    
    protected $table = "tb_owner";

    protected $fillable = [
        'name', 'email', 'password', 'date_of_birth', 'enabled', 'address'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

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
        return [
            'role' => 'owner'
        ];
    }

    public function contacts()
    {
        return $this->hasMany(\App\Models\OwnerContact::class, 'owner_id');
    }
}
