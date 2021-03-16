<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Utility extends Model
{
    protected $table = "tb_utility";

    protected $fillable = [
        'utility_type_id', 'title', 'description', 'address', 'location', 'created_by_collaborator_id'
    ];
}
