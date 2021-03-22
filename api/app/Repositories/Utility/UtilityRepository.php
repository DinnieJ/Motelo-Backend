<?php

namespace App\Repositories\Utility;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Models\Utility;

class UtilityRepository extends BaseRepository implements UtilityRepositoryInterface
{
    public function model()
    {
        return Utility::class;
    }

    public function getAllUtilities()
    {
        $data = $this->with('image')->get();
        
        return $data;
    }

    public function getUtility($id)
    {
        $data = $this->with(['image'])->where([
            'id' => $id
        ])->first();

        return $data;
    }
}
