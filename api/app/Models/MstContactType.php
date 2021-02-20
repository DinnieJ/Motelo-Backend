<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MstContactType extends Model
{
    protected $table = "mst_contact_type";

    protected $fillable = [
        'title', 'icon'
    ];
}
