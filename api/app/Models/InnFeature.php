<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InnFeature extends Model
{
    //
    protected $table = 'tb_inn_feature';

    protected $casts = [

        'created_at' => 'datetime:d-m-Y',
        'updated_at' => 'datetime:d-m-Y'
    ];
    protected $fillable = [
        'inn_id', 'inn_feature_id'
    ];

    public function inn()
    {
        return $this->belongsTo(Inn::class, 'inn_id');
    }


}
