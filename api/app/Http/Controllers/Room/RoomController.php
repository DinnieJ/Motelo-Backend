<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Requests\Room\CreateRoomRequest;
use App\Http\Resources\ListRoomBasic;
use App\Http\Resources\RoomCardResource;
use App\Http\Resources\RoomDetailResource;
use App\Http\Resources\ListRoomCardResource;
use App\Http\Requests\Room\ListRoomRequest;
use App\Repositories\Inn\InnRepositoryInterface;
use App\Repositories\Room\RoomRepositoryInterface;
use App\Repositories\RoomImage\RoomImageRepositoryInterface;
use App\Traits\FileHelper;
use App\Traits\RoomHelper;
use Illuminate\Http\Request;


class RoomController extends BaseController
{
    //
    protected $roomRepository;
    protected $innRepository;
    protected $roomImageRepository;
    use FileHelper;
    use RoomHelper;

    /**
     * RoomController constructor.
     * @param $roomRepository
     * @param $innRepository
     * @param $roomImageRepository
     */
    public function __construct(RoomRepositoryInterface $roomRepository,
                                InnRepositoryInterface $innRepository,
                                RoomImageRepositoryInterface $roomImageRepository)
    {
        $this->roomRepository = $roomRepository;
        $this->innRepository = $innRepository;
        $this->roomImageRepository = $roomImageRepository;
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

    public function getRoomsByOwner(Request $request)
    {
        $inn_id = auth('owner')->user()->inn->id;
        $rooms = $this->roomRepository->getRoomsByOwner($inn_id);
        if ($rooms) {
            $rooms = $rooms->toArray();
            return response()->json(new ListRoomBasic($rooms), 200);

        }
    }

    public function getRoomsByQuery(ListRoomRequest $request)
    {
        $data = $this->roomRepository->searchByRequest($request, auth('tenant')->user());

        return response()->json(new ListRoomCardResource($data->toArray()), 200);
    }

    public function getRoomsByMostFavorite(Request $request)
    {
        $tenant = auth('tenant')->user();

        $data = $this->roomRepository->findTopFavoritesRoom($tenant);

        $return_data = array_map(function ($value) {
            return new RoomCardResource($value);
        }, $data);

        return response()->json($return_data, 200);
    }

    public function getLatestRoom(Request $request)
    {
        $tenant = auth('tenant')->user();

        $rooms = $this->roomRepository->findLatestRoom($tenant);

        $return_data = array_map(function ($value) {
            return new RoomCardResource($value);
        }, $rooms);
        return response()->json($return_data, 200);
    }

    public function getVerfiedRoom(Request $request)
    {
        $tenant = auth('tenant')->user();

        $verfiedRooms = $this->roomRepository->findVerifiedRoom($tenant);

        $return_data = array_map(function ($value) {
            return new RoomCardResource($value);
        }, $verfiedRooms);

        return response()->json($return_data, 200);
    }

    public function getFavoritesByUser(Request $request)
    {
        $tenant_id = auth('tenant')->user()->id;

        $favorites_room = $this->roomRepository->getFavoritesRoomByTenant($tenant_id);

        return response()->json(new ListRoomCardResource($favorites_room->toArray()), 200);
    }

    public function createNewRoom(CreateRoomRequest $request)
    {

        $inn_id = auth('owner')->user()->inn->id;
        $room_data = $request->only('title',
            'room_type_id', 'price',
            'acreage', 'description',
            'gender_type_id');

        $room_images = $request->file('images');

        try {
            $new_room = $this->roomRepository->create([
                'title' => $room_data['title'],
                'inn_id' => $inn_id,
                'room_type_id' => $room_data['room_type_id'],
                'price' => $room_data['price'],
                'acreage' => $room_data['acreage'],
                'description' => $room_data['description'],
                'verified' => 0,
                'verified_at' => null,
                'available' => 1,
                'status' => 1,
                'gender_type_id' => $room_data['gender_type_id']
            ]);
            //upload img
            $this->uploadRoomImages($room_images, $new_room->id);

            return response()->json([
                'message' => 'Đăng phòng thành công'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()

            ]);
        }
    }

}
