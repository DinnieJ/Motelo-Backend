<?php

namespace App\Repositories\OwnerContact;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Models\OwnerContact;

class OwnerContactRepository extends BaseRepository implements OwnerContactRepositoryInterface
{
    public function model()
    {
        return OwnerContact::class;
    }
}
