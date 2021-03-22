<?php


namespace App\Traits;


use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

trait UpdateHelper
{

    public function updateFeatures($new_features, $inn_id)
    {
        $old_features = $this->innFeatureRepository->where('inn_id', $inn_id)->pluck('inn_feature_id')->toArray();

        $diff_new_vs_old = array_diff($new_features, $old_features);
        $diff_old_vs_new = array_diff($old_features, $new_features);

        $diff_array = array_merge($diff_old_vs_new, $diff_new_vs_old);
        if (!empty($diff_array))
            foreach ($diff_array as $value) {
                //add features
                if (!in_array($value, $old_features)) {
                    $this->innFeatureRepository->create([
                        'inn_id' => $inn_id,
                        'inn_feature_id' => $value
                    ]);
                }
                //delete features
                if (!in_array($value, $new_features)) {
                    $feature = $this->innFeatureRepository->where([
                        'inn_id' => $inn_id,
                        'inn_feature_id' => $value
                    ])->delete();
                }
            }
    }

    public function uploadInnImages($new_images, $inn_id)
    {
        foreach ($new_images as $image) {
            try {
                $uploadImg = Storage::disk('s3')->put("/inns/{$inn_id}", $image);
                $s3FileName = $this->getS3Filename($uploadImg);
                $this->innImageRepository->create([
                    'inn_id' => $inn_id,
                    'image_url' => Config::get('filesystems.s3_folder_path') . $uploadImg,
                    'filename' => $s3FileName
                ]);
            } catch (\Exception $exception) {
                return $exception->getMessage();
            }
        }
    }

    public function deleteInnImages($image_ids, $inn_id)
    {
        foreach ($image_ids as $id) {
            try {
                $image = $this->innImageRepository->where('id', $id);
                Storage::disk('s3')->delete("/inns/{$inn_id}/{$image->get()->pluck('filename')->first()}");
                $image->delete();
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }
    }
}
