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

    public function updateRoomImages($new_images, $room_id)
    {
        $old_images = $this->roomImageRepository->where([
            'room_id' => $room_id
        ])->pluck('filename')->toArray();

        $diff_new_vs_old = array_diff($new_images, $old_images);
        $diff_old_vs_new = array_diff($old_images, $new_images);

        $diff_array = array_merge($diff_new_vs_old, $diff_old_vs_new);
        if (!empty($diff_array)) {
            foreach ($diff_array as $item) {
                //add new images
                if (!in_array($item, $old_images)) {
                    try {
                        $uploadImg = Storage::disk('s3')->put("/rooms/{$room_id}", $item);
                        $s3FileName = $this->getS3Filename($uploadImg);
                        $this->roomImageRepository->create([
                            'room_id' => $room_id,
                            'image_url' => Config::get('filesystems.s3_folder_path') . $uploadImg,
                            'filename' => $s3FileName
                        ]);

                    } catch (\Exception $e) {
                        return $e->getMessage();
                    }
                }
                //delete images
                if (!in_array($item, $new_images)) {
                    try {
                        $deleteImg = Storage::disk('s3')->delete("/rooms/{$room_id}/{$item}");
                        $this->roomImageRepository->where([
                            'room_id' => $room_id,
                            'filename' => $item
                        ])->delete();
                    } catch (\Exception $e) {
                        return $e->getMessage();
                    }
                }
            }
        }
    }
}
