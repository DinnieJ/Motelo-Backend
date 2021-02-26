<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MstGenderType extends Model
{
    //
    protected $table = "mst_gender_type";

    protected $fillable = [
        'id', 'title', 'description'
    ];

}
