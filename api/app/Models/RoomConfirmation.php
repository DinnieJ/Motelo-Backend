<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomConfirmation extends Model
{
    protected $table = "tb_room_confirmation";

    protected $fillable = [
        'owner_id', 'room_id', 'status', 'reject_description', 'confirmed_by'
    ];
    
    const ACCEPT_ROOM = 1;
    const REJECT_ROOM = 2;

    public function collaborator()
    {
        return $this->belongsTo(Collaborator::class, 'confirmed_by');
    }
}
