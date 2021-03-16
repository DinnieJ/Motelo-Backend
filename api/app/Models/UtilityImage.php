<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UtilityImage extends Model
{
    protected $table = "tb_utility_image";

    protected $fillable = [
        'utility_id', 'image_url', 'filename'
    ];
}
