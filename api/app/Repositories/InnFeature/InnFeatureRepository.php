<?php


namespace App\Repositories\InnFeature;


use App\Models\InnFeature;
use App\Repositories\Inn\InnRepositoryInterface;
use Prettus\Repository\Eloquent\BaseRepository;

class InnFeatureRepository extends BaseRepository implements InnFeatureRepositoryInterface

{

    public function model()
    {
        // TODO: Implement model() method.
        return InnFeature::class;
    }
}
