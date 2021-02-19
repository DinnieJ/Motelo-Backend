<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OwnerImage extends Model
{
    protected $table = 'tb_owner_image';

    protected $fillable = [
        'owner_id', 'original_filename', 'image_url', 'filename'
    ];
}
