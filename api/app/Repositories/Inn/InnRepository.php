<?php


namespace App\Repositories\Inn;


use App\Models\Inn;
use Prettus\Repository\Eloquent\BaseRepository;

class InnRepository extends BaseRepository implements InnRepositoryInterface
{

    public function model()
    {
        // TODO: Implement model() method.
        return Inn::class;
    }
}
