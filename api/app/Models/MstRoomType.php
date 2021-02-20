<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class MstRoomType extends Model
{
    protected $table = "mst_room_type";

    protected $fillable = [
        'title','description'
    ];
}
