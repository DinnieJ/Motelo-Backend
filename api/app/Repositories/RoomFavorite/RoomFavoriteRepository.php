<?php


namespace App\Repositories\RoomFavorite;


use App\Models\RoomFavorite;
use Prettus\Repository\Eloquent\BaseRepository;

class RoomFavoriteRepository extends BaseRepository implements RoomFavoriteRepositoryInterface
{

    public function model()
    {
        // TODO: Implement model() method.
        return RoomFavorite::class;
    }
}
