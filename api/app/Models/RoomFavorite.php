<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomFavorite extends Model
{
    //
    protected $table = 'tb_room_favorite';

    protected $fillable = [
        'tenant_id', 'room_id'
    ];

    public function tenants()
    {
        return $this->hasMany(Tenant::class, 'id', 'tenant_id');
    }
}
