<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class RoomComment extends Model
{
    //
    protected $table = 'tb_room_comment';
    // protected $casts = [

    //     'created_at' => 'datetime:Y-m-d h:i:s',
    //     'updated_at' => 'datetime:Y-m-d h:i:s'
    // ];
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
