<?php

namespace App\Http\Controllers\RoomFavorite;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Requests\RoomFavorite\FavoriteRoomRequest;
use App\Http\Resources\AddFavoriteRoomResponse;
use App\Repositories\RoomFavorite\RoomFavoriteRepositoryInterface;
use Illuminate\Http\Request;

class RoomFavoriteController extends BaseController
{
    //

    protected $roomFavoriteRepository;

    /**
     * RoomFavoriteController constructor.
     * @param $roomFavoriteRepository
     */
    public function __construct(RoomFavoriteRepositoryInterface $roomFavoriteRepository)
    {
        $this->roomFavoriteRepository = $roomFavoriteRepository;
    }

    public function addFavorite(FavoriteRoomRequest $request)
    {
        $tenant_id = auth('tenant')->user()->id;
        $room_id = intval($request->post('room_id'));

        $exist_fav = $this->roomFavoriteRepository->findWhere([
            'tenant_id' => $tenant_id,
            'room_id' => $room_id
        ])->first();

        if ($exist_fav) {
            return response()->json([
                'message' => 'Bạn đã thêm phòng này rồi'
            ]);
        }
        $new_fav = $this->roomFavoriteRepository->create([
            'tenant_id' => $tenant_id,
            'room_id' => $room_id
        ]);
        return response()->json(new AddFavoriteRoomResponse($new_fav), 200);
    }

    public function removeFavorite(FavoriteRoomRequest $request)
    {
        $tenant_id = auth('tenant')->user()->id;
        $room_id = $request->post('room_id');
        $exists_fav = $this->roomFavoriteRepository->findWhere([
            'tenant_id' => $tenant_id,
            'room_id' => $room_id
        ])->first();

        if ($exists_fav) {
            $exists_fav->delete();
            return response()->json([
                'message' => 'Đã gỡ khỏi danh sách yêu thích'
            ]);
        }
        return response()->json([
            'message' => 'Bạn đã gỡ phòng này rồi'
        ]);

    }


}
