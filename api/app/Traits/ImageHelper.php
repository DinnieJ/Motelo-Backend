<?php


namespace App\Traits;


use App\Http\Resources\ImagesResource;

trait ImageHelper
{
    public function getImages($array)
    {
        $data = array_map(function ($value) {
            return new ImagesResource($value);
        }, $array);
        return $data;
    }
}
