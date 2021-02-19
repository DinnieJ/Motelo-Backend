<?php

namespace App\Repositories\Owner;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Models\Owner;

class OwnerRepository extends BaseRepository implements OwnerRepositoryInterface
{
    public function model()
    {
        return Owner::class;
    }
}
