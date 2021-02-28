<?php


namespace App\Repositories\RoomComment;


use App\Models\RoomComment;
use Prettus\Repository\Eloquent\BaseRepository;

class RoomCommentRepository extends BaseRepository implements RoomCommentRepositoryInterface
{

    public function model()
    {
        // TODO: Implement model() method.
        return RoomComment::class;
    }
}
