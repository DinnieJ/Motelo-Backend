<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    //
    protected $table = 'tb_room';
    protected $fillable = [
        'title', 'inn_id', 'room_type_id', 'price', 'acreage', 'description', 'verified', 'verified_at', 'available', 'status'
    ];

    public function inns()
    {
        return $this->belongsTo(Inn::class, 'inn_id');
    }


}
