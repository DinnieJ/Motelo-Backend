<?php


namespace App\Repositories\BannerPostImage;

use App\Models\BannerPostImage;
use Prettus\Repository\Eloquent\BaseRepository;

class BannerPostImageRepository extends BaseRepository implements BannerPostImageRepositoryInterface
{
    public function model()
    {
        // TODO: Implement model() method.
        return BannerPostImage::class;
    }
}
