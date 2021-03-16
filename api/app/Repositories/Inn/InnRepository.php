<?php


namespace App\Repositories\Inn;


use App\Models\Inn;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;

class InnRepository extends BaseRepository implements InnRepositoryInterface
{

    public function model()
    {
        // TODO: Implement model() method.
        return Inn::class;
    }

    public function findInnByID($id)

    {
        $withConditions = [
            'rooms' => function ($query) {

            },
            'features' => function ($query) {

            }
        ];
        $inn = $this->select('*', DB::raw('ST_X(location) AS latitude , ST_Y(location) AS longitude'))
            ->where('id', $id)->with($withConditions)->first();
        return $inn;
    }

    public function findInnByOwner($inn_id)
    {
        $withConditions = [
            'features' => function ($query) {
            }
        ];
        $inn = $this->select('*', DB::raw('ST_X(location) AS latitude , ST_Y(location) AS longitude'))
            ->where('id', $inn_id)->with($withConditions)->first();
        return $inn;
    }
}
