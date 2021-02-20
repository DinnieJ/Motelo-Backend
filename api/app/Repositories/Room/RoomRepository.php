<?php


namespace App\Repositories\Room;


use App\Models\Room;
use Prettus\Repository\Eloquent\BaseRepository;

class RoomRepository extends BaseRepository implements RoomRepositoryInterface
{

    public function model()
    {
        // TODO: Implement model() method.
        return Room::class;
    }
}
