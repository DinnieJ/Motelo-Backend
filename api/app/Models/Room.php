<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    //
    protected $table = 'tb_room';
    protected $casts = [
        'verified_at' => 'datetime:d-m-Y',
        'created_at' => 'datetime:d-m-Y',
        'updated_at' => 'datetime:d-m-Y'
    ];


    protected $fillable = [
        'title', 'inn_id', 'room_type_id', 'price', 'acreage', 'description', 'verified', 'verified_at', 'available', 'status', 'gender_type_id'
    ];


    public function inn()
    {
        return $this->belongsTo(Inn::class, 'inn_id');
    }

    public function comments()
    {
        return $this->hasMany(RoomComment::class, 'room_id');
    }

    public function favorites()
    {
        return $this->hasMany(RoomFavorite::class, 'room_id');
    }

    public function images()
    {
        return $this->hasMany(RoomImage::class, 'room_id');
    }

    public function firstImage()
    {
        return $this->hasOne(RoomImage::class, 'room_id');
    }
}
