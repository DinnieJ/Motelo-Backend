<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OwnerContact extends Model
{
    protected $table = 'tb_owner_contact';

    protected $fillable = [
        'contact_type_id', 'content'
    ];
}
