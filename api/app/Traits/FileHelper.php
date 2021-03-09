<?php

namespace App\Traits;

trait FileHelper
{
    public function getS3Filename($filepath)
    {
        $pathSplited = explode('/', $filepath);

        return $pathSplited[count($pathSplited) - 1];
    }
}
