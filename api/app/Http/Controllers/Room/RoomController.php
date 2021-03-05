<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Resources\RoomCardResource;
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

    public function getRoomsByMostFavorite(Request $request)
    {
        $data = $this->roomRepository->getTop4FavoritesRoom();
        $return_data = array_map(function ($value) {
            return new RoomCardResource($value);
        }, $data);
        return response()->json($return_data, 200);

    }

    public function getLatestRoom(Request $request)
    {
        $rooms = $this->roomRepository->findLatestRoom();
        $return_data = array_map(function ($value) {
            return new RoomCardResource($value);
        }, $rooms);
        return response()->json($return_data, 200);
    }

    public function getVerfiedRoom(Request $request)
    {
        $verfiedRooms = $this->roomRepository->findVerifiedRoom();
        $return_data = array_map(function ($value) {
            return new RoomCardResource($value);
        }, $verfiedRooms);
        return response()->json($return_data, 200);
    }

    public function getFavoritesByUser(Request $request)
    {
        $tenant_id = auth('tenant')->user()->id;

        $favorites_room = $this->roomRepository->getFavoritesRoomByTenant($tenant_id);
        foreach ($favorites_room as &$item) {
            $item['favorited'] = isset($item['favorites']) && count($item['favorites']);
        }
        return response()->json(new ListRoomCardResource($favorites_room->toArray()), 200);

    }


}
