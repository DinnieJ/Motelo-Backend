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

    public function searchByRequest($request, $tenant = null)
    {
        $query = $this->with(['inn', 'inn.owner', 'inn.features', 'firstImage']);

        if ($tenant) {
            $query = $query->with(['favorites' => function ($query) use ($tenant) {
                return $query->whereHas('tenants', function ($tQuery) use ($tenant) {
                    return $tQuery->where('id', $tenant->id);
                })->get();
            }]);
        }
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query = $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', '%' . $keyword . '%')
                  ->orWhereHas('inn', function ($q) use ($keyword) {
                      $q->where('name', 'LIKE', '%' . $keyword . '%');
                  });
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
            foreach ($featuresData as $data) {
                $query = $query->whereHas('inn.features', function ($q) use ($data) {
                    $q->where('inn_feature_id', $data);
                });
            }
        }

        if ($request->filled('verified') && $request->verified) {
            $query = $query->where('verified', 1);
        }
        //dd($query->toSql());

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
            },
            'images' => function ($query) {
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

    public function findTopFavoritesRoom($tenant = null)
    {
        $topFavoriteRoomIds = RoomFavorite::select('room_id', DB::raw(' COUNT(room_id) AS Total'))
            ->groupBy('room_id')
            ->limit(4)
            ->pluck('room_id')
            ->toArray();

        $topFavoriteRooms = $this->with(['inn', 'firstImage']);
        if ($tenant) {
            $topFavoriteRooms = $topFavoriteRooms->with(['favorites' => function ($query) use ($tenant) {
                if ($tenant) {
                    return $query->whereHas('tenants', function ($tQuery) use ($tenant) {
                        return $tQuery->where('id', $tenant->id);
                    })->get();
                }
            }]);
        }

        $topFavoriteRooms = $topFavoriteRooms
            ->whereIn('id', $topFavoriteRoomIds)
            ->get()
            ->toArray();
        return $topFavoriteRooms;
    }

    public function findLatestRoom($tenant = null)
    {
        $latest_rooms = $this->with(['inn', 'firstImage']);

        if ($tenant) {
            $latest_rooms = $latest_rooms->with(['favorites' => function ($query) use ($tenant) {
                return $query->whereHas('tenants', function ($tQuery) use ($tenant) {
                    return $tQuery->where('id', $tenant->id);
                })->get();
            }]);
        }

        $latest_rooms = $latest_rooms->orderBy('created_at', 'DESC')
            ->limit(4)
            ->get()
            ->toArray();

        return $latest_rooms;
    }

    public function findVerifiedRoom($tenant = null)
    {
        $verifiedRooms = $this->with(['inn', 'firstImage']);

        if ($tenant) {
            $verifiedRooms = $verifiedRooms->with(['favorites' => function ($query) use ($tenant) {
                return $query->whereHas('tenants', function ($tQuery) use ($tenant) {
                    return $tQuery->where('id', $tenant->id);
                })->get();
            }]);
        }

        $verifiedRooms = $verifiedRooms->where('verified', 1)
            ->inRandomOrder()
            ->limit(6)
            ->get()
            ->toArray();

        return $verifiedRooms;
    }

    public function getFavoritesRoomByTenant($tenant_id)
    {
        $favorites_room_id = RoomFavorite::select('room_id')
            ->where('tenant_id', $tenant_id)
            ->pluck('room_id')
            ->toArray();

        $withConditions = [
            'inn' => function ($query) {
            },
            'favorites' => function ($query) use ($favorites_room_id, $tenant_id) {
                $query->where([
                    'tenant_id' => $tenant_id,
                ])->whereIn('room_id', $favorites_room_id);
            },
            'firstImage' => function ($query) {
            }
        ];

        $favorites_rooms = $this->with($withConditions)->whereIn('id', $favorites_room_id)->paginate(4);
        return $favorites_rooms;
    }

    public function getRoomsByOwner($inn_id)
    {
        $withConditions = [
            'firstImage' => function ($query) {
            },
            'favorites' => function ($query) {
            }
        ];
        $rooms = $this->with($withConditions)->where([
            'inn_id' => $inn_id
        ])->paginate(8);
        return $rooms;
    }
}
