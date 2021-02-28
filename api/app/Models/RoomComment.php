<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomComment extends Model
{
    //
    protected $table = 'tb_room_comment';
    protected $casts = [

        'created_at' => 'datetime:d-m-Y',
        'updated_at' => 'datetime:d-m-Y'
    ];
    protected $fillable = [
        'tenant_id', 'room_id' , 'comment'
    ];

    protected $appends = ['tenant_name'];

    public function room()
    {
        $this->belongsTo(Room::class, 'room_id');
    }

    public function getTenantNameAttribute()
    {
        $tenantInfo = $this->belongsTo(Tenant::class, 'tenant_id', 'id')->first();
        return $tenantInfo->name;

    }
}
