<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MstFeatureType extends Model
{
    //
    protected $table = "mst_feature_type";

    protected $fillable = [
        'id', 'title', 'description', 'icon'
    ];




}
