<?php


namespace App\Repositories\Collaborator;

use App\Models\Collaborator;
use Prettus\Repository\Eloquent\BaseRepository;

class CollaboratorRepository extends BaseRepository implements CollaboratorRepositoryInterface
{
    public function model()
    {
        // TODO: Implement model() method.
        return Collaborator::class;
    }
}
