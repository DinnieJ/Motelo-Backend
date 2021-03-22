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

    public function deleteRoomImages($image_ids, $room_id)
    {
        foreach ($image_ids as $id) {
            try {
                $image = $this->roomImageRepository->where('id', $id);
                Storage::disk('s3')->delete("/rooms/{$room_id}/{$image->get()->pluck('filename')->first()}");
                $image->delete();
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }
    }
}
