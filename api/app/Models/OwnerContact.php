<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OwnerContact extends Model
{
    protected $table = 'tb_owner_contact';

    protected $fillable = [
        'contact_type_id', 'owner_id', 'content'
    ];

    const TYPE_EMAIL = 1;
    const TYPE_PHONE_NUMBER = 2;
    const TYPE_ZALO = 3;
    const TYPE_FACEBOOK = 4;

    public function owner()
    {
        return $this->belongsTo(\App\Models\Owner::class, 'owner_id');
    }
}
