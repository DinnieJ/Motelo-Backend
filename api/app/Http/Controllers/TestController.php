<?php

namespace App\Http\Controllers;

use Storage;
use Illuminate\Http\Request;
use App\Traits\FileHelper;
use App\Repositories\RoomImage\RoomImageRepositoryInterface;

class TestController extends Controller
{
    use FileHelper;

    private $roomImageRepo;
    public function __construct(RoomImageRepositoryInterface $roomImageRepo)
    {
        $this->roomImageRepo = $roomImageRepo;
    }

    public function tenantTest()
    {
        return 'tenant';
    }

    public function ownerTest()
    {
        return 'owner';
    }

    public function uploadFile(Request $request)
    {
        $images = $request->file('images');
        $room_id = $request->room_id;
        foreach ($images as $img) {
            $originalName = $img->getClientOriginalName();
            $uploadImg = null;

            try {
                $uploadImg = Storage::disk('s3')->put("/rooms/{$room_id}", $img);
                $s3FileName = $this->getS3Filename($uploadImg);
                $this->roomImageRepo->create([
                    'room_id' => $room_id,
                    'image_url' => \Config::get('filesystems.s3_folder_path') . $uploadImg,
                    'filename' => $s3FileName
                ]);
            } catch (\Exception $e) {
                return $e;
            }
        }

        return response()->json([
            'message' => 'Success'
        ], 200);
    }
}
