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

    public function updateImages($new_images, $inn_id)
    {
        $old_images = $this->innImageRepository->where([
            'inn_id' => $inn_id
        ])->pluck('filename')->toArray();


        $diff_new_vs_old = array_diff($new_images, $old_images);
        $diff_old_vs_new = array_diff($old_images, $new_images);


        $diff_array = array_merge($diff_new_vs_old, $diff_old_vs_new);
        if (!empty($diff_array))
            foreach ($diff_array as $value) {
                //add new images
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
                //delete images
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
