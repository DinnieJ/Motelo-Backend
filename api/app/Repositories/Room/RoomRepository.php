<?php


namespace App\Repositories\Room;

use App\Models\Room;
use App\Models\RoomFavorite;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;

class RoomRepository extends BaseRepository implements RoomRepositoryInterface
{

    public function model()
    {
        // TODO: Implement model() method.
        return Room::class;
    }

    public function searchByRequest($request)
    {
        $query = $this->with(['inn', 'inn.owner', 'inn.features']);
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query = $query->where('title', 'LIKE', '%' . $keyword . '%')
                ->orWhereHas('inn', function ($q) use ($keyword) {
                    $q->where('name', 'LIKE', '%' . $keyword . '%');
                });
        }

        if ($request->filled('gender')) {
            $query = $query->where('gender_type_id', $request->gender);
        }

        if ($request->filled('room_type')) {
            $roomTypeArr = \explode(',', $request->room_type);
            $query = $query->whereIn('room_type_id', $roomTypeArr);
        }

        if ($request->filled('min_price')) {
            $query = $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query = $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('features')) {
            $featuresData = \explode(',', $request->features);
            $query = $query->whereHas('inn.features', function ($q) use ($featuresData) {
                $q->whereIn('inn_feature_id', $featuresData);
            });
        }

        if ($request->filled('verified') && $request->verified) {
            $query = $query->where('verified', 1);
        }

        $data = $query->paginate(4)->withQueryString();
        return $data;
    }

    public function getRoomInformation($room_id, $tenant_id = null)
    {
        $withConditions = [
            'inn.features.type' => function () use ($room_id) {
            },
            'inn.owner.contacts' => function () {
            },
            'comments' => function ($query) use ($room_id) {
                $query->orderBy('created_at', 'DESC')->limit(5);
            }
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

    public function getTop4FavoritesRoom()
    {

        $getTopFourID = RoomFavorite::select('room_id', DB::raw(' COUNT(room_id) AS Total'))
            ->groupBy('room_id')
            ->limit(4)->pluck('room_id')->toArray();
        $getTopFourRoom = $this->with('inn')->whereIn('id', $getTopFourID)->get()->toArray();
        return $getTopFourRoom;
    }

    public function findLatestRoom()
    {
        $latest_rooms = $this->with('inn')->orderBy('created_at', 'DESC')
            ->limit(4)
            ->get()->toArray();
        return $latest_rooms;

    }

    public function findVerifiedRoom()
    {
        $verified_rooms = $this->with('inn')->where('verified', 1)
            ->inRandomOrder()
            ->limit(6)
            ->get()
            ->toArray();
        return $verified_rooms;
    }

    public function getFavoritesRoomByTenant($tenant_id)
    {
        $favorites_room_id = RoomFavorite::select('room_id')
            ->where('tenant_id', $tenant_id)
            ->pluck('room_id')
            ->toArray();
        $favorites_rooms = $this->with('inn')->whereIn('id', $favorites_room_id)->paginate(2);
        return $favorites_rooms;
    }
}
