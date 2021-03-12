<?php


namespace App\Traits;


trait FileHelper
{
    public function getS3Filename($filePath)
    {
        $pathSplited = explode('/', $filePath);
        return $pathSplited[count($pathSplited) - 1];
    }
}
