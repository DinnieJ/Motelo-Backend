<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomImage extends Model
{
    protected $table = "tb_room_image";

    protected $fillable = [
        'room_id', 'image_url', 'filename',
    ];

    const S3_PATH = 'https://motelo-app.s3.ap-east-1.amazonaws.com';

    public function room()
    {
        return $this->belongsTo(Room::class, 'id', 'room_id');
    }
}
