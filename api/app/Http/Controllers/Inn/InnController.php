<?php

namespace App\Http\Controllers\Inn;


use App\Http\Controllers\Controller as BaseController;
use App\Http\Requests\Inn\CreateInnRequest;
use App\Http\Requests\InnImage\UploadInnImageRequest;
use App\Http\Resources\InnDetailResource;
use App\Repositories\Inn\InnRepositoryInterface;
use App\Repositories\InnFeature\InnFeatureRepositoryInterface;
use App\Repositories\InnImage\InnImageRepositoryInterface;
use App\Traits\FileHelper;
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

    /**
     * InnController constructor.
     * @param $innRepository
     * @param $innFeatureRepository
     * @param $innImageRepository
     */
    public function __construct(InnRepositoryInterface $innRepository,
                                InnFeatureRepositoryInterface $innFeatureRepository,
                                InnImageRepositoryInterface $innImageRepository)
    {
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
                'message' => 'Có lỗi xảy ra'
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


    public function updateInn(Request $request)
    {
        $owner = auth('owner')->user();
        $inn_id = $request->post('inn_id');
        $inn_data = $request->only('name',
            'water_price', 'electric_price',
            'open_hour', 'open_minute',
            'close_hour', 'close_minute',
            'features', 'address',
            'location', 'status');

        $old_inn = $this->innRepository->find($inn_id);

        // update inn information
        if ($old_inn) {
            $location = $inn_data['location'];
            $new_inn = $this->innRepository->update([
                'name' => $inn_data['name'],
                'water_price' => $inn_data['water_price'],
                'electric_price' => $inn_data['electric_price'],
                'open_hour' => $inn_data['open_hour'],
                'open_minute' => $inn_data['open_minute'],
                'close_hour' => $inn_data['close_hour'],
                'close_minute' => $inn_data['close_minute'],
                'address' => $inn_data['address'],
                'location' => DB::raw("(GeomFromText('POINT($location)'))"),
                'status' => $inn_data['status'],
            ], $inn_id);
            // update inn features
            $this->updateFeatures($inn_data['features'], $inn_id);
            $this->updateImages($request->file('images'), $inn_id);

            return response()->json([
                'message' => "Cập nhật nhà trọ thành công",
            ], 200);

        }
        return response()->json([
            'message' => 'Không tìm thấy nhà trọ'
        ], 404);


    }


    public function updateFeatures($new_features, $inn_id)
    {
        $old_features = $this->innFeatureRepository->where('inn_id', $inn_id)->pluck('inn_feature_id')->toArray();

        $diff_new_vs_old = array_diff($new_features, $old_features);
        $diff_old_vs_new = array_diff($old_features, $new_features);
        
        if (!empty($diff_new_vs_old)) {
            foreach ($diff_new_vs_old as $value) {
                //add new features
                if (!in_array($value, $old_features)) {
                    $this->innFeatureRepository->create([
                        'inn_id' => $inn_id,
                        'inn_feature_id' => $value
                    ]);
                }
            }
        }

        if (!empty($diff_old_vs_new)) {
            foreach ($diff_old_vs_new as $value) {
                if (!in_array($value, $new_features)) {
                    //delete features
                    $feature = $this->innFeatureRepository->where([
                        'inn_id' => $inn_id,
                        'inn_feature_id' => $value
                    ])->delete();
                }
            }
        }
    }

    public function updateImages($new_images, $inn_id)
    {
        $old_images = $this->innImageRepository->where([
            'inn_id' => $inn_id
        ])->pluck('filename')->toArray();


        $diff_new_vs_old = array_diff($new_images, $old_images);
        $diff_old_vs_new = array_diff($old_images, $new_images);


        //add new images
        if (!empty($diff_new_vs_old)) {
            foreach ($diff_new_vs_old as $value) {
                if (!in_array($value, $old_images)) {
                    try {
                        $uploadImg = Storage::disk('s3')->put("/inns/{$inn_id}", $value);
                        $s3FileName = $this->getS3Filename($uploadImg);
                        $this->innImageRepository->create([
                            'inn_id' => $inn_id,
                            'image_url' => Config::get('filesystems.s3_folder_path') . $uploadImg,
                            'filename' => $s3FileName
                        ]);
                    } catch (\Exception $e) {
                        return $e->getMessage();
                    }

                }
            }
        }


        //detele images
        if (!empty($diff_old_vs_new)) {
            foreach ($diff_old_vs_new as $value) {
                if (!in_array($value, $new_images)) {
                    try {
                        $uploadImg = Storage::disk('s3')->delete("/inns/{$inn_id}/{$value}");
                        $this->innImageRepository->where([
                            'inn_id' => $inn_id,
                            'filename' => $value
                        ])->delete();
                    } catch (\Exception $e) {
                        return $e->getMessage();
                    }

                }
            }
        }


    }


}
