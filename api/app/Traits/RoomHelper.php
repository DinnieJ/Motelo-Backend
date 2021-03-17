<?php


namespace App\Traits;


use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

trait RoomHelper
{

    public function uploadRoomImages($images, $room_id)
    {
        foreach ($images as $img) {
            $uploadImg = null;
            try {
                $uploadImg = Storage::disk('s3')->put("/rooms/{$room_id}", $img);
                $s3FileName = $this->getS3Filename($uploadImg);
                $this->roomImageRepository->create([
                    'room_id' => $room_id,
                    'image_url' => Config::get('filesystems.s3_folder_path') . $uploadImg,
                    'filename' => $s3FileName
                ]);
            } catch (\Exception $exception) {
                return $exception->getMessage();
            }
        }
    }
}
