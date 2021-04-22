<?php


namespace App\Repositories\OwnerImage;

use App\Models\OwnerImage;
use Prettus\Repository\Eloquent\BaseRepository;

class OwnerImageRepository extends BaseRepository implements OwnerImageRepositoryInterface
{
    public function model()
    {
        // TODO: Implement model() method.
        return OwnerImage::class;
    }
}
