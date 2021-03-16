<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Collaborator extends Authenticatable implements JWTSubject
{
    use Notifiable;
    
    protected $table = "tb_collaborator";

    protected $fillable = [
        'name', 'email', 'password', 'phone_number', 'address', 'date_of_birth', 'identity_number', 'enabled'
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
            'role' => 'collaborator'
        ];
    }
}
