<?php

namespace App\Repositories\Tenant;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Models\Tenant;

class TenantRepository extends BaseRepository implements TenantRepositoryInterface
{
    public function model()
    {
        return Tenant::class;
    }
}
