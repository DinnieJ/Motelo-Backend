<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerPostImage extends Model
{
    protected $table = 'tb_banner_image';

    protected $fillable = [
        'banner_id', 'image_url', 'filename'
    ];
}
