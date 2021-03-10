<?php

namespace App\Http\Controllers\Inn;


use App\Http\Requests\Inn\CreateInnRequest;
use App\Http\Resources\InnDetailResource;
use App\Repositories\Inn\InnRepositoryInterface;
use App\Repositories\InnFeature\InnFeatureRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Support\Facades\DB;


class InnController extends BaseController
{
    //
    private $innRepository;
    private $innFeatureRepository;

    /**
     * InnController constructor.
     * @param $innRepository
     * @param $innFeatureRepository
     */
    public function __construct(
        InnRepositoryInterface $innRepository,
        InnFeatureRepositoryInterface $innFeatureRepository)
    {
        $this->innRepository = $innRepository;
        $this->innFeatureRepository = $innFeatureRepository;
    }


    public function getDetailInn(Request $request, $id)
    {

        $inn = $this->innRepository->with(['rooms', 'features'])->find($id);

        if (!$inn) {
            return response()->json(null, 404);
        }
        return response()->json(new InnDetailResource($inn), 200);
    }

    public function createNewInn(CreateInnRequest $request)
    {
        $owner = auth('owner')->user();
        $inn_data = $request->only('name',
            'water_price', 'electric_price',
            'open_hour', 'open_minute',
            'close_hour', 'close_minute',
            'features',
            'description', 'address',
            'location', 'status');

        $location = $inn_data['location'];
        try {
            $new_inn = $this->innRepository->create([
                'name' => $inn_data['name'],
                'owner_id' => $owner->id,
                'water_price' => $inn_data['water_price'],
                'electric_price' => $inn_data['electric_price'],
                'open_hour' => ($inn_data['open_hour']),
                'open_minute' => $inn_data['open_minute'],
                'close_hour' => $inn_data['close_hour'],
                'close_minute' => $inn_data['close_minute'],
                'description' => $inn_data['description'],
                'address' => $inn_data['address'],
                'location' => DB::raw("(GeomFromText('POINT($location)'))"),
                'status' => $inn_data['status']
            ]);


            foreach ($inn_data['features'] ?? [] as $feature) {
                $this->innFeatureRepository->create([
                    'inn_id' => $new_inn->id,
                    'inn_feature_id' => $feature,
                ]);
            }
            return response()->json([
                'message' => 'Tạo nhà trọ mới thành công',
                'inn_id' => $new_inn->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Có lỗi xảy ra'
            ], 500);
        }
    }


}
