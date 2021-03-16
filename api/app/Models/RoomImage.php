<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomImage extends Model
{
    //
    protected $table = 'tb_room_image';
    protected $fillable = [
        'room_id', 'image_url', 'filename'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}