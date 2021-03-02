<?php


namespace App\Repositories\Room;


use App\Models\Room;
use Prettus\Repository\Eloquent\BaseRepository;

class RoomRepository extends BaseRepository implements RoomRepositoryInterface
{

    public function model()
    {
        // TODO: Implement model() method.
        return Room::class;
    }

    public function getRoomInformation($room_id, $tenant_id = null)
    {


        $withConditions = [
            'inn.features.type' => function () use ($room_id) {},
            'inn.owner.contacts' => function () {},
            'comments' => function () use ($room_id) {}
        ];

        $room = $this->model->with($withConditions);
        if ($tenant_id) {
            $room = $room->with([
                'favorites' => function ($query) use ($room_id, $tenant_id) {
                    $query->where([
                        'tenant_id' => $tenant_id,
                        'room_id' => $room_id
                    ]);
                }
            ]);
        }
        $room = $room->where('id', $room_id)->first();
        return $room;


    }
}
