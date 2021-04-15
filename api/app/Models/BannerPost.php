<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerPost extends Model
{
    protected $table = 'tb_banner_post';
    
    protected $fillable = [
        'title', 'url', 'start_time', 'end_time'
    ];

    const STATUS_EXPIRED = 2;
    const STATUS_FUTURE = 3;
    const STATUS_CURRENT = 1;
    const STATUS_ALL = 0;

    public function image()
    {
        return $this->hasOne(BannerPostImage::class, 'banner_id');
    }
}
