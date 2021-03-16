<?php


namespace App\Repositories\RoomImage;


use App\Models\RoomImage;
use Prettus\Repository\Eloquent\BaseRepository;

class RoomImageRepository extends BaseRepository implements RoomImageRepositoryInterface
{


    public function model()
    {
        // TODO: Implement model() method.
        return RoomImage::class;
    }
}
