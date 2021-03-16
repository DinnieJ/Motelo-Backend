<?php

namespace App\Http\Controllers\Utility;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UtilityImage\UtilityImageRepositoryInterface;
use App\Repositories\Utility\UtilityRepositoryInterface;
use App\Traits\FileHelper;
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

    public function create(Request $request)
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
}
