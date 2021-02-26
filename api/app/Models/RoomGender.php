<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomGender extends Model
{
    //
    protected $table = 'tb_room_gender';

    protected $fillable = [
        'room_id', 'gender_type_id'
    ];

    public function type()
    {
        return $this->belongsTo(MstGenderType::class , 'gender_type_id');
    }

}
