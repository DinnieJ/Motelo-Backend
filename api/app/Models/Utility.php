<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Utility extends Model
{
    protected $table = "tb_utility";

    protected $fillable = [
        'utility_type_id', 'title', 'description', 'address', 'location', 'created_by_collaborator_id'
    ];

    public function image()
    {
        return $this->hasOne(UtilityImage::class, 'utility_id');
    }

    public function roomId()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}
