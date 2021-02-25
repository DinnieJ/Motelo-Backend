<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inn extends Model
{
    //
    protected $table = 'tb_inn';

    protected $fillable = [
        'name', 'owner_id', 'water_price', 'electric_price', 'description', 'address', 'location', 'status'
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class, 'inn_id');
    }

    public function features()
    {
        return $this->hasMany(InnFeature::class, 'inn_id');
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

}
