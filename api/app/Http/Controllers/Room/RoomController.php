<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Resources\InnDetailResource;
use App\Http\Resources\RoomDetailResource;
use App\Http\Resources\ListRoomCardResource;
use App\Http\Requests\Room\ListRoomRequest;
use App\Repositories\Room\RoomRepositoryInterface;
use Illuminate\Http\Request;

class RoomController extends BaseController
{
    //
    protected $roomRepository;

    /**
     * RoomController constructor.
     * @param $roomRepository
     */
    public function __construct(RoomRepositoryInterface $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }

    public function getDetailRoom(Request $request, $id)
    {
        $room = $this->roomRepository->with(['inn.features.type', 'inn.owner.contacts', 'comments'])->find($id);

        if (!$room) {
            return response()->json(null, 404);
        }
        return response()->json(new RoomDetailResource($room), 200);
    }

    public function getRoomsByQuery(ListRoomRequest $request)
    {
        $data = $this->roomRepository->searchByRequest($request);
        return response()->json(new ListRoomCardResource($data->toArray()), 200);
    }
}
