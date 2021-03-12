<?php

namespace App\Models;

use App\Models\Inn;
use Illuminate\Database\Eloquent\Model;

class InnImage extends Model
{
    //
    protected $table = 'tb_inn_image';
    protected $fillable = [
        'inn_id', 'image_url', 'filename'
    ];

    const S3_PATH = 'https://motelo-app.s3.ap-east-1.amazonaws.com/';

    public function inn()
    {
        return $this->belongsTo(Inn::class , 'inn_id');
    }
}
