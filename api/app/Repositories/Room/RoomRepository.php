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
            $query = $query->where('room_type_id', $request->room_type);
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
        $data = $query->paginate(10)->withQueryString();
        return $data;
    }
}
