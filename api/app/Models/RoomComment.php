<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomComment extends Model
{
    //
    protected $table = 'tb_room_comment';
    protected $fillable = [
        'tenant_id', 'room_id'
    ];

    public function room()
    {
        $this->belongsTo(Room::class, 'room_id');
    }
}
