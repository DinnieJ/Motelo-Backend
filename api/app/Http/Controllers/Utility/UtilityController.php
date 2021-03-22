<?php

namespace App\Http\Controllers\Utility;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UtilityImage\UtilityImageRepositoryInterface;
use App\Repositories\Utility\UtilityRepositoryInterface;
use App\Traits\FileHelper;
use App\Http\Requests\Utility\CreateUtilityRequest;
use App\Http\Resources\UtilityResource;
use Storage;

class UtilityController extends Controller
{
    use FileHelper;

    private $utilityRepository;
    private $utilityImageRepository;

    public function __construct(
        UtilityRepositoryInterface $utilityRepository,
        UtilityImageRepositoryInterface $utilityImageRepository
    ) {
        $this->utilityRepository = $utilityRepository;
        $this->utilityImageRepository = $utilityImageRepository;
    }

    public function create(CreateUtilityRequest $request)
    {
        $data = $request->only('utility_type_id', 'title', 'description', 'address', 'location');
        $image = $request->file('image') ?? null;

        $collaborator_id = auth('collaborator')->user()->id;
        $location = $data['location'][0]. " " . $data['location'][1];
        try {
            $newUtility = $this->utilityRepository->create([
                'utility_type_id' => $data['utility_type_id'],
                'title' => $data['title'],
                'description' => $data['description'],
                'address' => $data['address'] ?? null,
                'location' => \DB::raw("(ST_GeomFromText('POINT($location)'))"),
                'created_by_collaborator_id' => $collaborator_id
            ]);
            if ($image) {
                $uploadImg = \Storage::disk('s3')->put("/utilities/{$newUtility->id}", $image);
                $s3Filename = $this->getS3Filename($uploadImg);
                $this->utilityImageRepository->create([
                    'utility_id' => $newUtility->id,
                    'image_url' => \Config::get('filesystems.s3_folder_path') . $uploadImg,
                    'filename' => $s3Filename
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong'
            ], 500);
        }

        return response()->json([
            'message' => 'Tạo tiện ích thành công'
        ], 200);
    }

    public function getAllUtility(Request $request)
    {
        $data = $this->utilityRepository->getAllUtilities();

        $responseData = array_map(function ($value) {
            return new UtilityResource($value);
        }, $data->toArray());

        return response()->json($responseData, 200);
    }

    public function edit(Request $request, $id)
    {
        $data = $request->except('image', 'location');
        $image = $request->file('image') ?? null;
        $location = $request->location && count($request->location) == 2 ? $request->location[0] . " " . $request->location[1] : null;

        $location = $location ? \DB::raw("ST_GeomFromText('POINT($location)')") : null;
        
        try {
            $utility = $this->utilityRepository->getUtility($id);

            if (!$utility) {
                throw new \Exception('Khong tim thay tien ich');
            }

            foreach ($data as $key => $value) {
                $utility->{$key} = $value;
            }
            if ($location) {
                $utility->location = $location;
            }
            
            $utility->save();

            if ($image) {
                $oldImg = $utility->image;
                
                if ($oldImg) {
                    $deleteImg = \Storage::disk('s3')->delete("/utilities/$utility->id/$oldImg->filename");
                    
                    $uploadImg = \Storage::disk('s3')->put("utilities/$utility->id", $image);

                    $s3FileName = $this->getS3Filename($uploadImg);
                    $this->utilityImageRepository->update([
                        'filename' => $s3FileName,
                        'image_url' => \Config::get('filesystems.s3_folder_path') . $uploadImg
                    ], $oldImg->id);
                } else {
                    $uploadImg = \Storage::disk('s3')->put("utilities/$utility->id", $image);

                    $s3FileName = $this->getS3Filename($uploadImg);

                    $this->utilityImageRepository->create([
                        'utility_id' => $utility->id,
                        'filename' => $s3FileName,
                        'image_url' => \Config::get('filesystems.s3_folder_path') . $uploadImg
                    ]);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Thay doi thong tin thanh cong'
        ], 200);
    }

    public function delete(Request $request, $id)
    {
        $utility = $this->utilityRepository->find($id);

        if ($utility) {
            try {
                $utility->delete();
            } catch (\Exception $e) {
                return response()->json([
                    'message' => $e->getMessage()
                ], 500);
            }
        }

        return response()->json([
            'message' => 'Xoa tien ich thanh cong'
        ], 200);
    }

    public function detail($id)
    {
        $data = $this->utilityRepository->getUtility($id);
        if ($data) {
            return response()->json(new UtilityResource($data), 200);
        }
        return response()->json(null, 404);
    }
}
