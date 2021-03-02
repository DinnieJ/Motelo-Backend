<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller as BaseController;
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
        $room = null;
        $tenant = auth('tenant')->user();

        if ($tenant) {
            $room = $this->roomRepository->getRoomInformation($id, $tenant->id);
        } else {
            $room = $this->roomRepository->getRoomInformation($id);
        }

        if ($room) {
            $room = $room->toArray();
            $room['favorited'] = isset($room['favorites']) && count($room['favorites']);
            return response()->json(new RoomDetailResource($room), 200);
        }
        return response()->json(null, 404);
    }

    public function getRoomsByQuery(ListRoomRequest $request)
    {
        $data = $this->roomRepository->searchByRequest($request);
        return response()->json(new ListRoomCardResource($data->toArray()), 200);
    }
}
