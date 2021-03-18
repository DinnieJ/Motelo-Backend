<?php


namespace App\Repositories\RoomConfirmation;

use App\Models\RoomConfirmation;
use Prettus\Repository\Eloquent\BaseRepository;

class RoomConfirmationRepository extends BaseRepository implements RoomConfirmationRepositoryInterface
{
    public function model()
    {
        // TODO: Implement model() method.
        return RoomConfirmation::class;
    }
}
