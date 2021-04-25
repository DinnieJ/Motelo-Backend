<?php

namespace App\Http\Controllers\Inn;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Requests\Inn\CreateInnRequest;
use App\Http\Requests\Inn\UpdateInnRequest;
use App\Http\Requests\InnImage\UploadInnImageRequest;
use App\Http\Resources\BasicInnDetail;
use App\Http\Resources\InnDetailResource;
use App\Repositories\Inn\InnRepositoryInterface;
use App\Repositories\InnFeature\InnFeatureRepositoryInterface;
use App\Repositories\InnImage\InnImageRepositoryInterface;
use App\Traits\FileHelper;
use App\Traits\UpdateHelper;
use Faker\Calculator\Inn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class InnController extends BaseController
{
    //
    private $innRepository;
    private $innFeatureRepository;
    private $innImageRepository;

    use FileHelper;
    use UpdateHelper;

    /**
     * InnController constructor.
     * @param $innRepository
     * @param $innFeatureRepository
     * @param $innImageRepository
     */
    public function __construct(
        InnRepositoryInterface $innRepository,
        InnFeatureRepositoryInterface $innFeatureRepository,
        InnImageRepositoryInterface $innImageRepository
    ) {
        $this->innRepository = $innRepository;
        $this->innFeatureRepository = $innFeatureRepository;
        $this->innImageRepository = $innImageRepository;
    }


    public function getDetailInn(Request $request, $id)
    {
        $inn = $this->innRepository->findInnByID($id);

        if (!$inn) {
            return response()->json(null, 404);
        }
        return response()->json(new InnDetailResource($inn), 200);
    }

    public function getDetailInnByOwner(Request $request)
    {
        $inn_id = auth('owner')->user()->inn->id;

        $inn = $this->innRepository->findInnByOwner($inn_id);
        if (!$inn) {
            return response()->json(null, 404);
        }
        return response()->json(new BasicInnDetail($inn), 200);
    }

    public function createNewInn(CreateInnRequest $request)
    {
        $owner = auth('owner')->user();
        $inn_data = $request->only(
            'name',
            'water_price',
            'electric_price',
            'wifi_price',
            'open_hour',
            'open_minute',
            'close_hour',
            'close_minute',
            'features',
            'address',
            'location'
        );

        $latitude = $inn_data['location']['lat'];
        $longitude = $inn_data['location']['lng'];
        $location_point = $latitude . " " . $longitude;


        try {
            $new_inn = $this->innRepository->create([
                'name' => $inn_data['name'],
                'owner_id' => $owner->id,
                'water_price' => $inn_data['water_price'],
                'electric_price' => $inn_data['electric_price'],
                'wifi_price' => $inn_data['wifi_price'],
                'open_hour' => ($inn_data['open_hour']),
                'open_minute' => $inn_data['open_minute'],
                'close_hour' => $inn_data['close_hour'],
                'close_minute' => $inn_data['close_minute'],
                'address' => $inn_data['address'],
                'location' => DB::raw("(GeomFromText('POINT($location_point)'))"),
                'status' => 1
            ]);


            //insert features into tb_inn_feature
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
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function uploadImages(UploadInnImageRequest $request)
    {
        $images = $request->file('images');
        $inn_id = $request->post('inn_id');
        foreach ($images as $img) {
            $originalName = $img->getClientOriginalName();
            $uploadImg = null;

            try {
                $uploadImg = Storage::disk('s3')->put("/inns/{$inn_id}", $img);
                $s3FileName = $this->getS3Filename($uploadImg);
                $this->innImageRepository->create([
                    'inn_id' => $inn_id,
                    'image_url' => Config::get('filesystems.s3_folder_path') . $uploadImg,
                    'filename' => $s3FileName
                ]);
            } catch (\Exception $exception) {
                return $exception;
            }
        }
        return response()->json([
            'message' => 'Upload ảnh thành công'
        ], 200);
    }


    public function updateInn(UpdateInnRequest $request)
    {
        $owner = auth('owner')->user();
        $inn_id = $request->post('inn_id');
        $inn_data = $request->only(
            'name',
            'water_price',
            'electric_price',
            'wifi_price',
            'open_hour',
            'open_minute',
            'close_hour',
            'close_minute',
            'features',
            'address',
            'location',
            'new_images',
            'delete_images'
        );

        $old_inn = $this->innRepository->find($inn_id);

        // update inn information
        if ($old_inn) {
            $latitude = $inn_data['location'][0];
            $longitude = $inn_data['location'][1];
            $location_point = $latitude . " " . $longitude;

            $new_inn = $this->innRepository->update([
                'name' => $inn_data['name'],
                'water_price' => $inn_data['water_price'],
                'electric_price' => $inn_data['electric_price'],
                'wifi_price' => $inn_data['wifi_price'],
                'open_hour' => $inn_data['open_hour'],
                'open_minute' => $inn_data['open_minute'],
                'close_hour' => $inn_data['close_hour'],
                'close_minute' => $inn_data['close_minute'],
                'address' => $inn_data['address'],
                'location' => DB::raw("(GeomFromText('POINT($location_point)'))"),
                'status' => 1,
            ], $inn_id);
            // update inn features
            $this->updateFeatures($inn_data['features'], $inn_id);

            // update images
            $new_images = $inn_data['new_images'] ?? null;
            $image_ids = $inn_data['delete_images'] ?? null;

            if ($new_images) {
                //
                $this->uploadInnImages($new_images, $inn_id);
            }
            if ($image_ids) {
                $this->deleteInnImages($image_ids, $inn_id);
            }


            return response()->json([
                'message' => "Cập nhật nhà trọ thành công",
            ], 200);
        }
        return response()->json([
            'message' => 'Không tìm thấy nhà trọ'
        ], 404);
    }

    public function checkInnExists(Request $request)
    {
        $inn = auth('owner')->user()->inn;

        return response()->json([
            'exist' => $inn != null
        ], 200);
    }
}
