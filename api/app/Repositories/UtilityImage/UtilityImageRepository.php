<?php

namespace App\Repositories\UtilityImage;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Models\UtilityImage;

class UtilityImageRepository extends BaseRepository implements UtilityImageRepositoryInterface
{
    public function model()
    {
        return UtilityImage::class;
    }
}
