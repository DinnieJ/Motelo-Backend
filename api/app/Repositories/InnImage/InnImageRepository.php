<?php


namespace App\Repositories\InnImage;



use App\Models\InnImage;
use Prettus\Repository\Eloquent\BaseRepository;

class InnImageRepository extends BaseRepository implements InnImageRepositoryInterface
{

    public function model()
    {
        // TODO: Implement model() method.
        return InnImage::class;
    }
}
